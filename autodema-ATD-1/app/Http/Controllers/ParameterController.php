<?php

namespace App\Http\Controllers;

use App\EcaParameter;
use App\Http\Requests\ParameterRequest;
use App\Parameter;
use App\SamplingParameter;
use App\Unit;
use Illuminate\Http\Request;

class ParameterController extends Controller
{
    public function listAll(){
        //POLICIES
        $canListAllParameters = true;
        //END POLICIES

        $parameters = Parameter::with([]);

        if(! $canListAllParameters){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite ver parámetros.")]);
        }

        $parameters = $parameters->where('enabled',1)->orderBy('id', 'desc')->paginate(12);

        return view('parameters.listAll', compact('parameters'));
    }

    public function admin($id){
        $parameter = Parameter::with([])
            ->where('id',$id)
            ->orderBy('id', 'desc')
            ->first();

        //POLICIES
        $canListAllParameters = true;
        if(! $canListAllParameters){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite ver parámetros.")]);
        }
        //END POLICIES


        //dd($companies);
        return view('parameters.admin', compact('parameter'));
    }

    public function create(){
        $canCreateParameter = true;
        //dd($companyRequest->all());
        if(! $canCreateParameter){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite crear parámetros.")]);
        }

        $parameter = new Parameter();

        $units = Unit::get();

        $btnText = __("Crear");
        return view('parameters.form', compact('parameter', 'units','btnText'));
    }

    public function store(ParameterRequest $parameterRequest){

        $canCreateSamplingPoint = true;
        //dd($companyRequest->all());
        if(! $canCreateSamplingPoint){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite crear puntos de muestreo.")]);
        }

        $parameterExists = Parameter::where('name', $parameterRequest->input('name'))->first();
        $parameterExistsCode = Parameter::where('code', $parameterRequest->input('code'))->first();

        if($parameterExists){
            return back()->with('modalMessage',['Aviso', __("Ya existe un parámetro con el nombre indicado.")]);
        }
        if($parameterExistsCode){
            return back()->with('modalMessage',['Aviso', __("Ya existe un parámetro con el código indicado.")]);
        }

        Parameter::create($parameterRequest->input());

        return back()->with('modalMessage',['Aviso', __("Se agregó el parámetro correctamente.")]);
    }


    public function edit($id){

        $parameter = Parameter::with([])
            ->where('id',$id)
            ->orderBy('id', 'desc')
            ->first();

        $canUpdateParameter= true;
        //dd($companyRequest->all());
        if(! $canUpdateParameter){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite actualizar este parámetro.")]);
        }

        $units = Unit::get();

        $btnText = __("Actualizar");

        //dd($vouchers);
        return view('parameters.form', compact('parameter', 'units','btnText'));
    }
    public function update(ParameterRequest $parameterRequest, Parameter $parameter){

        $canUpdateParameter= true;
        //dd($companyRequest->all());
        if(! $canUpdateParameter){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite actualizar este parámetro.")]);
        }

        //dd($customerRequest);
        $parameter->fill($parameterRequest->input())->save();

        //dd($customerRequest);
        return back()->with('modalMessage',['Aviso', __("Se actualizó el parámetro correctamente.")]);
    }

    public function filter(Request $request){
        //POLICIES
        $canListAllParameters = true;
        //END POLICIES
        if(! ($canListAllParameters) ){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite ver parámetros.")]);
        }
        $parameters = new Parameter();

        $name_search = $request->has('name_search') ? $request->input('name_search'): null;
        $unit_id_search = $request->has('unit_id_search') ? $request->input('unit_id_search'): null;

        // Search for a user based on their name.
        if ($name_search) {
            $parameters = $parameters->where('name','LIKE', '%'.$name_search.'%');
        }
        // Search for a user based on their name.
        if ($unit_id_search) {
            $parameters = $parameters->where('unit_id',$unit_id_search);
        }

        $parameters = $parameters->where('enabled',1)->paginate(12);

        //dd($vouchers);
        return view('parameters.listAll', compact('parameters'));
    }
    public function delete(Request $request){

        $candeleteParameter= true;
        //dd($companyRequest->all());
        if(! $candeleteParameter){
            return 403;
        }

        //dd($customerRequest);
        //EcaParameter::where('parameter_id', $request->parameter_id)->delete();
        //SamplingParameter::where('parameter_id', $request->parameter_id)->delete();
        Parameter::where('id', $request->parameter_id)->update(['enabled'=>0]);

        //dd($customerRequest);
        return 200;
    }
}
