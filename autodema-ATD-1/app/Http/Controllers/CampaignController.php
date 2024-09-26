<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Http\Requests\CampaignRequest;
use App\User;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function listAll(){
        //POLICIES
        $canListAllCampaigns = auth()->user()->can('viewAny', Campaign::class );
        //END POLICIES

        if(! $canListAllCampaigns){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite ver campañas.")]);
        }

        $campaigns = Campaign::with([]);

        $campaigns = $campaigns->orderBy('id', 'desc')->paginate(12);

        return view('campaigns.listAll', compact('campaigns'));
    }

    public function admin($id){
        //POLICIES
        $canListAllCampaigns = auth()->user()->can('view', Campaign::class );;
        //END POLICIES

        if(! $canListAllCampaigns){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite ver campañas.")]);
        }

        $campaign = Campaign::with([])
            ->where('id',$id)
            ->orderBy('id', 'desc')
            ->first();

        //dd($companies);
        return view('campaigns.admin', compact('campaign'));
    }
    public function filter(Request $request){
        //POLICIES
        $canListAllCampaigns = auth()->user()->can('viewAny', Campaign::class );
        //END POLICIES
        if(! ($canListAllCampaigns) ){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite listar los usuarios.")]);
        }
        $campaigns = new Campaign();

        $name_search = $request->has('name_search') ? $request->input('name_search'): null;
        $campaign_type_search = $request->has('campaign_type_search') ? $request->input('campaign_type_search'): null;

        // Search for a user based on their name.
        if ($name_search) {
            $campaigns = $campaigns->where('name','LIKE', '%'.$name_search.'%');
        }
        // Search for a user based on their role.
        if ($campaign_type_search) {
            $campaigns = $campaigns->where('campaign_type_id', $campaign_type_search);
        }

        $campaigns = $campaigns->paginate(12);

        //dd($vouchers);
        return view('campaigns.listAll', compact('campaigns') );
    }

    public function create(){;
        $canCreateCampaign= auth()->user()->can('create', Campaign::class );
        if(! $canCreateCampaign){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite crear campañas.")]);
        }

        $campaign = new Campaign;

        $btnText = __("Crear campaña");
        return view('campaigns.form', compact('campaign','btnText'));
    }

    public function store(CampaignRequest $campaignRequest){
        $canCreateCampaign= auth()->user()->can('create', Campaign::class );
        if(! $canCreateCampaign){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite crear campañas.")]);
        }

        //dd($companyRequest->all());

        $campaignRequest->merge(['user_id' => auth()->user()->id ]);
        $campaignRequest->merge(['state' => Campaign::ACTIVE ]);

        Campaign::create($campaignRequest->input());

        return redirect()->route('campaigns.listAll')->with('message',['success', __("Se agregó la campaña correctamente.")]);
    }

    public function edit($id){
        $campaign = Campaign::with([])
            ->where('id',$id)
            ->orderBy('id', 'desc')
            ->first();

        //POLICIES
        $canListEditCampaign = auth()->user()->can('update', [Campaign::class, $campaign] );
        if(! ($canListEditCampaign) ){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite editar la campañas.")]);
        }
        //END POLICIES
        $btnText = __("Actualizar campaña");

        //dd($vouchers);
        return view('campaigns.form', compact('campaign','btnText'));
    }

    public function update(CampaignRequest $campaignRequest, Campaign $campaign){
        //POLICIES
        $canListEditCampaign = auth()->user()->can('update', [Campaign::class, $campaign] );
        //END POLICIES
        if(! ($canListEditCampaign) ){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite editar la campañas.")]);
        }

        //dd($customerRequest);
        $campaign->fill($campaignRequest->input())->save();

        //dd($customerRequest);
        return redirect()->route('campaigns.listAll')->with('message',['success', __("Se actualizó la campaña correctamente.")]);
    }
}
