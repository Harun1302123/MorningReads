<?php

namespace App\Modules\Dashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use App\Modules\Dashboard\Models\Dashboard;
use App\Modules\ProcessPath\Models\ProcessList;
use App\Modules\ProcessPath\Models\ProcessType;
use App\Modules\Settings\Models\EmailQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index(Dashboard $dashboard)
    {
        $dashboardObject = $dashboard->getDashboardObject();

        $companyId = CommonFunction::getUserCompanyWithZero();
        $notices = CommonFunction::getNotice();


        if (!empty($companyId)) {
            Session::put('associated_company_name', CommonFunction::getCompanyNameById($companyId));
        } else {
            Session::forget('associated_company_name');
        }

        $userType = Auth::user()->user_type;

        $servicesWiseApplication = null;

        $dashboardObjectBarChart = null;
        $comboChartData = null;
        $appSubmitCount = 0;
        $appApproveCount = 0;
        $deshboardObject = [];
        $services = null;
        //ob#code@start - (galib) can be common
        if ($userType == '1x101') {
            $deshboardObject = DB::table('dashboard_object')
                ->where('db_obj_caption', 'dashboard_old')
                ->where('db_obj_status', 1)
                ->get();
            $dashboardObjectBarChart = DB::table('dashboard_object')->where(
                'db_obj_type',
                'BAR_CHART'
            )->where('db_obj_status', 1)->get();
        }
        //ob#code@end - (galib)
        $userApplicaitons = [];

        if ($userType == '5x505') {
            $userApplicaitons = ProcessList::where('company_id', Auth::user()->working_company_id)->pluck('status_id');

            $approvedapp = 0;
            $processingapp = 0;
            $draftapp = 0;
            $rejectapp = 0;
            $shortfallapp = 0;

            if (count($userApplicaitons) > 0) {
                foreach ($userApplicaitons as $appStatus) {
                    if ($appStatus == 25) {
                        $approvedapp = $approvedapp + 1;
                    } elseif ($appStatus == '-1') {
                        $draftapp = $draftapp + 1;
                    } elseif ($appStatus == 5) {
                        $shortfallapp = $shortfallapp + 1;
                    } elseif ($appStatus == 6) {
                        $rejectapp = $rejectapp + 1;
                    } else {
                        $processingapp = $processingapp + 1;
                    }
                }
            }

            $totalapp = $approvedapp + $processingapp + $draftapp + $shortfallapp + $rejectapp;

            $userApplicaitons = [
                'draft' => $draftapp, 'processing' => $processingapp, 'approved' => $approvedapp,
                'totalapp' => $totalapp, 'shortfallapp' => $shortfallapp, 'rejectapp' => $rejectapp
            ];

            $servicesWiseApplication = ProcessType::whereStatus(1)
                ->where(function ($query) use ($userType) {
                    $query->where('active_menu_for', 'like', "%$userType%");
                })
                ->groupBy('group_name')
                ->get([DB::raw('group_concat(id) as process_type'), 'group_name']);
        } else {

            $services = DB::table('process_type')
                ->leftJoin('process_list', function ($on) use ($userType) {
                    $on->on('process_list.process_type_id', '=', 'process_type.id')
                        ->whereNotIn('process_list.status_id', [-1, 5]);

                    if ($userType == '4x404') {
                        $getSelfAndDelegatedUserDeskOfficeIds = CommonFunction::getSelfAndDelegatedUserDeskOfficeIds();
                        $on->where(function ($query1) use ($getSelfAndDelegatedUserDeskOfficeIds) {
                            $i = 0;
                            foreach ($getSelfAndDelegatedUserDeskOfficeIds as $data) {

                                if ($i == 0) {
                                    $query1->where(function ($queryInc) use ($data) {
                                        $queryInc->whereIn('process_list.desk_id', $data['desk_ids'])
                                            ->where(function ($query3) use ($data) {
                                                $query3->where('process_list.user_id', $data['user_id'])
                                                    ->orWhere('process_list.user_id', 0);
                                            })
                                            ->whereIn('process_list.office_id', $data['office_ids']);
                                    });
                                } else {
                                    $query1->orWhere(function ($queryInc) use ($data) {
                                        $queryInc->whereIn('process_list.desk_id', $data['desk_ids'])
                                            ->where(function ($query3) use ($data) {
                                                $query3->where('process_list.user_id', $data['user_id'])
                                                    ->orWhere('process_list.user_id', 0);
                                            })
                                            ->whereIn('process_list.office_id', $data['office_ids']);
                                    });
                                }
                                $i++;
                            }
                        });
                    }
                })
                ->groupBy('process_type.id')
                ->select([
                    'process_type.name', 'process_type.name_bn', 'process_type.id', 'process_type.form_url',
                    'process_type.panel', 'process_type.icon', DB::raw('COUNT(process_list.process_type_id) as
                    totalApplication')
                ])
                ->orderBy('process_type.id', 'asc')
                ->where('process_type.status', '=', 1)
                ->get();

            $lastSixMonthData = DB::select("SELECT  DATE_FORMAT(updated_at,'%m-%Y') AS month_year,
                                    COUNT(CASE WHEN status_id = 1 then 1 ELSE NULL END) as 'Submit',
                                    COUNT(CASE WHEN status_id = 25 then 1 ELSE NULL END) as 'Approved'
                                    FROM process_list
                                    WHERE updated_at BETWEEN CURDATE() - INTERVAL 6 MONTH AND CURDATE()
                                    AND status_id in (1,25)
                                    GROUP BY DATE_FORMAT(updated_at,'%m-%Y')
                                    ORDER BY updated_at ASC ");

            $appApproveCount = ProcessList::whereIn('status_id', [25])
                ->count();
            $appSubmitCount =  ProcessList::whereIn('status_id', [1])
                ->count();

            $comboChartArray = [];
            if (count($lastSixMonthData) > 0) {
                foreach ($lastSixMonthData as $key => $data) {
                    $comboChartArray[$key][0] = $data->month_year;
                    $comboChartArray[$key][1] = $data->Submit;
                    $comboChartArray[$key][2] = $data->Approved;
                }
            } else {
                $comboChartArray[0][0] = 20;
                $comboChartArray[0][1] = 50;
                $comboChartArray[0][2] = 10;
            }
            array_unshift($comboChartArray, ['Month', 'Submit', 'Approved']);
            $comboChartData = (array_values($comboChartArray));
        }

        //ob#code@start - (galib) can be minimized by array compact
        return view(
            'Dashboard::index',
            compact(
                'services',
                'deshboardObject',
                'dashboardObject',
                'dashboardObjectBarChart',
                'userApplicaitons',
                'servicesWiseApplication',
                'notices',
                'comboChartData',
                'appApproveCount',
                'appSubmitCount',
            )
        );
        //ob#code@end - (galib)
    }

    public function dashboard()
    {

        if (Auth::check()) {
            return view('Dashboard::index');
        }
        return redirect("login")->withSuccess('Opps! You do not have access');
    }


    public function notifications()
    {
        $notifications = EmailQueue::where('email_to', Auth::user()->user_email)
            ->where('web_notification', 0)
            ->whereNotIn('caption', ['PASSWORD_RESET_REQUEST','ONE_TIME_PASSWORD','TWO_STEP_VERIFICATION'])
            ->orWhere('email_cc', Auth::user()->user_email)
            ->orderby('created_at', 'desc')->get([
                'id',
                'email_subject',
                'web_notification',
                'created_at'
            ]);

        $new_data = $notifications->map(function ($notification) {
            return [
                'id' => Encryption::encodeId($notification->id),
                'email_subject' => $notification->email_subject,
                'web_notification' => $notification->web_notification,
                'created_at' => $notification->created_at
            ];
        });
        return response()->json($new_data);
    }

    public function notificationCount()
    {
        /*
         * Query cache.
         * after every five minutes query will execute
         */
        $notificationsCount = Cache::remember('notificationCount' . Auth::user()->user_email, 5, function () {
            return EmailQueue::where('email_to', Auth::user()->user_email)
                ->whereNotIn('caption', ['PASSWORD_RESET_REQUEST','ONE_TIME_PASSWORD','TWO_STEP_VERIFICATION'])
                ->where('web_notification', 0)
                ->orWhere('email_cc', Auth::user()->user_email)
                ->orderby('created_at', 'desc')
                ->count();
        });

        return response()->json($notificationsCount);
    }

    public function notificationSingle($id)
    {
        $id = Encryption::decodeId($id);
        EmailQueue::where('id', $id)
            ->update([
                'web_notification' => 1,
            ]);

        $singleNotificInfo = EmailQueue::where('id', $id)->first();

        return view('Dashboard::singleNotificInfo', compact('singleNotificInfo'));
    }

    public function notificationAll()
    {
        EmailQueue::where('email_to', Auth::user()->user_email)
            ->orWhere('email_cc', Auth::user()->user_email)
            ->whereNotIn('caption', ['PASSWORD_RESET_REQUEST','ONE_TIME_PASSWORD','TWO_STEP_VERIFICATION'])
            ->update([
                'web_notification' => 1,
            ]);
        $notificationsAll = EmailQueue::where('email_to', Auth::user()->user_email)
            ->orWhere('email_cc', Auth::user()->user_email)
            ->orderby('created_at', 'desc')->get();

        return view('Dashboard::singleNotificInfo', compact('notificationsAll'));
    }

    public function serverInfo()
    {
        if (!in_array(Auth::user()->user_type, ['1x101', '2x202'])) {
            Session::flash('error', 'Invalid URL ! This incident will be reported.');
            return redirect('/');
        }

        $start_time = microtime(TRUE);
        $free = shell_exec('free');
        $free = (string)trim($free);
        $free_arr = explode("\n", $free);
        $mem = explode(" ", $free_arr[1]);
        // removes nulls from array
        $mem = array_filter($mem, function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        $mem = array_merge($mem);

        $kb_to_gb_conversion_unit = 1000 * 1000;
        $total_ram_size = round($mem[1] / $kb_to_gb_conversion_unit, 2);
        $used_ram_size = round($mem[2] / $kb_to_gb_conversion_unit, 2);
        $free_ram_size = round($mem[3] / $kb_to_gb_conversion_unit, 2);
        $buffer_cache_memory_size = round($mem[5] / $kb_to_gb_conversion_unit, 2);

        $total_ram_usage = round(($mem[2] / $mem[1]) * 100, 2);

        $load = sys_getloadavg();
        $cpu_load = $load[0];

        // disk_total_space() and disk_free_space() return value as Byte format
        $total_disk_size = round(disk_total_space(".") / 1000000000); // total space in GB
        $free_disk_size = round(disk_free_space(".") / 1000000000); // Free space in GB
        $used_disk_size = round($total_disk_size - $free_disk_size); // used space in GB
        $disk_usage_percentage = round(($used_disk_size / $total_disk_size) * 100); // Disk usage ratio in Percentage(%)

        if ($total_ram_usage > 85 || $cpu_load > 2 || $disk_usage_percentage > 95) {
            $text_class = 'progress-bar-danger';
        } elseif ($total_ram_usage > 70 || $cpu_load > 1 || $disk_usage_percentage > 85) {
            $text_class = 'progress-bar-warning';
        } else {
            $text_class = 'progress-bar-success';
        }

        $db_version = DB::select(DB::raw("SHOW VARIABLES like 'version'"));
        $db_version = isset($db_version[0]->Value) ? $db_version[0]->Value : '-';

        $end_time = microtime(TRUE);
        $time_taken = $end_time - $start_time;
        $total_time_of_loading = round($time_taken, 4);
        //ob#code@start - (galib) code minimization using single array compact
        return view("Dashboard::server-info", compact('cpu_load',
            'total_ram_size', 'used_ram_size', 'free_ram_size', 'buffer_cache_memory_size', 'total_ram_usage',
            'total_disk_size', 'used_disk_size', 'free_disk_size', 'disk_usage_percentage', 'db_version',
            'total_time_of_loading', 'text_class'));
        //ob#code@end - (galib)
    }
}
