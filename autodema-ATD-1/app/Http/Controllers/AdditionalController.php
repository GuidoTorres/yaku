<?php

namespace App\Http\Controllers;

use App\Additional;
use App\Http\Requests\AdditionalRequest;
use App\ServiceType;
use Illuminate\Http\Request;

class AdditionalController extends Controller
{
    public function listAll($id){
        //POLICIES
        $canEditServiceType = auth()->user()->can('update', ServiceType::class );

        //END POLICIES
        if(! ($canEditServiceType) ){
            return back()->with('modalMessage',['Aviso', __("Su rol no le permite editar el servicio.")]);
        }
        $serviceType = ServiceType::with(['additionals'])
            ->where('id',$id)
            ->orderBy('id', 'desc')
            ->first();

        $additionals = Additional::where('service_type_id',$id)->orderBy('id', 'desc')->paginate(12);

        //dd($vouchers);
        return view('additionals.listAll', compact('serviceType','additionals'));
    }

    public function admin($id){
        //POLICIES
        $canListServiceType = auth()->user()->can('view', ServiceType::class );
        //END POLICIES

        if(! $canListServiceType){
            return back()->with('modalMessage',['Aviso', __("Su rol no le permite ver el servicio.")]);
        }

        $additional = Additional::with(['serviceType'])
            ->where('id',$id)
            ->orderBy('id', 'desc')
            ->first();
        $serviceType = $additional->serviceType;

        //dd($companies);
        return view('additionals.admin', compact('serviceType','additional'));
    }

    public function filter(Request $request, $id){
        //POLICIES
        $canListAllServiceTypes = auth()->user()->can('viewAny', ServiceType::class );
        //END POLICIES
        if(! ($canListAllServiceTypes) ){
            return back()->with('modalMessage',['Aviso', __("Su rol no le permite ver los servicios.")]);
        }
        $additionals = new Additional();

        $name_search = $request->has('name_search') ? $request->input('name_search'): null;

        $serviceType = ServiceType::with(['additionals'])
            ->where('id',$id)
            ->orderBy('id', 'desc')
            ->first();

        $additionals = $serviceType->additionals();

        // Search for a user based on their name.
        if ($name_search) {
            $additionals = $additionals->where('name','LIKE', '%'.$name_search.'%');
        }

        $additionals = $additionals->paginate(12);

        //dd($vouchers);
        return view('additionals.listAll', compact('serviceType','additionals'), compact('serviceTypes') );
    }
    public function create($id){
        //POLICIES
        $canCreateServiceType = auth()->user()->can('create', ServiceType::class );
        //END POLICIES
        if(! ($canCreateServiceType) ){
            return back()->with('modalMessage',['Aviso', __("Su rol no le permite editar el adicional.")]);
        }
        $serviceType = ServiceType::with(['additionals'])
            ->where('id',$id)
            ->orderBy('id', 'desc')
            ->first();
        $additional = new Additional;

        $btnText = __("Crear adicional");
        return view('additionals.form', compact('serviceType','additional','btnText'));
    }

    public function store(AdditionalRequest $additionalRequest, $serviceTypeId){
        //POLICIES
        $canCreateServiceType = auth()->user()->can('create', ServiceType::class );
        //END POLICIES
        if(! ($canCreateServiceType) ){
            return back()->with('modalMessage',['Aviso', __("Su rol no le permite editar el servicio.")]);
        }

        //dd($companyRequest->all());

        $additionalRequest->merge(['service_type_id' => $serviceTypeId ]);

        Additional::create($additionalRequest->input());

        return redirect()->route('additionals.listAll', $serviceTypeId)->with('message',['success', __("Se agregó el adicional correctamente.")]);
    }
    public function edit($id){
        //POLICIES
        $canEditServiceType = auth()->user()->can('update', ServiceType::class );
        //END POLICIES
        if(! ($canEditServiceType) ){
            return back()->with('modalMessage',['Aviso', __("Su rol no le permite editar el servicio.")]);
        }
        $additional = Additional::with(['serviceType'])
            ->where('id',$id)
            ->orderBy('id', 'desc')
            ->first();
        $serviceType = $additional->serviceType;

        $btnText = __("Actualizar adicional");

        //dd($vouchers);
        return view('additionals.form', compact('serviceType','additional','btnText'));
    }

    public function update(AdditionalRequest $additionalReques, Additional $additional){
        //POLICIES
        $canEditServiceType = auth()->user()->can('update', ServiceType::class );
        //END POLICIES
        if(! ($canEditServiceType) ){
            return back()->with('modalMessage',['Aviso', __("Su rol no le permite editar el servicio.")]);
        }
        $serviceTypeId = $additional->serviceType->id;

        //dd($customerRequest);
        $additional->fill($additionalReques->input())->save();

        //dd($customerRequest);
        return redirect()->route('additionals.listAll', $serviceTypeId)->with('message',['success', __("Se actualizó el adicional correctamente.")]);
    }

}
