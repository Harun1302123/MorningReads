<?php


namespace App\Modules\Web\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use App\Modules\CompanyProfile\Models\CompanyType;
use App\Modules\ProcessPath\Models\ProcessList;
use App\Modules\Settings\Models\IframeList;
use App\Modules\Settings\Models\IndustrialAdvisor;
use App\Modules\Settings\Models\IndustrialCityList;
use App\Modules\Settings\Models\IndustrialCityMasterPlan;
use App\Modules\Settings\Models\Area;
use App\Modules\Users\Models\Countries;
use App\Modules\Users\Models\ParkInfo;
use App\Modules\Web\Models\HomePageArticle;
use App\Modules\Web\Models\IndustrialAdviceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FrontPagesController extends Controller
{
    public function availableServices()
    {
        //ob#code@start - Harun - blade file not found
        return view('Web::bscic-pages.available_services');
    }

    public function documentAndDownloads()
    {
        return view('Web::bscic-pages.document_downloads');
    }

    public function articlePage($page_name)
    {
        $data['contents'] = HomePageArticle::where('page_name', $page_name)->first(['page_content', 'page_content_en']);
        if (empty($data['contents'])) {
            throw new NotFoundHttpException();
        }
        return view('Web::bscic-pages.article', $data);
    }


    public function industrialCity($city_id = '', $slug='')
    {

        $data['industrial_city_list'] = IndustrialCityList::join('area_info' ,'industrial_city_list.district','=','area_info.area_id')
        ->where([
            'status' => 1,
            'type' => 0,
            'is_archive' => 0,
        ])->get([
            'id',
            'name',
            'name_en',
            'area_info.area_nm as area_nm_ens'
        ]);

        $areaInfo = Area::where('area_nm', CommonFunction::vulnerabilityCheck($slug, 'string'))->where('area_type', 2)->first(['area_id','area_nm']);

        if($areaInfo == null){
            abort(404);
        }
        $data['city_id'] = $city_id;
        $data['industrial_city_details'] = $result = IndustrialCityList::where('id', CommonFunction::vulnerabilityCheck($city_id, 'integer'))->where('district',$areaInfo->area_id)->first();
        $data['zoneWiseCompanyInfo'] = ProcessList::leftJoin('company_info', 'process_list.company_id','=', 'company_info.id')
            ->leftJoin('ind_sector_info', 'company_info.ins_sector_id','=', 'ind_sector_info.id')
            ->leftJoin('ind_sector_info as ind_sector2', 'company_info.ins_sub_sector_id','=', 'ind_sector2.id')
            ->where('process_list.office_id', $result->office_id)
            ->whereNotIn('process_list.status_id', ['-1','6'])
            ->groupBy('process_list.company_id')
            ->get(['org_nm_bn','org_nm','ceo_name','ind_sector_info.name_bn as sector_name','ind_sector2.name_bn as sub_sector_name', 'office_location','office_email','designation']);
        
        $data['master_plan_list'] = IndustrialCityMasterPlan::where([
            'industrial_city_id' => $city_id,
            'status' => 1,
            'is_archive' => 0
        ])->get([
            'name',
            'name_en',
            'remarks',
            'remarks_en',
            'document'
        ]);

        if(empty($data['industrial_city_details'])){
            abort(404);
        }
        //ob#code@start - Harun - blade file not found
        return view('Web::bscic-pages.industrial_city', $data);
    }

    public function industrialCityMap($city_id = '')
    {
        $data['city_all'] = IndustrialCityList::leftJoin('area_info', 'area_info.area_id','=', 'industrial_city_list.district')
            ->join('area_info as a2' ,'area_info.pare_id','=','a2.area_id')
            ->where('industrial_city_list.type',0)
            ->where('industrial_city_list.status',1)
            ->get(['industrial_city_list.*','a2.*', 'area_info.area_nm as area_nm_ens']);

        //ob#code@start - Harun - blade file not found
        return view('Web::bscic-pages.industrial_city_map', $data);
    }

    public function industrialCityMapData()
    {

        $industrial_city_list_map = IndustrialCityList::leftJoin('area_info', 'area_info.area_id','=', 'industrial_city_list.district')
        ->where('type', 0)->get(['id','name','name_en','total_plot_allocated','ind_unit_allocate_wait',
                'ind_unit_total as total_sale','area_info.area_nm as area_nm_ens','latitude','longitude']);

        foreach ($industrial_city_list_map as &$data){
            $data->ext_link =  "/bscic-industrial-city/".$data->id."/".$data->area_nm_ens;
        }

        return response()->json(['data'=>$industrial_city_list_map]);
    }

    public function newBusiness()
    {
        return view('Web::bscic-pages.new_business');
    }

    public function locationMap()
    {
        $iframe_list = IframeList::whereIn('key', ['industrialCity', 'bscicDocumentary'])
            ->where('status', 1)
            ->get();
        $industrialMap = $iframe_list->where('key', 'industrialCity')->first();
        return view('Web::bscic-pages.location_map', compact('industrialMap'));
    }
}
