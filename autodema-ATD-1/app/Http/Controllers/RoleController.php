<?php

namespace App\Http\Controllers;

use App\Parameter;
use App\Role;
use App\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function listAll(){
        //POLICIES
        $canListUsers = auth()->user()->can('viewAny', User::class );
        //END POLICIES

        if(! ($canListUsers) ){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite listar los roles.")]);
        }

        $roles = Role::with([])
            ->orderBy('id', 'asc')
            ->where('id','>', 1)
            ->paginate(12);

        //dd($vouchers);
        return view('roles.listAll', compact('roles') );
    }
    public function listRoleParameters($id){
        //POLICIES
        $canListAllParameters = true;
        //END POLICIES

        $parameters = Parameter::with([]);
        $role = Role::where('id', $id)->first();

        $roleParameters = $role->parameters();

        if(! $canListAllParameters){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite ver parámetros.")]);
        }

        $parameters = $parameters->where('enabled',1)->orderBy('id', 'desc')->paginate(200);

        return view('roles.listRoleParameters', compact('parameters', 'role', 'roleParameters'));
    }

    public function filterParameters(Request $request, $id){
        //POLICIES
        $canListAllParameters = true;
        //END POLICIES
        if(! ($canListAllParameters) ){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite ver parámetros.")]);
        }
        $parameters = new Parameter();
        $role = Role::where('id', $id)->first();

        $roleParameters = $role->parameters()->get();

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

        return view('roles.listRoleParameters', compact('parameters', 'role', 'roleParameters'));
    }
    public function updateParameter(Request $request)
    {
        try{
            $role_id = $request->input('role_id');
            $parameter_id = $request->input('parameter_id');
            $activated = $request->input('activated') === 'true' || $request->input('activated') === true;

            $role = Role::find($role_id);

            if ($activated == "true" || $activated == true) {
                $role->parameters()->attach($parameter_id);
                return 200;
            } else {
                $role->parameters()->detach($parameter_id);
                return 200;
            }
        }catch (\Throwable $e){
            return $e->getMessage();
        }
    }
}
