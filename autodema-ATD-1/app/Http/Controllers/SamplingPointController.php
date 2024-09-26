<?php

namespace App\Http\Controllers;

use App\Basins;
use App\Deep;
use App\Eca;
use App\gPoint;
use App\Http\Requests\SamplingPointRequest;
use App\Http\Requests\SamplingRequest;
use App\Reservoir;
use App\Sampling;
use App\SamplingPoint;
use App\Zone;
use Illuminate\Http\Request;

class SamplingPointController extends Controller
{
    public function listAll(){
        //POLICIES
        $canListAllSamplingPoints = true;
        //END POLICIES

        $samplingPoints = SamplingPoint::with([]);

        if(! $canListAllSamplingPoints){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite ver puntos de muestreo.")]);
        }

        $samplingPoints = $samplingPoints->orderBy('id', 'desc')->paginate(12);

        return view('samplingPoints.listAll', compact('samplingPoints'));
    }

    public function admin($id){
        $samplingPoint = SamplingPoint::with([])
            ->where('id',$id)
            ->orderBy('id', 'desc')
            ->first();

        //POLICIES
        $canListAllSamplingPoints = true;
        if(! $canListAllSamplingPoints){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite ver puntos de muestreo.")]);
        }
        //END POLICIES

        $type_title = "";
        $type_description = "";
        if( $samplingPoint->type == \App\SamplingPoint::FIXED_POINT ){
            $type_title = SamplingPoint::FIXED_TITLE;
        }else{
            $type_title = SamplingPoint::FLOAT_TITLE;
        }
        if( $samplingPoint->type == \App\SamplingPoint::FIXED_POINT ){
            $type_description = SamplingPoint::FIXED_DESCRIPTION;
        }else{
            $type_description = SamplingPoint::FLOAT_DESCRIPTION;
        }

        //dd($companies);
        return view('samplingPoints.admin', compact('samplingPoint', 'type_title', 'type_description'));
    }

    public function getInfoAsJson(Request $request){

        $id = $request->has('id') ? $request->input('id'): null;
        if(! $id){
            return "{}";
        }
        $samplingPoint = SamplingPoint::with(['eca', 'basin', 'reservoir', 'zone'])
            ->where('id',$id)
            ->orderBy('id', 'desc')
            ->first();

        //POLICIES
        $canListAllSamplingPoints = true;
        if(! $canListAllSamplingPoints){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite ver puntos de muestreo.")]);
        }
        //END POLICIES

        $type_title = "";
        $type_description = "";
        if( $samplingPoint->type == \App\SamplingPoint::FIXED_POINT ){
            $samplingPoint->type_title = SamplingPoint::FIXED_TITLE;
        }else{
            $samplingPoint->type_title = SamplingPoint::FLOAT_TITLE;
        }
        if( $samplingPoint->type == \App\SamplingPoint::FIXED_POINT ){
            $samplingPoint->type_description = SamplingPoint::FIXED_DESCRIPTION;
        }else{
            $samplingPoint->type_description = SamplingPoint::FLOAT_DESCRIPTION;
        }

        $samplingsLinks = route('samplings.listPoint', ["samplingPoint" => $id]);
        $samplingPoint->links =  "<a href='$samplingsLinks' target='_blank'>Ver</a>";


        return $samplingPoint->toJson();
    }

    public function filter(Request $request){
        //POLICIES
        $canListAllSamplingPoints = true;
        //END POLICIES
        if(! ($canListAllSamplingPoints) ){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite ver puntos de muestreo.")]);
        }
        $samplingPoints = new SamplingPoint();

        $name_search = $request->has('name_search') ? $request->input('name_search'): null;
        $zone_id_search = $request->has('zone_id_search') ? $request->input('zone_id_search'): null;
        $basin_id_search = $request->has('basin_id_search') ? $request->input('basin_id_search'): null;
        $reservoir_id_search = $request->has('reservoir_id_search') ? $request->input('reservoir_id_search'): null;

        // Search for a user based on their name.
        if ($name_search) {
            $samplingPoints = $samplingPoints->where('name','LIKE', '%'.$name_search.'%');
        }
        // Search for a user based on their name.
        if ($zone_id_search) {
            $samplingPoints = $samplingPoints->where('zone_id',$zone_id_search);
        }
        // Search for a user based on their name.
        if ($basin_id_search) {
            $samplingPoints = $samplingPoints->where('basin_id',$basin_id_search);
        }
        // Search for a user based on their name.
        if ($reservoir_id_search) {
            $samplingPoints = $samplingPoints->where('reservoir_id',$reservoir_id_search);
        }

        $samplingPoints = $samplingPoints->paginate(12);

        //dd($vouchers);
        return view('samplingPoints.listAll', compact('samplingPoints') );
    }

    public function create(){
        $canCreateSamplingPoint = true;
        //dd($companyRequest->all());
        if(! $canCreateSamplingPoint){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite crear puntos de muestreo.")]);
        }

        $samplingPoint = new SamplingPoint();

        $ecas = Eca::where('is_transition',0)->orWhere('is_transition',null)->get();
        $transitionEcas = Eca::where('is_transition',1)->get();
        $basins = Basins::get();
        $reservoirs = Reservoir::get();
        $zones = Zone::get();

        $btnText = __("Crear");
        return view('samplingPoints.form', compact('samplingPoint', 'ecas', 'transitionEcas', 'basins', 'reservoirs', 'zones','btnText'));
    }

    public function store(SamplingPointRequest $samplingPointRequest){

        $canCreateSamplingPoint = true;
        //dd($companyRequest->all());
        if(! $canCreateSamplingPoint){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite crear puntos de muestreo.")]);
        }

        //INTENTAMOS CREAR LA ELECCIÓN, AÑADIENDO EL ID DEL USUARIO QUE CREÓ
        $north = $samplingPointRequest->north;
        $east = $samplingPointRequest->east;
        $utmZone = $samplingPointRequest->utm_zone ? $samplingPointRequest->utm_zone : "19k";

        $gPoint = new gPoint("WGS 84");
        $gPoint->setUTM($east, $north, $utmZone);
        $gPoint->convertTMtoLL();

        $latitude = $gPoint->Lat();
        $longitude = $gPoint->Long();

        $samplingPointRequest->merge([
            'user_created' => auth()->user()->id,
            'state' => Sampling::FOR_APPROVAL,
            'latitude' => $latitude,
            'longitude' => $longitude
        ]);

        SamplingPoint::create($samplingPointRequest->input());

        return back()->with('modalMessage',['Aviso', __("Se agregó el punto correctamente.")]);
    }

    public function edit($id){

        $samplingPoint = SamplingPoint::with([])
            ->where('id',$id)
            ->orderBy('id', 'desc')
            ->first();

        $canUpdateSamplingPoint= true;
        //dd($companyRequest->all());
        if(! $canUpdateSamplingPoint){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite actualizar este punto de muestreo.")]);
        }


        $ecas = Eca::where('is_transition',0)->orWhere('is_transition',null)->get();
        $transitionEcas = Eca::where('is_transition',1)->get();
        $basins = Basins::get();
        $reservoirs = Reservoir::get();
        $zones = Zone::get();

        $btnText = __("Actualizar");

        //dd($vouchers);
        return view('samplingPoints.form', compact('samplingPoint', 'ecas', 'transitionEcas', 'basins', 'reservoirs', 'zones','btnText'));
    }

    public function update(SamplingPointRequest $samplingPointRequest, SamplingPoint $samplingPoint){

        $canUpdateSamplingPoint= true;
        //dd($companyRequest->all());
        if(! $canUpdateSamplingPoint){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite actualizar este punto de muestreo.")]);
        }

        $north = $samplingPointRequest->north;
        $east = $samplingPointRequest->east;
        $utmZone = $samplingPointRequest->utm_zone;

        $gPoint = new gPoint("WGS 84");
        $gPoint->setUTM($east, $north, $utmZone);
        $gPoint->convertTMtoLL();

        $latitude = $gPoint->Lat();
        $longitude = $gPoint->Long();

        $samplingPointRequest->merge([
            'latitude' => $latitude,
            'longitude' => $longitude
        ]);

        //dd($customerRequest);
        $samplingPoint->fill($samplingPointRequest->input())->save();

        //dd($customerRequest);
        return back()->with('modalMessage',['Aviso', __("Se actualizó el punto de muestreo correctamente.")]);
    }

    public function delete(SamplingPoint $samplingPoint){

        $canDeleteSamplingPoint= true;
        //dd($companyRequest->all());
        if(! $canDeleteSamplingPoint){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite eliminar este punto de muestreo.")]);
        }

        try {
            $samplingPoint->delete();
        } catch(\Illuminate\Database\QueryException $e){

            $msg = "Hubo un error eliminando el punto de muestreo. Error: ".$e->getMessage();
            //dd($e->getMessage());
            return back()->with('modalMessage',['Aviso', $msg]);
        }

        return back()->with('modalMessage',['Aviso', __("Se eliminó el punto de muestreo correctamente.")]);
    }

}
