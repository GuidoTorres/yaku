<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Http\Requests\ActivityRequest;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function store(ActivityRequest $activityRequest){

        //POLICIES
        $canCreateOpportunities = true;
        //END POLICIES

        if(! $canCreateOpportunities){
            return back()->with('modalMessage',['Aviso', __("Su rol no le permite crear oportunidades.")]);
        }

        $activityRequest->merge([
            'user_id' => auth()->user()->id,
        ]);

        try {
            $activity = Activity::create($activityRequest->input());


            return back()->with('modalMessage',['Aviso',
                __("Se agregó correctamente la actividad.")]);
        } catch(\Illuminate\Database\QueryException $e){
            dd($e);
            return back()->with('modalMessage',['Aviso',
                __("Hubo un error agregando la actividad,
                por favor verifique que está colocando los datos requeridos.")]);

        }
    }
}
