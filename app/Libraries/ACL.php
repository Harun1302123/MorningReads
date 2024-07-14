<?php

namespace App\Libraries;

use App\Modules\ProcessPath\Models\ProcessList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ACL
{

    public static function db_reconnect()
    {
        if (Session::get('DB_MODE') == 'PRODUCTION') {
//        DB::purge('mysql-main');
//        DB::setDefaultConnection('mysql-main');
//        DB::setDefaultConnection(Session::get('mysql_access'));
        }
    }

    public static function hasOwnCompanyUserModificationRight($userType, $right, $id)
    {
        try {
            $companyId = CommonFunction::getUserCompanyByUserId($id);
            if ($companyId == Auth::user()->working_company_id)
                return true;

            return false;
        } catch (\Exception $e) {
            return false;
        }
    }


    public static function getAccsessRight($module, $right = '', $id = null)
    {
        $accessRight = '';
        if (Auth::user()) {
            $user_type = Auth::user()->user_type;
        } else {
            die('You are not authorized user or your session has been expired!');
        }
        switch ($module) {
//            case 'processPath':
            case 'settings':
                if ($user_type == '1x101') {
                    $accessRight = 'AVE';
                }elseif ($user_type == '2x202'){
                    $accessRight = 'A-V-E-';
                }
                break;
            case 'dashboard':
                if ($user_type == '1x101') {
                    $accessRight = 'AVESERN';
                } elseif ($user_type == '5x505') {
                    $accessRight = 'AVESERNH';
                } elseif ($user_type == '13x131') {
                    $accessRight = 'AVESERNH';
                }
                break;
                
            case 'reportv2':
                if ($user_type == '1x101' || $user_type == '15x151') {
                    $accessRight = 'AVE';
                } else if ($user_type == '5x505' || $user_type == '6x606') {
                    $accessRight = 'V';
                } else {
                    $accessRight = 'V';
                }
                break;

            case 'CompanyAssociation':
                if ($user_type == '1x101' || $user_type == '4x404') {
                    $accessRight = '-A-V-UP-';
                } else if (in_array($user_type, ['5x505', '6x606'])) {
                    $accessRight = '-A-V-E-';
                } else {
                    $accessRight = '-V-';
                }
                break;

            case 'Documents':
                if (in_array($user_type, ['5x505', '6x606'])) {
                    $accessRight = '-A-V-E-';
                } else {
                    $accessRight = '-V-';
                }
                break;

            case 'user':
                if (in_array($user_type, ['1x101'])) {
                    $accessRight = '-A-V-E-R-APV-';
                }elseif (in_array($user_type, ['5x505', '6x606']) && in_array($right, ['-APV-'])) {
                    if (ACL::hasOwnCompanyUserModificationRight($user_type, $right, $id)) {
                        return true;
                    }
                    $accessRight = '-V-R-';
                }else if (in_array($user_type, ['2x202','4x404'])) {
                    $accessRight = '-V-R-';
                }else {
                    $accessRight = '-V-';
                }
                if ($right == "SPU") {
                    if (ACL::hasUserModificationRight($user_type, $right, $id))
                        return true;
                }
                break;

            case 'IndustryNew':
                if (in_array($user_type, ['1x101', '2x202'])) { //7x707=MIS, 8x808=IT Officer
                    $accessRight = '-V-';
                } else if (in_array($user_type, ['5x505'])) {
                    $accessRight = '-A-V-E-';
                } else if (in_array($user_type, ['4x404'])) {
                    $accessRight = '-V-UP-';
                }
                break;
            case 'IndustryReRegistration':
                if (in_array($user_type, ['1x101', '2x202'])) { //7x707=MIS, 8x808=IT Officer
                    $accessRight = '-V-';
                } else if (in_array($user_type, ['5x505'])) {
                    $accessRight = '-A-V-E-';
                } else if (in_array($user_type, ['4x404'])) {
                    $accessRight = '-V-UP-';
                }
                break;

            case 'Payment':
                if (in_array($user_type, ['1x101', '2x202', '7x707', '8x808'])) { //7x707=MIS, 8x808=IT Officer
                    $accessRight = '-V-';
                } else if (in_array($user_type, ['5x505'])) {
                    $accessRight = '-A-V-E-';
                    if ($id != null && !(strpos($accessRight, $right) === false)) {
                        if (ACL::hasApplicationModificationRight(10, $id, $right) == false)
                            return false;
                    }
                } else if (in_array($user_type, ['4x404'])) {
                    $accessRight = '-V-UP-';
                }
                break;
            
            case 'Training':
                if (in_array($user_type, ['1x101'])) {
                    $accessRight = '-A-V-E-';
                }
                break;
            case 'Training-Desk':
                if (in_array($user_type, ['4x404']) && checkUserTrainingDesk()) {
                    if(checkUserTrainingDesk() == 1){
                        $accessRight = '-A-V-E-';
                    }
                    else if(checkUserTrainingDesk() == 2){
                        // DA = Director Add
                        // DV = Director View
                        // DE = Director Edit
                        $accessRight = '-DA-DV-DE-';
                    }
                }
                break;

            default:
                $accessRight = '';
        }
        if ($right != '') {
            if (strpos($accessRight, $right) === false) {
                return false;
            } else {
                return true;
            }
        } else {
            return $accessRight;
        }
    }
    public static function hasUserModificationRight($userType, $right, $id)
    {
        try {
            $userId = CommonFunction::getUserId();
            if ($userType == '1x101')
                return true;

            if ($userId == $id)
                return true;

            return false;
        } catch (\Exception $e) {
            dd(CommonFunction::showErrorPublic($e->getMessage()));
            return false;
        }
    }

    public static function isAllowed($accessMode, $right)
    {
        if (strpos($accessMode, $right) === false) {
            return false;
        } else {
            return true;
        }
    }

    public static function hasApplicationModificationRight($processTypeId, $id, $right)
    {
        try {
            $companyId = CommonFunction::getUserCompanyWithZero();
            if ($right != '-E-') {
                return true;
            } else {
                $processListData = ProcessList::where('ref_id', $id)->where('process_type_id', $processTypeId)
                    ->first(['company_id', 'status_id']);
                if ($processListData == null) {
                    return false;
                } elseif ($processListData->company_id == $companyId && in_array($processListData->status_id, [-1, 5])) {
                    return true;
                } else {
                    return false;
                }
            }
        } catch (\Exception $e) {
            dd(CommonFunction::showErrorPublic($e->getMessage()));
            return false;
        }
    }

    /*     * **********************************End of Class****************************************** */
}
