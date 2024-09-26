<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceTypeRequest;
use App\ServiceType;
use Illuminate\Http\Request;

class ServiceTypeController extends Controller
{
    public function listAll(){
        //POLICIES
        $canListAllServiceTypes = auth()->user()->can('viewAny', ServiceType::class );
        //END POLICIES

        if(! $canListAllServiceTypes){
            return back()->with('modalMessage',['Aviso', __("Su rol no le permite ver los servicios.")]);
        }

        $serviceTypes = ServiceType::with([]);

        $serviceTypes = $serviceTypes->orderBy('id', 'desc')->paginate(12);

        return view('serviceTypes.listAll', compact('serviceTypes'));
    }
    public function admin($id){
        //POLICIES
        $canListServiceType = auth()->user()->can('view', ServiceType::class );
        //END POLICIES

        if(! $canListServiceType){
            return back()->with('modalMessage',['Aviso', __("Su rol no le permite ver el servicio.")]);
        }

        $serviceType = ServiceType::with([])
            ->where('id',$id)
            ->orderBy('id', 'desc')
            ->first();

        //dd($companies);
        return view('serviceTypes.admin', compact('serviceType'));
    }
    public function filter(Request $request){
        //POLICIES
        $canListAllServiceTypes = auth()->user()->can('viewAny', ServiceType::class );
        //END POLICIES
        if(! ($canListAllServiceTypes) ){
            return back()->with('modalMessage',['Aviso', __("Su rol no le permite ver los servicios.")]);
        }
        $serviceTypes = new ServiceType();

        $name_search = $request->has('name_search') ? $request->input('name_search'): null;

        // Search for a user based on their name.
        if ($name_search) {
            $serviceTypes = $serviceTypes->where('name','LIKE', '%'.$name_search.'%');
        }

        $serviceTypes = $serviceTypes->paginate(12);

        //dd($vouchers);
        return view('serviceTypes.listAll', compact('serviceTypes') );
    }


    public function create(){
        //POLICIES
        $canCreateServiceType = auth()->user()->can('create', ServiceType::class );
        //END POLICIES
        if(! ($canCreateServiceType) ){
            return back()->with('modalMessage',['Aviso', __("Su rol no le permite editar el servicio.")]);
        }
        $serviceType = new ServiceType;

        $btnText = __("Crear servicio");
        return view('serviceTypes.form', compact('serviceType','btnText'));
    }

    public function store(ServiceTypeRequest $serviceTypeRequest){
        //POLICIES
        $canCreateServiceType = auth()->user()->can('create', ServiceType::class );
        //END POLICIES
        if(! ($canCreateServiceType) ){
            return back()->with('modalMessage',['Aviso', __("Su rol no le permite editar el servicio.")]);
        }

        //dd($companyRequest->all());

        //$serviceTypeRequest->merge(['user_id' => auth()->user()->id ]);

        ServiceType::create($serviceTypeRequest->input());

        return redirect()->route('serviceTypes.listAll')->with('message',['success', __("Se agregó el servicio correctamente.")]);
    }
    public function edit($id){
        //POLICIES
        $canEditServiceType = auth()->user()->can('update', ServiceType::class );
        //END POLICIES
        if(! ($canEditServiceType) ){
            return back()->with('modalMessage',['Aviso', __("Su rol no le permite editar el servicio.")]);
        }
        $serviceType = ServiceType::with([])
            ->where('id',$id)
            ->orderBy('id', 'desc')
            ->first();

        $btnText = __("Actualizar servicio");

        //dd($vouchers);
        return view('serviceTypes.form', compact('serviceType','btnText'));
    }

    public function update(ServiceTypeRequest $serviceTypeRequest, ServiceType $serviceType){
        //POLICIES
        $canEditServiceType = auth()->user()->can('update', ServiceType::class );
        //END POLICIES
        if(! ($canEditServiceType) ){
            return back()->with('modalMessage',['Aviso', __("Su rol no le permite editar el servicio.")]);
        }

        //dd($customerRequest);
        $serviceType->fill($serviceTypeRequest->input())->save();

        //dd($customerRequest);
        return redirect()->route('serviceTypes.listAll')->with('message',['success', __("Se actualizó el servicio correctamente.")]);
    }


}
