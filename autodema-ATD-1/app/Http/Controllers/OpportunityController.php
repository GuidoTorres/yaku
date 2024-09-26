<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Company;
use App\Http\Requests\OpportunityRequest;
use App\Opportunity;
use App\Stage;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OpportunityController extends Controller
{
    public function dashboard(User $userDashboard = null){
        //POLICIES
        $canListOpportunities = auth()->user()->can('viewAny', Opportunity::class );
        //END POLICIES

        if(!($canListOpportunities) ){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite listar las oportunidades.")]);
        }

        $stages = Stage::with([])
            ->orderBy('id', 'asc')
            ->get();

        $companies = Company::get();

        //dd($vouchers);
        return view('opportunities.dashboard' , compact('stages', 'companies', 'userDashboard') );
    }
    public function listAll(){
        //POLICIES
        $canListOpportunities = auth()->user()->can('viewAny', Opportunity::class );
        $canViewOnlyHis = auth()->user()->can('viewOnlyHis', Opportunity::class );
        //END POLICIES

        if(!($canListOpportunities) ){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite listar las oportunidades.")]);
        }

        $stages = Stage::with([])
            ->orderBy('id', 'asc')
            ->get();

        $companies = Company::get();

        $opportunities = new Opportunity();
        if ($canViewOnlyHis){
            $opportunities = $opportunities->where('user_owner_id', auth()->user()->id);
        }
        $opportunities = $opportunities->orderBy('created_at', 'desc')->paginate(12);

        //dd($vouchers);
        return view('opportunities.listAll' , compact('stages', 'companies', 'opportunities') );
    }
    public function listCompany(Company $company){
        //POLICIES
        $canListOpportunities = auth()->user()->can('viewAny', Opportunity::class );
        $canViewOnlyHis = auth()->user()->can('viewOnlyHis', Opportunity::class );
        //END POLICIES

        if(!($canListOpportunities) ){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite listar las oportunidades.")]);
        }

        $stages = Stage::with([])
            ->orderBy('id', 'asc')
            ->get();

        $companies = Company::get();

        $opportunities = new Opportunity();
        if ($canViewOnlyHis){
            $opportunities = $opportunities->where('user_owner_id', auth()->user()->id);
        }
        $opportunities = $opportunities->orderBy('created_at', 'desc')->where('company_id', $company->id)->paginate(12);

        //dd($vouchers);
        return view('opportunities.listAll' , compact('stages', 'companies', 'opportunities') );
    }
    public function filterList(Request $request){
        //POLICIES
        $canListOpportunities = auth()->user()->can('viewAny', Opportunity::class );
        $canViewOnlyHis = auth()->user()->can('viewOnlyHis', Opportunity::class );
        //END POLICIES

        if(!($canListOpportunities) ){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite listar las oportunidades.")]);
        }

        $opportunities = new Opportunity();

        $name_search = $request->has('name_search') ? $request->input('name_search'): null;
        $company_name_search = $request->has('company_name_search') ? $request->input('company_name_search'): null;

        // Search for a opportunity based on their name.
        if ($name_search) {
            $opportunities = $opportunities->where('name','LIKE', '%'.$name_search.'%');
        }
        // Search for a opportunity based on their name.
        if ($company_name_search) {
            $opportunities = $opportunities->whereHas("company", function ($q) use ($company_name_search) {
                $q->where("company_name",'LIKE', '%'.$company_name_search.'%');
            });
        }

        $stages = Stage::with([])
            ->orderBy('id', 'asc')
            ->get();

        $companies = Company::get();

        if ($canViewOnlyHis){
            $opportunities = $opportunities->where('user_owner_id', auth()->user()->id);
        }
        $opportunities = $opportunities->orderBy('created_at', 'desc')->paginate(12);

        //dd($vouchers);
        return view('opportunities.listAll' , compact('stages', 'companies', 'search_input', 'opportunities') );
    }
    public function filter(Request $request, User $userDashboard = null){
        //POLICIES
        $canListOpportunities = auth()->user()->can('viewAny', Opportunity::class );
        //END POLICIES

        if(!($canListOpportunities) ){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite listar las oportunidades.")]);
        }

        $search_input = $request->has('search_input') ? $request->input('search_input'): null;

        $stages = Stage::with([])
            ->orderBy('id', 'asc')
            ->get();

        $companies = Company::get();

        //dd($vouchers);
        return view('opportunities.dashboard' , compact('stages', 'companies', 'search_input', 'userDashboard') );
    }
    public function listStageAjax(Request $request){
        //POLICIES
        $canListOpportunities = auth()->user()->can('viewAny', Opportunity::class );
        $canViewOnlyHis = auth()->user()->can('viewOnlyHis', Opportunity::class );
        //END POLICIES

        if(!($canListOpportunities) ){
            return 403;
        }

        $stage_id = $request->has('stage_id') ? $request->input('stage_id'): null;
        $search_input = $request->has('search_input') ? $request->input('search_input'): null;
        $user_dashboard = $request->has('user_dashboard') ? $request->input('user_dashboard'): null;

        $opportunities = Opportunity::with([
            'company'
        ])
            ->orderBy('order', 'asc')
            ->orderBy('order_updated_at', 'desc')
            ->where('stage_id', $stage_id);

        if($search_input){
            $opportunities = $opportunities->where('name','LIKE', '%'.$search_input.'%');
        }
        if ($user_dashboard || $user_dashboard > 0){
            $opportunities = $opportunities->where('user_owner_id', $user_dashboard);
        }

        if ($canViewOnlyHis){
            $opportunities = $opportunities->where('user_owner_id', auth()->user()->id);
        }
        $opportunities = $opportunities->take(20)->get();


        //dd($opportunities->toJson());

        return $opportunities->toJson();
    }
    public function getStageTotalAjax(Request $request){
        //POLICIES
        $canListOpportunities = auth()->user()->can('viewAny', Opportunity::class );
        $canViewOnlyHis = auth()->user()->can('viewOnlyHis', Opportunity::class );
        //END POLICIES

        if(!($canListOpportunities) ){
            return 403;
        }

        $stage_id = $request->has('stage_id') ? $request->input('stage_id'): null;
        $search_input = $request->has('search_input') ? $request->input('search_input'): null;
        $user_dashboard = $request->has('user_dashboard') ? $request->input('user_dashboard'): null;

        $stageTotal = new Opportunity();
        if($search_input){
            $stageTotal = $stageTotal->where('name','LIKE', '%'.$search_input.'%');
        }
        if ($user_dashboard || $user_dashboard > 0){
            $stageTotal = $stageTotal->where('user_owner_id', $user_dashboard);
        }
        if ($canViewOnlyHis){
            $stageTotal = $stageTotal->where('user_owner_id', auth()->user()->id);
        }
        $stageTotal = $stageTotal->where('stage_id', $stage_id)->sum('service_price');

        return $stageTotal;
    }
    public function updateOpportunityAjax(Request $request){
        //POLICIES
        $canUpdateOpportunities = true;
        //END POLICIES

        if(! ($canUpdateOpportunities) ){
            return 403;
        }

        $opportunity_id = $request->has('opportunity') ? $request->input('opportunity'): null;
        $new_stage_id = $request->has('stage') ? $request->input('stage'): null;
        $new_order = $request->has('order') ? $request->input('order'): null;

        $now = now();

        try{
            $opportunity_model = Opportunity::where('id', $opportunity_id)->first();
            $old_order = $opportunity_model->order;
            $old_stage_id = $opportunity_model->stage_id;
            $opportunity_id = $opportunity_model->id;


            $opportunity_model->update([
                "stage_id" => $new_stage_id,
                "order" => $new_order,
                "order_updated_at" => now(),
            ]);

            if($new_stage_id == $old_stage_id){
                    DB::select("
                    UPDATE opportunities SET
                        opportunities.order = 
                        CASE 
                        WHEN $new_order < $old_order AND opportunities.order < $old_order THEN
                           opportunities.order + 1
                        WHEN $new_order > $old_order AND opportunities.order > $old_order THEN
                           opportunities.order - 1
                        ELSE
                           opportunities.order
                        END               
                        WHERE  
                        opportunities.id != $opportunity_id AND
                        opportunities.stage_id = $new_stage_id AND
                        opportunities.order BETWEEN LEAST($new_order, $old_order) AND GREATEST($new_order, $old_order)
                ");
            }else{

                DB::select("
                    UPDATE opportunities SET
                        opportunities.order = 
                        CASE 
                        WHEN stage_id = $new_stage_id AND opportunities.order >= $new_order THEN
                           opportunities.order + 1
                        WHEN stage_id = $old_stage_id AND opportunities.order > $old_order THEN
                           opportunities.order - 1
                        ELSE
                           opportunities.order
                        END               
                        WHERE  
                        opportunities.id != $opportunity_id AND
                        (
                            (opportunities.stage_id = $new_stage_id AND opportunities.order >= $new_order ) OR 
                            (opportunities.stage_id = $old_stage_id AND opportunities.order > $old_order )
                        ) 
                ");

            }

            return 200;
        }catch (\Throwable $e){
            return $e->getMessage();
        }


    }
    public function store(OpportunityRequest $opportunityRequest){

        //POLICIES
        $canCreateOpportunities = true;
        //END POLICIES

        if(! $canCreateOpportunities){
            return back()->with('modalMessage',['Aviso', __("Su rol no le permite crear oportunidades.")]);
        }

        $closed_at = NULL;
        $stage = $opportunityRequest->input('stage_id');

        if( $stage == Stage::CLOSED_WON ||  $stage == Stage::CLOSED_LOST){
            $closed_at = now();
        }

        $opportunityRequest->merge([
            'user_owner_id' => auth()->user()->id,
            'user_id' => auth()->user()->id,
            'order' => 0,
            'order_updated_at' => now(),
            'closed_at' => $closed_at,
        ]);

        try {
            $opportunity = Opportunity::create($opportunityRequest->input());
            //UPDATE CODE
            $this->generateCode($opportunity);

            $serviceTypesArr = $opportunityRequest->input("service_types");
            $AdditionalsArr = $opportunityRequest->input("additionals");

            $opportunity->serviceTypes()->syncWithoutDetaching($serviceTypesArr);
            $opportunity->additionals()->syncWithoutDetaching($AdditionalsArr);

            //UPDATE OTHER OPPORTUNITTIES
            try {
                //UPDATE OTHER OPPORTUNITTIES
                Opportunity::where('stage_id',$stage )->update([
                    'order' => DB::raw('opportunities.order+1'),
                ]);
            } catch(\Illuminate\Database\QueryException $e){
                //dd($e);
                return back()->with('modalMessage',['Aviso',
                    __("Se agregó la oportunidad, sin embargo hubo un error actualizando las otras oportunidades dentro de la etapa.")]);

            }

            return back()->with('modalMessage',['Aviso',
                __("Se agregó correctamente la oportunidad.")]);
        } catch(\Illuminate\Database\QueryException $e){
            dd($e);
            return back()->with('modalMessage',['Aviso',
                __("Hubo un error agregando la oportunidad,
                por favor verifique que está colocando los datos requeridos.")]);

        }
    }
    public function update(OpportunityRequest $opportunityRequest, Opportunity $opportunity){

        //POLICIES
        $canUpdateThisOpportunity = auth()->user()->can('update', [Opportunity::class, $opportunity] );

        if(!($canUpdateThisOpportunity) ){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite actualizar esta oportunidad.")]);
        }
        //END POLICIES

        try {
            $opportunity_updated = $opportunity->fill($opportunityRequest->input())->save();
            $this->generateCode($opportunity);


            $serviceTypesArr = $opportunityRequest->input("service_types");
            $AdditionalsArr = $opportunityRequest->input("additionals");

            $opportunity->serviceTypes()->sync($serviceTypesArr);
            $opportunity->additionals()->sync($AdditionalsArr);

            return back()->with('modalMessage',['Aviso',
                __("Se actualizó correctamente la oportunidad.")]);
        } catch(\Illuminate\Database\QueryException $e){
            return back()->with('modalMessage',['Aviso',
                __("Hubo un error actualizando la oportunidad,
                por favor verifique que está colocando los datos requeridos.")]);

        }
    }

    public function viewOpportunity($id){

        $opportunity = Opportunity::where("id", $id)->get()->first();
        $activities = Activity::where("opportunity_id", $opportunity->id)->orderBy("did_at", "desc")->get();
        $serviceTypesArr = $opportunity->serviceTypes->pluck("id")->toArray();
        $additionalssArr = $opportunity->additionals->pluck("id")->toArray();

        //POLICIES
        $canViewThisOpportunity = auth()->user()->can('view', [Opportunity::class, $opportunity] );

        if(!($canViewThisOpportunity) ){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite ver esta oportunidad.")]);
        }
        //END POLICIES

        return view('opportunities.viewOpportunity', compact('opportunity', 'activities', 'serviceTypesArr', 'additionalssArr'));
    }
    public function generateCode(Opportunity $opportunity){
        $userOwner = $opportunity->userOwner;
        $user_owner_name = strtoupper($userOwner->name." ".$userOwner->last_name);
        $abbreviation_user_owner = "";
        $words_user_owner = explode(" ", $user_owner_name);
        foreach ($words_user_owner as $wuo) {
            $abbreviation_user_owner .= $wuo[0];
        }
        $code = "COT-".$abbreviation_user_owner."-".$opportunity->id;
        $opportunity->update([
            "code" => $code
        ]);
    }
}
