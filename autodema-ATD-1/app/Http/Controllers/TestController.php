<?php

namespace App\Http\Controllers;

use App\Basins;
use App\Deep;
use App\Parameter;
use App\Reservoir;
use App\Role;
use App\SamplingParameter;
use App\SamplingPoint;
use App\Zone;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function maps(){


        return view('tests.maps' );
    }
    public function mapsReports(){


        $samplingResults = $this->samplingResults(1);
        $samplingResults2 = $this->samplingResults(2);
        $samplingPoints = $this->samplingPoints();
        $zones = Zone::get();
        $deeps = Deep::get();
        $basins = Basins::get();
        $reservoirs = Reservoir::get();

        $user_role = auth()->user()->role_id;

        if ($user_role == Role::VISUALIZER){
            $parameters = Parameter::whereIn('id', Parameter::ALLOWED_PARAMETERS_VISUALIZER)->with('unit')->get();
        }else if($user_role == Role::VISITOR){
            $parameters = auth()->user()->parameters()->get();
        }else{
            $parameters = Parameter::with('unit')->get();
        }



        return view('tests.mapsReports', compact( 'samplingResults', 'samplingPoints', 'samplingResults2', 'zones', 'deeps', 'basins', 'reservoirs', 'parameters')  );
    }

    public function samplingResults($id){

        $samplingResults = SamplingParameter::
            leftJoin('samplings', function($join){
                $join->on('sampling_parameters.sampling_id', '=', 'samplings.id');
            })
            ->where('samplings.sampling_point_id', $id)
            ->orderBy('samplings.sampling_date', 'asc')
            ->selectRaw('value as sum, samplings.sampling_date as name')
            ->get();
        //dd($getSumOpportunities);
        //$getSumOpportunities = $getSumOpportunities->toJson();

        return $samplingResults;

        //dd($getSumOpportunities);
    }
    public function samplingPoints(){

        $SamplingPoint = SamplingPoint::orderBy('id','asc')->get();
        //dd($getSumOpportunities);
        //$getSumOpportunities = $getSumOpportunities->toJson();

        return $SamplingPoint;

        //dd($getSumOpportunities);
    }



    public function getSamplingParameterData(Request $request){
        //POLICIES
        $canListSamplingParameterDate = true;
        //END POLICIES

        if(!($canListSamplingParameterDate) ){
            return 403;
        }

        $sampling_point_id = $request->has('sampling_point_id') ? $request->input('sampling_point_id'): null;
        $parameter_id = $request->has('parameter_id') ? $request->input('parameter_id'): null;
        $deep_id = $request->has('deep_id') ? $request->input('deep_id'): null;
        $date_initial = $request->has('date_initial') ? $request->input('date_initial'): null;
        $date_end = $request->has('date_end') ? $request->input('date_end'): null;

        /*
        $samplingData = SamplingParameter::with([
            'sampling'
        ])
            ->whereHas("sampling", function ($q) use ($sampling_point_id, $deep_id,$date_initial , $date_end) {
                $q
                    ->where('sampling_point_id', $sampling_point_id)
                    ->where('deep_id', $deep_id)
                    ->whereDate('from','<=', $date_initial)
                    ->whereDate('to','>=', $date_end)
                    ->orderBy('sampling_date', 'asc');
            })
            ->where('parameter_id', $parameter_id)
            ->orderBy('sampling.sampling_date', 'ASC');

*/
        $date_initial = Carbon::createFromFormat('d/m/Y',$date_initial)->format('Y-m-d');
        $date_end = Carbon::createFromFormat('d/m/Y',$date_end)->format('Y-m-d');

        $samplingData = SamplingParameter::
        leftJoin('samplings', function($join){
            $join->on('sampling_parameters.sampling_id', '=', 'samplings.id');
        })
            ->where('samplings.sampling_point_id', $sampling_point_id)
            ->where('samplings.deep_id', $deep_id)
            ->whereDate('samplings.sampling_date','>=', $date_initial)
            ->whereDate('samplings.sampling_date','<=', $date_end)
            ->where('sampling_parameters.parameter_id', $parameter_id)
            ->orderBy('samplings.sampling_date', 'asc');


        $samplingData = $samplingData->get();

        $samplingPoint = SamplingPoint::where('id',$sampling_point_id)->first();
        try {
            $ecaParameter = $samplingPoint->eca->ecaParameters()->where('parameter_id',$parameter_id )->get(['min_value','max_value','near_min_value','near_max_value','allowed_value', 'parameter_id'])->first();
            $ecaParameter = $ecaParameter ? $ecaParameter->toArray() : [];
        } catch (\Exception $e) {
            $ecaParameter = [];
        }


        $data = [
            "eca" => $ecaParameter,
            "samplingData" =>   $samplingData
        ];

        //dd($data);

        //dd($data);

        return $data;
    }

    public function getSamplingParameterDataComparisson(Request $request){
        //POLICIES
        $canListSamplingParameterDate = true;
        //END POLICIES

        if(!($canListSamplingParameterDate) ){
            return 403;
        }

        $parameter_id = $request->has('parameter_id') ? $request->input('parameter_id'): null;
        $deep_id = $request->has('deep_id') ? $request->input('deep_id'): null;
        $date_initial = $request->has('date_initial') ? $request->input('date_initial'): null;
        $date_end = $request->has('date_end') ? $request->input('date_end'): null;

        $date_initial = Carbon::createFromFormat('d/m/Y',$date_initial)->format('Y-m-d');
        $date_end = Carbon::createFromFormat('d/m/Y',$date_end)->format('Y-m-d');

        $samplingData = SamplingParameter::
        leftJoin('samplings', function($join){
            $join->on('sampling_parameters.sampling_id', '=', 'samplings.id');
        })
        ->leftJoin('sampling_points', function($join){
            $join->on('samplings.sampling_point_id', '=', 'sampling_points.id');
        })
            ->select('sampling_points.id','sampling_points.name',DB::raw('round(AVG(value),3) as mean'))
            ->groupBy('sampling_points.id')
            ->where('samplings.deep_id', $deep_id)
            ->whereDate('samplings.sampling_date','>=', $date_initial)
            ->whereDate('samplings.sampling_date','<=', $date_end)
            ->where('sampling_parameters.parameter_id', $parameter_id)
            ->orderBy('sampling_points.id', 'asc');


        $samplingData = $samplingData->get();

        //dd($samplingData);

        return $samplingData;
    }

}
