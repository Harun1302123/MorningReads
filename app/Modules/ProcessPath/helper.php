<?php

use App\Models\IndRRCommonPool;
use App\Libraries\CommonFunction;
use App\Modules\CompanyAssociation\Models\CompanyAssociationMaster;
use App\Modules\IndustryNew\Http\Controllers\IndustryNewController;
use App\Modules\IndustryNew\Models\IndustryNew;
//ob#code@start - Harun - IndustryReRegistration class not found
use App\Modules\IndustryReRegistration\Models\IndustryReRegistration;
use App\Modules\ProcessPath\Models\ProcessList;
use App\Modules\Settings\Models\PdfPrintRequestQueue;
use App\Modules\Settings\Models\PdfServiceInfo;
use App\Modules\Users\Models\Users;
use App\Modules\ProcessPath\Services\IndustryCommonPoolManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Modules\SonaliPayment\Models\PaymentConfiguration;
use Illuminate\Support\Facades\Session;

/**
 * @param $json
 * @return string
 */
function getDataFromJson($json): string
{
    $jsonDecoded = json_decode($json);
    $string = '';
    foreach ($jsonDecoded as $key => $data) {
        $string .= $key . ":" . $data . ', ';
    }
    return $string;
}


/**
 * Here are the extras that work on a specific process type application or a specific status of the application.
 * Such as sending mail / sms to specific status, generating certificates in the final status or
 * updating any data in the specified status
 *
 * @param $process_list_id
 * @param $status_id
 * @param int $approver_desk_id
 * @param $requestData
 * @return bool
 * @throws Throwable
 */
function CertificateMailOtherData($process_list_id, $status_id, $requestData, $approver_desk_id = 0): bool
{
    $processInfo = ProcessList::leftJoin('process_type', 'process_type.id', '=', 'process_list.process_type_id')
        ->where('process_list.id', $process_list_id)
        ->first([
            'process_list.tracking_no',
            'process_type.id',
            'process_type.name as process_type_name',
            'process_list.ref_id',
            'process_list.company_id',
            'process_list.process_type_id',
            'process_list.office_id',
            'process_list.process_desc',
        ]);
    $receiverInfo = Users::where('working_company_id', $processInfo->company_id)
        ->where('user_status', 'active')
        ->get(['user_email', 'user_mobile']);

    $appInfo = [
        'app_id' => $processInfo->ref_id,
        'status_id' => $status_id,
        'process_type_id' => $processInfo->process_type_id,
        'tracking_no' => $processInfo->tracking_no,
        'process_type_name' => $processInfo->process_type_name,
        'remarks' => $requestData['remarks']
    ];

    if ($status_id == 5) {
        CommonFunction::sendEmailSMS('APP_SHORTFALL', $appInfo, $receiverInfo);
    } elseif ($status_id == 6) {
        CommonFunction::sendEmailSMS('APP_REJECT', $appInfo, $receiverInfo);
    }

    switch ($processInfo->process_type_id) {
        case 1: // Industry Reg
            if (in_array($status_id, ['15'])) {

                $govt_fees = 0;
                $payment_config = PaymentConfiguration::where([
                    'sp_payment_configuration.process_type_id' => $processInfo->process_type_id,
                    'sp_payment_configuration.payment_step_id' => 2,
                    'sp_payment_configuration.status' => 1,
                    'sp_payment_configuration.is_archive' => 0
                ])->first(['sp_payment_configuration.amount']);

                if (!empty($payment_config)) {
                    $govt_fees += $payment_config->amount;
                }

                $appData = IndustryNew::where('id', $appInfo['app_id'])->first(['ind_category_id']);
                $controllerObject = new IndustryNewController();
                $calculatedAmountArray = $controllerObject->unfixedAmountsForGovtApplicationFee($appData->ind_category_id, 2);
                $govt_fees += array_sum($calculatedAmountArray);

                $appInfo['govt_fees'] = $govt_fees;
                CommonFunction::sendEmailSMS('APP_APPROVE_AND_PAYMENT', $appInfo, $receiverInfo);
            } elseif (in_array($status_id, ['25'])) {
                ProcessList::where('id', $process_list_id)->update(['completed_date' => date('Y-m-d H:i:s')]);

                $applicationDistrict = IndustryNew::where('id', $processInfo->ref_id)->value('factory_district');
                $dist_name = CommonFunction::getDistrictFirstTwoChar($applicationDistrict);
                $registrationPrefix = $dist_name . '-' . date("Ymd") . '-';

                CommonFunction::generateRegistrationNumber($processInfo->ref_id, $registrationPrefix, 'ind_reg_apps', $processInfo->process_type_id);

                $certificateGenerate = certificateGenerationRequest($processInfo->ref_id, $processInfo->process_type_id, $approver_desk_id);
                if (!$certificateGenerate) {
                    Session::flash('error', 'Sorry! an unknown error occurred in the certificate generation process! [PPC-1218]');
                    return false;
                }

                $appInfo['attachment_certificate_name'] = 'ind_reg_apps.certificate_link';
                CommonFunction::sendEmailSMS('APP_ISSUED_LETTER', $appInfo, $receiverInfo);

                IndustryCommonPoolManager::indnewDataStore($processInfo->tracking_no, $processInfo->ref_id, $processInfo->created_by);
            }
            return true;
            break;

        case 2: // Industry Re-Registration
            if (in_array($status_id, ['25'])) {
                ProcessList::where('id', $process_list_id)->update(['completed_date' => date('Y-m-d H:i:s')]);
                $applicationDistrict = IndustryReRegistration::where('id', $processInfo->ref_id)->value('factory_district');
                $dist_name = CommonFunction::getDistrictFirstTwoChar($applicationDistrict);
                $registrationPrefix = $dist_name . '-' . 'RR' . '-' . date("Ymd") . '-';
                CommonFunction::generateRegistrationNumber($processInfo->ref_id, $registrationPrefix, 'rr_ind_apps', $processInfo->process_type_id);
                $certificateGenerate = certificateGenerationRequest($processInfo->ref_id, $processInfo->process_type_id, $approver_desk_id);
                if (!$certificateGenerate) {
                    Session::flash('error', 'Sorry! an unknown error occurred in the certificate generation process! [PPC-1218]');
                    return false;
                }

                $appInfo['attachment_certificate_name'] = 'rr_ind_apps.certificate_link';
                CommonFunction::sendEmailSMS('APP_ISSUED_LETTER', $appInfo, $receiverInfo);

                $checkPool = IndustryCommonPoolManager::indrrDataStore($processInfo->tracking_no, $processInfo->ref_id, $processInfo->created_by);
            }
            return true;
            break;

        case 500: // company association
            $companyAssociation = CompanyAssociationMaster::where('id', $processInfo->ref_id)->first();
            $companyAssociation->status = $status_id;
            $companyAssociation->type = 'Employee';
            $companyAssociation->is_active = 1;
            $companyAssociation->is_archive = 0;
            $companyAssociation->desk_remarks = $processInfo->process_desc;
            $companyAssociation->save();

            if (in_array($status_id, ['25'])) {
                ProcessList::where('id', $process_list_id)->update(['completed_date' => date('Y-m-d H:i:s')]);
                $user = Users::where('id', $companyAssociation->request_from_user_id)->first();

                if (empty($user->working_company_id)) {
                    $user->working_company_id = $companyAssociation->company_id;
                    $user->working_user_type = $companyAssociation->type;
                }
                $user->save();
            }

            return true;
            break;
        default:
            Session::flash('error', 'Unknown process type for Certificate and Others. [PPC-1200]');
            return false;
            break;
    }
}

/**
 * @param $app_id
 * @param $process_type_id
 * @param int $approver_desk_id
 * @param string $certificate_type
 * @return bool
 */
function certificateGenerationRequest($app_id, $process_type_id, $approver_desk_id = 0, $certificate_type = 'generate'): bool
{
    try {
        switch ($process_type_id) {
            case 1: // Industry new
                $pdf_info = PdfServiceInfo::where('certificate_name', 'industry-new-certificate')->first([
                    'pdf_server_url', 'reg_key', 'pdf_type', 'certificate_name', 'table_name', 'field_name'
                ]);
                if (empty($pdf_info)) {
                    return false;
                }
                $tableName = $pdf_info->table_name;
                $fieldName = $pdf_info->field_name;
                break;

            case 2: // Industry Re registration
                $pdf_info = PdfServiceInfo::where('certificate_name', 'industry-rr-certificate')->first([
                    'pdf_server_url', 'reg_key', 'pdf_type', 'certificate_name', 'table_name', 'field_name'
                ]);
                if (empty($pdf_info)) {
                    return false;
                }
                $tableName = $pdf_info->table_name;
                $fieldName = $pdf_info->field_name;
                break;

            default:
                return false;
        }


        $url_store = PdfPrintRequestQueue::firstOrNew([
            'process_type_id' => $process_type_id,
            'app_id' => $app_id
        ]);

        $url_store->process_type_id = $process_type_id;
        $url_store->app_id = $app_id;
        $url_store->pdf_server_url = $pdf_info->pdf_server_url;
        $url_store->reg_key = $pdf_info->reg_key;
        $url_store->pdf_type = $pdf_info->pdf_type;
        $url_store->certificate_name = $pdf_info->certificate_name;
        $url_store->prepared_json = 0;
        $url_store->table_name = $tableName;
        $url_store->field_name = $fieldName;
        $url_store->url_requests = '';
        //        $url_store->status = 0;
        $url_store->job_sending_status = 0;
        $url_store->no_of_try_job_sending = 0;
        $url_store->job_receiving_status = 0;
        $url_store->no_of_try_job_receving = 0;

        if ($certificate_type == 'generate') {
            $url_store->signatory = Auth::user()->id;

            // Store approve information
            $signature_store_status = storeSignatureQRCode($process_type_id, $app_id, $approver_desk_id, 0, 'final');
            if ($signature_store_status === false) {
                return false;
            }
        }
        $url_store->updated_at = date('Y-m-d H:i:s');
        $url_store->save();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

/**
 * @param $process_type_id
 * @param $app_id
 * @param int $user_id
 * @param $approver_desk_id
 * @param string $signature_type
 * @return bool
 */
function storeSignatureQRCode($process_type_id, $app_id, $approver_desk_id, $user_id = 0, $signature_type = 'final'): bool
{
    $pdf_sign = new \App\Modules\Settings\Models\PdfSignatureQrcode();
    $pdf_sign->signature_type = $signature_type;
    $pdf_sign->app_id = $app_id;
    $pdf_sign->process_type_id = $process_type_id;

    if ($user_id == 0) {

        if (empty(Auth::user()->signature_encode)) {
            return false;
        }

        $pdf_sign->signer_user_id = Auth::user()->id;
        $pdf_sign->signer_desk = CommonFunction::getDeskName($approver_desk_id);
        $pdf_sign->signer_name = CommonFunction::getUserFullName();
        $pdf_sign->signer_designation = Auth::user()->designation;
        $pdf_sign->signer_mobile = Auth::user()->user_mobile;
        $pdf_sign->signer_email = Auth::user()->user_email;
        $pdf_sign->signature_encode = Auth::user()->signature_encode;
    } else {
        $user_info = Users::where('id', $user_id)->first([
            DB::raw("CONCAT(user_first_name,' ',user_middle_name, ' ',user_last_name) as user_full_name"),
            'designation',
            'user_phone',
            'user_mobile',
            'user_email',
            'signature_encode',
        ]);

        if (empty($user_info->signature_encode)) {
            return false;
        }

        $pdf_sign->signer_user_id = $user_id;
        $pdf_sign->signer_desk = CommonFunction::getDeskName($approver_desk_id);
        $pdf_sign->signer_name = $user_info->user_full_name;
        $pdf_sign->signer_designation = $user_info->designation;
        $pdf_sign->signer_mobile = $user_info->user_mobile;
        $pdf_sign->signer_email = $user_info->user_email;
        $pdf_sign->signature_encode = $user_info->signature_encode;
    }
    $pdf_sign->save();
    return true;
}


function cancellationRequest($process_type_id)
{

    if ($process_type_id == 3) {
        $industryInfo = IndRRCommonPool::where('company_id', Auth::user()->working_company_id)
            ->where('ind_can_tracking_no', null)
            ->get(['id', 'tracking_no', 'project_nm']);

        return $industryInfo;
    }
}
