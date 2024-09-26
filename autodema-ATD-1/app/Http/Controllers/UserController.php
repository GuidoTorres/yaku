<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Parameter;
use App\Role;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function listAll(){
        //POLICIES
        $canListUsers = auth()->user()->can('viewAny', User::class );
        //END POLICIES

        if(! ($canListUsers) ){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite listar los usuarios.")]);
        }

        $users = User::with([])
            ->orderBy('id', 'desc')
            ->where('id','>', 1)
            ->paginate(12);

        //dd($vouchers);
        return view('users.listAll', compact('users') );
    }
    public function help(){
        $user = auth()->user();

        //dd($companies);
        return view('users.help', compact('user'));
    }
    public function filter(Request $request){
        //POLICIES
        $canListUsers = auth()->user()->can('viewAny', User::class );
        //END POLICIES
        if(! ($canListUsers) ){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite listar los usuarios.")]);
        }
        $users = new User();

        $name_search = $request->has('name_search') ? $request->input('name_search'): null;
        $role_search = $request->has('role_search') ? $request->input('role_search'): null;

        // Search for a user based on their name.
        if ($name_search) {
            $users = $users->where('name','LIKE', '%'.$name_search.'%')->orWhere('last_name','LIKE', '%'.$name_search.'%');
        }
        // Search for a user based on their role.
        if ($role_search) {
            $users = $users->where('role_id', $role_search);
        }

        $users = $users->paginate(12);

        //dd($vouchers);
        return view('users.listAll', compact('users') );
    }

    public function admin($id){
        $canCreateUser = auth()->user()->can('view', User::class );
        if(! $canCreateUser){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite ver este usuario.")]);
        }

        $user = User::with([])
            ->where('id',$id)
            ->orderBy('id', 'desc')
            ->first();

        //dd($companies);
        return view('users.admin', compact('user'));
    }


    public function create(User $user){
        $canCreateUser = auth()->user()->can('create', User::class );
        if(! $canCreateUser){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite crear usuarios.")]);
        }

        $user = new User;

        $btnText = __("Crear usuario");
        return view('users.form', compact('user','btnText'));
    }
    public function store(UserRequest $userRequest){

        $canCreateUser = auth()->user()->can('create', User::class );
        if(! $canCreateUser){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite crear usuarios.")]);
        }

        $role = $userRequest->input("role_id");

        // Search for a user based on their name.
        $parameters = [];
        if ($role == Role::VISITOR) {
            for($i = 1; $i <= 3; $i++ ){
                $input = "parameter_".$i;
                if($userRequest->input($input) > 0){
                    $parameters[] =$userRequest->input($input);
                    $userRequest->merge([$input => null]);
                }
            }
        }

        $user = User::create($userRequest->input());

        $user->parameters()->attach($parameters);

        return redirect()->route('users.listAll')->with('message',['success', __("Se agregó el usuario correctamente.")]);
    }

    public function edit($id){

        $user = User::with([])
            ->where('id',$id)
            ->orderBy('id', 'desc')
            ->first();

        $canUpdateUser = auth()->user()->can('update', [User::class ,$user]);

        if(! $canUpdateUser){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite actualizar este usuario.")]);
        }

        $btnText = __("Actualizar usuario");


        $parameters = $user->parameters()->get()->pluck("id");

        //dd($vouchers);
        return view('users.form', compact('user','btnText', 'parameters'));
    }


    public function update(UserRequest $userRequest, User $user){

        $canUpdateUser= auth()->user()->can('update', [User::class ,$user]);

        if(! $canUpdateUser){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite actualizar este contacto.")]);
        }
        //dd($customerRequest);
        $role = $userRequest->input("role_id");
        // Search for a user based on their name.
        $parameters = [];
        if ($role == Role::VISITOR) {
            $user->parameters()->detach();
            for($i = 1; $i <= 3; $i++ ){
                $input = "parameter_".$i;
                if($userRequest->input($input) > 0){
                    $parameters[] =$userRequest->input($input);
                    $userRequest->merge([$input => null]);
                }
            }

            $user->parameters()->attach($parameters);
        }

        $password = $userRequest->input('password');

        if (!$password){
            $userRequest = $userRequest->except('password');
        }else{
            $userRequest = $userRequest->input();
        }

        $user->fill($userRequest)->save();

        //dd($customerRequest);
        return redirect()->route('users.listAll')->with('message',['success', __("Se actualizó el usuario correctamente.")]);
    }
    public function listUserParameters($id){
        //POLICIES
        $canListAllParameters = true;
        //END POLICIES

        $parameters = Parameter::with([]);
        $user = User::where('id', $id)->first();

        if(! $canListAllParameters){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite ver parámetros.")]);
        }

        $parameters = $parameters->where('enabled',1)->orderBy('id', 'desc')->paginate(200);

        return view('users.listUserParameters', compact('parameters', 'user'));
    }

    public function filterParameters(Request $request, $id){
        //POLICIES
        $canListAllParameters = true;
        //END POLICIES
        if(! ($canListAllParameters) ){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite ver parámetros.")]);
        }
        $parameters = new Parameter();
        $user = User::where('id', $id)->first();

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

        return view('users.listUserParameters', compact('parameters', 'user'));
    }
    public function updateParameter(Request $request)
    {
        try{
            $user_id = $request->input('user_id');
            $parameter_id = $request->input('parameter_id');
            $activated = $request->input('activated') === 'true' || $request->input('activated') === true;

            $user = User::find($user_id);

            if ($activated == "true" || $activated == true) {
                $user->parameters()->attach($parameter_id);
                return 200;
            } else {
                $user->parameters()->detach($parameter_id);
                return 200;
            }
        }catch (\Throwable $e){
            return $e->getMessage();
        }
    }

}
