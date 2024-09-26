<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitRequest;
use App\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function listAll(){
        //POLICIES
        $canListAllUnits = true;
        //END POLICIES

        $units = Unit::with([]);

        if(! $canListAllUnits){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite ver unidades.")]);
        }

        $units = $units->orderBy('id', 'desc')->paginate(12);

        return view('units.listAll', compact('units'));
    }

    public function filter(Request $request){
        //POLICIES
        $canListAllUnits = true;
        //END POLICIES
        if(! ($canListAllUnits) ){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite ver unidades.")]);
        }
        $units = new Unit();

        $name_search = $request->has('name_search') ? $request->input('name_search'): null;

        // Search for a user based on their name.
        if ($name_search) {
            $units = $units
                ->where('magnitude','LIKE', '%'.$name_search.'%')
                ->orWhere('unit','LIKE', '%'.$name_search.'%')
                ->orWhere('symbol','LIKE', '%'.$name_search.'%');
        }

        $units = $units->paginate(12);

        //dd($vouchers);
        return view('units.listAll', compact('units'));
    }

    public function admin($id){
        $unit = Unit::with([])
            ->where('id',$id)
            ->orderBy('id', 'desc')
            ->first();

        //POLICIES
        $canListAllUnits = true;
        if(! $canListAllUnits){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite ver unidades.")]);
        }
        //END POLICIES


        //dd($companies);
        return view('units.admin', compact('unit'));
    }

    public function create(){
        $canCreateUnit = true;
        //dd($companyRequest->all());
        if(! $canCreateUnit){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite crear unidades.")]);
        }

        $unit = new Unit();

        $btnText = __("Crear");
        return view('units.form', compact('unit', 'btnText'));
    }

    public function store(UnitRequest $unitRequest){
        $canCreateUnit = true;
        //dd($companyRequest->all());
        if(! $canCreateUnit){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite crear unidades.")]);
        }

        Unit::create($unitRequest->input());

        return back()->with('modalMessage',['Aviso', __("Se agregó la unidad correctamente.")]);
    }
    public function edit($id){

        $unit = Unit::with([])
            ->where('id',$id)
            ->orderBy('id', 'desc')
            ->first();

        $canUpdateUnit= true;
        //dd($companyRequest->all());
        if(! $canUpdateUnit){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite actualizar esta unidad.")]);
        }

        $btnText = __("Actualizar");

        //dd($vouchers);
        return view('units.form', compact('unit','btnText'));
    }
    public function update(UnitRequest $unitRequest, Unit $unit){

        $canUpdateUnit= true;
        //dd($companyRequest->all());
        if(! $canUpdateUnit){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite actualizar esta unidad.")]);
        }

        //dd($customerRequest);
        $unit->fill($unitRequest->input())->save();

        //dd($customerRequest);
        return back()->with('modalMessage',['Aviso', __("Se actualizó la unidad correctamente.")]);
    }

}
