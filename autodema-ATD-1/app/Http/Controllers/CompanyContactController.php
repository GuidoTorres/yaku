<?php

namespace App\Http\Controllers;

use App\Company;
use App\CompanyContact;
use App\Http\Requests\CompanyContactRequest;
use Illuminate\Http\Request;

class CompanyContactController extends Controller
{
    public function listCompany(Company $company){
        //POLICIES
        $canListThisCompanyContacts = auth()->user()->can('viewContacts', [Company::class, $company] );
        if(! $canListThisCompanyContacts){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite ver los contactos de esta empresa.")]);
        }
        //END POLICIES

        $companyContacts = $company->companyContacts()->orderBy("principal", 'ASC')->paginate(12);

        return view('companyContacts.listAll', compact('companyContacts', 'company'));
    }

    public function admin($id){
        $companyContact = CompanyContact::with([])
            ->where('id',$id)
            ->orderBy('id', 'desc')
            ->first();

        //POLICIES
        $company = $companyContact->company;
        $canListThisCompanyContacts = auth()->user()->can('viewContacts', [Company::class, $company] );
        if(! $canListThisCompanyContacts){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite ver los contactos de esta empresa.")]);
        }
        //END POLICIES
        //dd($companies);
        return view('companyContacts.admin', compact('companyContact'));
    }


    public function create(Company $company = null){

        $canCreateCompanyContact = auth()->user()->can('createContacts', [Company::class, $company] );
        if(! $canCreateCompanyContact){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite crear contactos para esta empresa.")]);
        }

        $companyContact = new CompanyContact;

        $btnText = __("Crear contacto");
        return view('companyContacts.form', compact('companyContact', 'company','btnText'));
    }

    public function store(CompanyContactRequest $companyContactRequest){

        $company = Company::where('id', $companyContactRequest->input('company_id'))->first();
        $canCreateCompanyContact = auth()->user()->can('createContacts', [Company::class, $company] );
        if(! $canCreateCompanyContact){
            return back()->with('modalMessage',['Aviso', __("Su rol no le permite crear contactos para esta empresa.")]);
        }

        $companyContactRequest->merge(['user_id' => auth()->user()->id ]);
        CompanyContact::create($companyContactRequest->input());

        $company_id = $companyContactRequest->input('company_id');

        return redirect()->route('companyContacts.listCompany', $company_id)->with('message',['success', __("Se agregó el contacto correctamente.")]);
    }

    public function edit($id){
        $companyContact = CompanyContact::with([])
            ->where('id',$id)
            ->orderBy('id', 'desc')
            ->first();

        $company = $companyContact->company;
        //POLICIES
        $canUpdateCompanyContact = auth()->user()->can('updateContacts', [Company::class, $company] );
        if(! $canUpdateCompanyContact){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite crear contactos para esta empresa.")]);
        }
        //POLICIES

        $btnText = __("Actualizar empresa");

        //dd($vouchers);
        return view('companyContacts.form', compact('companyContact','company','btnText'));
    }

    public function update(CompanyContactRequest $companyContactRequest, CompanyContact $companyContact){
        $company = $companyContact->company;
        //POLICIES
        $canUpdateCompanyContact = auth()->user()->can('updateContacts', [Company::class, $company] );
        if(! $canUpdateCompanyContact){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite crear contactos para esta empresa.")]);
        }
        //POLICIES

        //dd($customerRequest);
        $companyContact->fill($companyContactRequest->input())->save();

        //dd($customerRequest);
        return redirect()->route('companyContacts.listCompany', $companyContact->company_id)->with('message',['success', __("Se actualizó el contacto correctamente.")]);
    }






    public function getCompanyContactsAjax(Request $request){
        //POLICIES
        $canListCompanyContacts = true;
        //END POLICIES

        if(! ($canListCompanyContacts) ){
            return 403;
        }

        $company_id = $request->has('company') ? $request->input('company'): null;

        $companyContacts = CompanyContact::where('company_id', $company_id)->get()->toJson();

        return $companyContacts;
    }
}
