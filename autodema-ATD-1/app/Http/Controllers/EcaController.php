<?php

namespace App\Http\Controllers;

use App\Eca;
use App\EcaParameter;
use App\Http\Requests\EcaParameterRequest;
use App\Http\Requests\EcaRequest;
use App\Parameter;
use Illuminate\Http\Request;

class EcaController extends Controller
{
    public function listAll(){
        //POLICIES
        $canListAllEcas = true;
        //END POLICIES

        $ecas = Eca::with([]);

        if(! $canListAllEcas){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite ver ecas.")]);
        }

        $ecas = $ecas->where('enabled', 1)->orderBy('id', 'asc')->paginate(12);

        return view('ecas.listAll', compact('ecas'));
    }


    public function create(){
        $canCreateEca = true;
        //dd($companyRequest->all());
        if(! $canCreateEca){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite crear ecas.")]);
        }

        $eca = new Eca();

        $btnText = __("Crear");
        return view('ecas.form', compact('eca', 'btnText'));
    }

    public function store(Request $request){
        $canCreateEca = true;
        //dd($companyRequest->all());
        if(! $canCreateEca){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite crear ecas.")]);
        }

        Eca::create($request->input());

        return back()->with('modalMessage',['Aviso', __("Se agregó el ECA correctamente.")]);
    }
    public function admin($id){
        $eca = Eca::with([])
            ->where('id',$id)
            ->orderBy('id', 'desc')
            ->first();

        //POLICIES
        $canListAllEcas = true;
        if(! $canListAllEcas){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite ver ecas.")]);
        }
        //END POLICIES


        //dd($companies);
        return view('ecas.admin', compact('eca'));
    }

    public function edit($id){

        $eca = Eca::with([])
            ->where('id',$id)
            ->orderBy('id', 'desc')
            ->first();

        $canUpdateEca= true;
        //dd($companyRequest->all());
        if(! $canUpdateEca){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite editar ecas.")]);
        }

        $btnText = __("Actualizar");

        //dd($vouchers);
        return view('ecas.form', compact('eca', 'btnText'));
    }
    public function update(EcaRequest $ecaRequest, Eca $eca){

        $canUpdateEca= true;
        //dd($companyRequest->all());
        if(! $canUpdateEca){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite editar ecas.")]);
        }


        if($ecaRequest->input('is_transition') == 0){
            $ecaRequest->merge(['is_transition' => null ]);
        }

        //dd($customerRequest);
        $eca->fill($ecaRequest->input())->save();

        //dd($customerRequest);
        return back()->with('modalMessage',['Aviso', __("Se actualizó el ECA correctamente.")]);
    }
    public function delete(Request $request){

        $canUpdateEca= true;
        //dd($companyRequest->all());
        if(! $canUpdateEca){
            return 403;
        }

        //dd($customerRequest);
        Eca::where('id', $request->eca_id)->update(['enabled' => 0]);

        //dd($customerRequest);
        return 200;
    }


    public function listParameters($id, Request $request){
        //POLICIES
        $canListAllParameters = true;
        //END POLICIES
        if(! ($canListAllParameters) ){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite ver parámetros.")]);
        }

        $eca = Eca::with([])
            ->where('id',$id)
            ->orderBy('id', 'desc')
            ->first();


        $ecaParameters = $eca->ecaParameters()->with('parameter');

        //SEARCH
        $name_search = $request->has('name_search') ? $request->input('name_search'): null;
        $unit_id_search = $request->has('unit_id_search') ? $request->input('unit_id_search'): null;

        // Search for a user based on their name.
        if ($name_search) {
            $ecaParameters = $ecaParameters->whereHas('parameter', function ($query) use ($name_search) {
                $query->where('name', 'like', $name_search.'%');
            });

        }
        // Search for a user based on their name.
        if ($unit_id_search) {
            $ecaParameters = $ecaParameters->whereHas('parameter', function ($query) use ($unit_id_search) {
                $query->where('unit_id', 'like', $unit_id_search.'%');
            });
        }
        //SEARCH

        $showCopyParameters = $ecaParameters->count() < 10;

        $ecaParameters = $ecaParameters->paginate(150);

        //dd($parameters);

        //dd($vouchers);
        return view('ecas.listParameters', compact('ecaParameters', 'eca', 'showCopyParameters'));
    }
    public function filter(Request $request){
        //POLICIES
        $canListAllEcas = true;
        //END POLICIES
        if(! ($canListAllEcas) ){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite ver ecas.")]);
        }
        $ecas = new Eca();

        $name_search = $request->has('name_search') ? $request->input('name_search'): null;

        // Search for a user based on their name.
        if ($name_search) {
            $ecas = $ecas->where('name','LIKE', '%'.$name_search.'%');
        }

        $ecas = $ecas->paginate(12);

        //dd($vouchers);
        return view('ecas.listAll', compact('ecas'));
    }

    public function createParameter($id){

        $eca = Eca::with([])
            ->where('id',$id)
            ->orderBy('id', 'desc')
            ->first();

        $canUpdateEca= true;
        //dd($companyRequest->all());
        if(! $canUpdateEca){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite editar ecas.")]);
        }
        $ecaParameter= new EcaParameter();

        $btnText = __("Crear");

        //dd($vouchers);
        return view('ecas.formParameter', compact('eca', 'ecaParameter' ,'btnText'));
    }
    public function storeParameter(EcaParameterRequest $ecaParameterRequest){

        $canUpdateEca= true;
        //dd($companyRequest->all());
        if(! $canUpdateEca){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite editar ecas.")]);
        }

        $eca = Eca::with([])
            ->where('id',$ecaParameterRequest->input('eca_id'))
            ->orderBy('id', 'desc')
            ->first();
        $ecaID = $eca->id;

        $ecaParameterExists = $eca->ecaParameters()->where('parameter_id', $ecaParameterRequest->input('parameter_id'))->first();

        if($ecaParameterExists){
            return redirect()->route('ecas.listParameters', $ecaID)->with('modalMessage',['Aviso', __("El ECA para el parámetro ya existe.")]);
        }

        EcaParameter::create($ecaParameterRequest->input());

        return redirect()->route('ecas.listParameters', $ecaID)->with('modalMessage',['Aviso', __("Se agregó el ECA correctamente.")]);
    }


    public function editParameter($id){

        $ecaParameter = EcaParameter::with([])
            ->where('id',$id)
            ->orderBy('id', 'desc')
            ->first();

        $eca = $ecaParameter->eca;

        $canUpdateEca= true;
        //dd($companyRequest->all());
        if(! $canUpdateEca){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite editar ecas.")]);
        }

        $btnText = __("Actualizar");

        //dd($vouchers);
        return view('ecas.formParameter', compact('eca', 'ecaParameter' ,'btnText'));
    }
    public function updateParameter(EcaParameterRequest $ecaParameterRequest, EcaParameter $ecaParameter){

        $canUpdateEca= true;
        //dd($companyRequest->all());
        if(! $canUpdateEca){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite editar ecas.")]);
        }

        //dd($customerRequest);
        $ecaParameter->fill($ecaParameterRequest->input())->save();

        $ecaId = $ecaParameter->eca->id;

        //dd($ecaParameters);

        //dd($customerRequest);
        return redirect()->route('ecas.listParameters', $ecaId)->with('modalMessage',['Aviso', __("Se actualizó el ECA correctamente.")]);

    }
    public function copy(Request $ecaParameterRequest, Eca $eca){

        $canUpdateEca= true;
        //dd($companyRequest->all());
        if(! $canUpdateEca){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite editar ecas.")]);
        }

        $ecaParametersFromEcaToCopy = Eca::with([])
            ->where('id',$ecaParameterRequest->input('eca_to_copy'))
            ->orderBy('id', 'desc')
            ->first()->ecaParameters;

        $ecaID = $eca->id;

        $ecaParameterExists = $eca->ecaParameters()->delete();
        foreach ($ecaParametersFromEcaToCopy as $parameterToAdd){
            $parameterToAdd = $parameterToAdd->toArray();
            $parameterToAdd['id'] = null;
            $parameterToAdd['eca_id'] = $ecaID;

            $ecaParameterExists = $eca->ecaParameters()->where('parameter_id', $parameterToAdd['parameter_id'])->first();

            if(!$ecaParameterExists){
                EcaParameter::create($parameterToAdd);
            }
        }


        return redirect()->route('ecas.listParameters', $ecaID)->with('modalMessage',['Aviso', __("Se agregó el ECA correctamente.")]);
    }
}
