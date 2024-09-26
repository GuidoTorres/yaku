<?php

namespace App\Http\Controllers;

use App\Company;
use App\Opportunity;
use App\Report;
use App\ServiceType;
use App\Stage;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function dashboard($year = null, $months = null){
        //POLICIES
        $canListDashboard = auth()->user()->can('viewAny', Report::class );
        //END POLICIES

        if(!($canListDashboard) ){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite listar las oportunidades.")]);
        }

        if(!$year){
            $year = date('Y');
        }

        $usersWon = $this->usersWon($year, $months);
        $servicesWon = $this->servicesWon($year, $months);
        $companiesWon = $this->companiesWon($year, $months);
        $stagesTotal = $this->stagesTotal($year, $months);
        $totalWon = $this->totalWon($year, $months);
        //dd($usersWon);

        $months = explode(",", $months);

        return view('reports.dashboard' , compact( 'usersWon', 'servicesWon', 'year', 'months', 'companiesWon', 'stagesTotal', 'totalWon') );
    }
    public function totalWon($year, $months = null){
        //POLICIES
        $canListThisReport = auth()->user()->can('view', Report::class );
        //END POLICIES
        if(!($canListThisReport) ){
            //FORBIDDEN
            return 403;
        }

        $getSumOpportunities = Opportunity::whereYear('created_at', $year );
        //MONTHS
        if ($months){
            $months = explode(',', $months);
            $getSumOpportunities = $getSumOpportunities
                ->where(function($query) use ($months) {
                    foreach ($months as $month){
                        $query->orWhereMonth('created_at', $month);
                    }
                });
        }
        //MONTHS

        $getSumOpportunities = $getSumOpportunities->where('stage_id', Stage::CLOSED_WON)->sum("service_price");

        //dd($getSumOpportunities->toSql());

        return $getSumOpportunities;
    }
    public function usersWon($year = null, $months = null){
        //POLICIES
        $canListThisReport = auth()->user()->can('view', Report::class );
        //END POLICIES
        if(!($canListThisReport) ){
            //FORBIDDEN
            return 403;
        }

        $getSumOpportunities = User::groupBy('users.id')
            ->leftJoin('opportunities', function($join) use ($year, $months){
                $join->on('users.id', '=', 'opportunities.user_owner_id');
                $join->whereYear('opportunities.created_at', $year );
                if ($months){
                    $months = explode(',', $months);
                    $join
                        ->where(function($query) use ($months) {
                            foreach ($months as $month){
                                $query->orWhereMonth('opportunities.created_at', $month);
                            }
                        });
                }
                $join->where('opportunities.stage_id', Stage::CLOSED_WON);
            })
            ->orderBy('sum', 'desc')
            ->selectRaw('sum(opportunities.service_price) as sum, user_owner_id, CONCAT(users.name," ",users.last_name) as name')
            ->get();
        //dd($getSumOpportunities);
        //$getSumOpportunities = $getSumOpportunities->toJson();

        return $getSumOpportunities;
    }
    public function servicesWon($year = null, $months = null){
        //POLICIES
        $canListThisReport = auth()->user()->can('view', Report::class );
        //END POLICIES
        if(!($canListThisReport) ){
            //FORBIDDEN
            return 403;
        }

        $getSumOpportunities = ServiceType::groupBy('service_types.id')
            ->leftJoin('opportunity_service_type', function($join){
                $join->on('service_types.id', '=', 'opportunity_service_type.service_type_id');
            })
            ->leftJoin('opportunities', function($join) use ($year, $months){
                $join->on('opportunities.id', '=', 'opportunity_service_type.opportunity_id');
                $join->where('opportunities.stage_id', Stage::CLOSED_WON);
                $join->whereYear('opportunities.created_at', $year );
                if ($months){
                    $months = explode(',', $months);
                    $join
                        ->where(function($query) use ($months) {
                            foreach ($months as $month){
                                $query->orWhereMonth('opportunities.created_at', $month);
                            }
                        });
                }
            })
            ->selectRaw('count(opportunities.id) as sum, service_types.name')
            ->get();
        //dd($getSumOpportunities->toJson());
        //$getSumOpportunities = $getSumOpportunities->toJson();

        return $getSumOpportunities;
    }
    public function companiesWon($year = null, $months = null){
        //POLICIES
        $canListThisReport = auth()->user()->can('view', Report::class );
        //END POLICIES
        if(!($canListThisReport) ){
            //FORBIDDEN
            return 403;
        }

        $getSumOpportunities = Company::groupBy('companies.id')
            ->leftJoin('opportunities', function($join) use ($year, $months){
                $join->on('companies.id', '=', 'opportunities.company_id');
                $join->whereYear('opportunities.created_at', $year );
                if ($months){
                    $months = explode(',', $months);
                    $join
                        ->where(function($query) use ($months) {
                            foreach ($months as $month){
                                $query->orWhereMonth('opportunities.created_at', $month);
                            }
                        });
                }
                $join->where('opportunities.stage_id', Stage::CLOSED_WON);
            })
            ->orderBy('sum', 'desc')
            ->limit(10)
            ->selectRaw('sum(opportunities.service_price) as sum, companies.company_name as name')
            ->get();
        //dd($getSumOpportunities);
        //$getSumOpportunities = $getSumOpportunities->toJson();

        return $getSumOpportunities;
    }

    public function stagesTotal($year = null, $months = null){
        //POLICIES
        $canListThisReport = auth()->user()->can('view', Report::class );
        //END POLICIES
        if(!($canListThisReport) ){
            //FORBIDDEN
            return 403;
        }

        $getSumOpportunities = Stage::groupBy('stages.id')
            ->leftJoin('opportunities', function($join) use ($year, $months){
                $join->on('stages.id', '=', 'opportunities.stage_id');
                $join->whereYear('opportunities.created_at', $year );
                if ($months){
                    $months = explode(',', $months);
                    $join
                        ->where(function($query) use ($months) {
                            foreach ($months as $month){
                                $query->orWhereMonth('opportunities.created_at', $month);
                            }
                        });
                }
            })
            ->orderBy('stages.id', 'asc')
            ->selectRaw('sum(opportunities.service_price) as sum, stages.name as name')
            ->get();
        //dd($getSumOpportunities);
        //$getSumOpportunities = $getSumOpportunities->toJson();

        return $getSumOpportunities;
    }

    public function servicesWonPrice($year = null, $months = null){
        //POLICIES
        $canListThisReport = auth()->user()->can('view', Report::class );
        //END POLICIES
        if(!($canListThisReport) ){
            //FORBIDDEN
            return 403;
        }

        $getSumOpportunities = ServiceType::groupBy('service_types.id')
            ->leftJoin('opportunity_service_type', function($join){
                $join->on('service_types.id', '=', 'opportunity_service_type.service_type_id');
            })
            ->leftJoin('opportunities', function($join) use ($year, $months){
                $join->on('opportunities.id', '=', 'opportunity_service_type.opportunity_id');
                $join->where('opportunities.stage_id', Stage::CLOSED_WON);
                $join->whereYear('opportunities.created_at', $year );
                if ($months){
                    $months = explode(',', $months);
                    $join
                        ->where(function($query) use ($months) {
                            foreach ($months as $month){
                                $query->orWhereMonth('opportunities.created_at', $month);
                            }
                        });
                }
            })
            ->selectRaw('sum(opportunities.service_price) as sum, service_types.name')
            ->get();
        //dd($getSumOpportunities->toJson());
        //$getSumOpportunities = $getSumOpportunities->toJson();

        return $getSumOpportunities->toJson();
    }



    public function usersOpportunitiesSum(Request $request){
        //POLICIES
        $canListThisReport = auth()->user()->can('view', Report::class );
        //END POLICIES

        if(!($canListThisReport) ){
            //FORBIDDEN
            return 403;
        }

/*
        $getSumOpportunities = Opportunity::groupBy('user_owner_id')
            ->selectRaw('sum(service_price) as sum, user_owner_id')
            ->pluck('sum','user_owner_id');
        $getSumOpportunities = Opportunity::groupBy('user_owner_id')
            ->join('users', 'opportunities.user_owner_id', '=', 'users.id')
            ->selectRaw('sum(service_price) as sum, user_owner_id, users.name, users.last_name')
            ->get();
*/
        $year = $request->has('year') ? $request->input('year'): null;
        $months = $request->has('months') ? $request->input('months'): null;

        if(!$year){
            $year = date('Y');
        }


        $getSumOpportunities = User::groupBy('users.id')
            ->leftJoin('opportunities', function($join) use ($year, $months){
                $join->on('users.id', '=', 'opportunities.user_owner_id');
                $join->whereYear('opportunities.created_at', $year );
                if ($months){
                    $months = explode(',', $months);
                    $join
                        ->where(function($query) use ($months) {
                            foreach ($months as $month){
                                $query->orWhereMonth('opportunities.created_at', $month);
                            }
                        });
                }
            })
            ->selectRaw('sum(opportunities.service_price) as sum, user_owner_id, users.name, users.last_name')
            ->get();

        //dd($getSumOpportunities);

        $getSumOpportunities = $getSumOpportunities->toJson();

        return $getSumOpportunities;
    }
}
