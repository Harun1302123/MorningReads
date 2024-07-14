<?php

namespace App\Http\Controllers;

use App\Libraries\CommonFunction;
use App\Modules\ProcessPath\Models\ProcessHistory;
use App\Modules\ProcessPath\Models\ProcessList;
use App\Modules\Users\Models\UserLogs;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Libraries\Encryption;


class CommonController extends Controller
{
    public function activitiesSummary()
    {
        $userType = CommonFunction::getUserType();
        $user_logs = UserLogs::where('user_id', '=', CommonFunction::getUserId())
            ->where('updated_at', '<=', Carbon::now()->subMonth()->format('Y-m-d H:i:s'))
            ->count();

        $totalNumberOfAction = ProcessHistory::join('process_type', 'process_type.id', '=',
            'process_list_hist.process_type_id')
            ->where('process_type.status', 1)
            ->where('process_type.active_menu_for', 'like', "%$userType%")
            ->where('updated_by', CommonFunction::getUserId())
            ->where('process_list_hist.updated_at', '<=', Carbon::now()->subMonth())
            ->groupBy('name')
            ->select(DB::raw('count(process_list_hist.process_type_id) as totalApplication'), 'name')
            ->get();

//        dd($totalNumberOfAction);

        $currentPendingYourDesk = ProcessList::leftJoin('process_type', 'process_type.id', '=', 'process_list.process_type_id')
            ->where('process_type.status', 1)
            ->where('process_type.active_menu_for', 'like', "%$userType%")
            ->where('process_list.desk_id', '=', CommonFunction::getUserDeskIds())
            ->where('process_list.updated_at', '<=', Carbon::now()->subMonth()->format('Y-m-d H:i:s'))
            ->groupBy('process_type.name')
            ->select(DB::raw('count(process_list.process_type_id) as totalApplication'), 'process_type.name')
            ->get();

        $page_header = 'Activities Summary';
        return view('Settings::activities-summary.list', compact('user_logs', 'totalNumberOfAction', 'currentPendingYourDesk', 'page_header'));
    }

    public function getAttachment($fileurl){
        $file = Encryption::decode($fileurl);
        $urlInfo = explode('@expiredtime@',$file);
        if (!Carbon::parse($urlInfo[1])->isPast()) {
           return response()->file(public_path($urlInfo[0]));
        }else{
            $response = "URL expired" ;
            return $response;
        }
    }

    public function migration(Request $request, $module_name = '')
    {

        if (CommonFunction::getUserType() == '1x101') {
            $migrationPath = $module_name ? "/app/Modules/$module_name/database/migrations" : '/database/migrations';

            Artisan::call('migrate', [
                '--path' => $migrationPath,
                '--force' => true,
                '--pretend' => true,
            ]);

            DB::table('migration_audit')->insert([
                'title' => 'Migration',
                'details' => Artisan::output(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
            ]);

            Artisan::call('migrate', [
                '--path' => $migrationPath,
                '--force' => true,
            ]);
            echo $module_name . ":   ";
            return Artisan::output();

        }

    }

}
