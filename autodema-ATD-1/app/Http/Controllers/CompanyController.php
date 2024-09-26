<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Requests\CompanyRequest;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function listAll(){
        //POLICIES
        $canListAllCompanies = auth()->user()->can('viewAny', Company::class );
        //END POLICIES

        $companies = Company::with([]);

        if(! $canListAllCompanies){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite crear oportunidades.")]);
        }

        $companies = $companies->orderBy('id', 'desc')->paginate(12);

        return view('companies.listAll', compact('companies'));
    }

    public function admin($id){
        $company = Company::with([])
            ->where('id',$id)
            ->orderBy('id', 'desc')
            ->first();

        //POLICIES
        $canListAllCompanies = auth()->user()->can('view', Company::class );
        if(! $canListAllCompanies){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite crear oportunidades.")]);
        }
        //END POLICIES


        //dd($companies);
        return view('companies.admin', compact('company'));
    }

    public function filter(Request $request){
        //POLICIES
        $canListUsers = auth()->user()->can('viewAny', Company::class );
        //END POLICIES
        if(! ($canListUsers) ){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite listar las empresas.")]);
        }
        $companies = new Company();

        $company_name_search = $request->has('company_name_search') ? $request->input('company_name_search'): null;
        $tax_number_search = $request->has('tax_number_search') ? $request->input('tax_number_search'): null;

        // Search for a user based on their name.
        if ($company_name_search) {
            $companies = $companies->where('company_name','LIKE', '%'.$company_name_search.'%');
        }
        // Search for a user based on their role.
        if ($tax_number_search) {
            $companies = $companies->where('tax_number', $tax_number_search);
        }

        $companies = $companies->paginate(12);

        //dd($vouchers);
        return view('companies.listAll', compact('companies') );
    }

    public function create(){
        $canCreateCompany= auth()->user()->can('create', Company::class );
        //dd($companyRequest->all());
        if(! $canCreateCompany){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite crear empresas.")]);
        }

        $company = new Company;

        $btnText = __("Crear empresa");
        return view('companies.form', compact('company','btnText'));
    }

    public function store(CompanyRequest $companyRequest){

        $canCreateCompany = auth()->user()->can('create', Company::class );
        //dd($companyRequest->all());
        if(! $canCreateCompany){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite crear empresas.")]);
        }

        $companyRequest->merge(['user_id' => auth()->user()->id ]);

        Company::create($companyRequest->input());

        return back()->with('message',['success', __("Se agregó el cliente correctamente.")]);
    }

    public function edit($id){

        $company = Company::with(['user'])
            ->where('id',$id)
            ->orderBy('id', 'desc')
            ->first();

        $canUpdateCompany= auth()->user()->can('update', [Company::class, $company] );
        //dd($companyRequest->all());
        if(! $canUpdateCompany){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite actualizar esta empresa.")]);
        }

        $btnText = __("Actualizar empresa");

        //dd($vouchers);
        return view('companies.form', compact('company','btnText'));
    }

    public function update(CompanyRequest $companyRequest, Company $company){

        $canUpdateCompany= auth()->user()->can('update', [Company::class, $company] );
        //dd($companyRequest->all());
        if(! $canUpdateCompany){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite actualizar esta empresa.")]);
        }

        //dd($customerRequest);
        $company->fill($companyRequest->input())->save();

        //dd($customerRequest);
        return back()->with('message',['success', __("Se actualizó la empresa correctamente.")]);
    }



}
