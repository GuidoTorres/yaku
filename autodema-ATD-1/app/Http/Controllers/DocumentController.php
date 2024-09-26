<?php

namespace App\Http\Controllers;

use App\Document;
use App\Opportunity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\GoogleApi;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use PhpParser\Comment\Doc;

class DocumentController extends Controller
{
    use GoogleApi;

    public function quickstart(){
        //EJEMPLO PRIMERO
        return view('documents.quickstart' );
    }

    public function testQuotation(){
        $company_name = strtoupper("Inoloop Sac");
        $contact_name = "Heser Harold Leon Reyes";
        $document_date_formatted = Carbon::parse(now())->format('d/m/Y');
        $ruc = "20601828414";


        //INITIALIZE GOOGLE VARIABLES
        $client = $this->getClient();
        $driveService = $this->getGoogleServiceDrive($client);
        $docsService = $this->getGoogleServiceDocs($client);
        $sheetsService = $this->getGoogleServiceSheets($client);
        $slidesService = $this->getGoogleServiceSlides($client);

        //VARIABLES
        $documentId = Document::QUOTATION_TEMPLATE;
        $copyTitle = "Propuesta de servicios a ".$company_name;
        $documentType = Document::DOCS;
        //VARIABLES

        //PICK THE CORRECT SERVICE: DOCS, SPREADSHEETS OR SLIDES
        $service = $this->getServiceByType($docsService, $sheetsService, $slidesService,  $documentType);
        $documentCopyId = $this->copyFromTemplate($documentId, $copyTitle, $driveService);
        $document  = $this->getDocumentByType($service, $documentCopyId, $documentType);

        $requests = array();


        $requests[] = $this->replaceTextByType(Document::NOMBRE_COMPLETO_CONTACTO, $contact_name, $documentType);
        $requests[] = $this->replaceTextByType(Document::FECHA, $document_date_formatted, $documentType);
        $requests[] = $this->replaceTextByType(Document::EMPRESA, $company_name, $documentType);
        $requests[] = $this->replaceTextByType(Document::RUC, $ruc, $documentType);

        for($i=1; $i<5; $i++){
            $replace_service_title = "Servicio ".$i;
            $replace_service_description = "skldjfdsklfjasdñlfkjalskdjf aksdjf ñlaksdjf alksdj da s\n";
            $replace_service_description.=("\n".Document::SERVICIO."\n".Document::DESCRIPCION);


            $requests[] = $this->replaceTextByType(Document::SERVICIO, $replace_service_title, $documentType);
            $requests[] = $this->replaceTextByType(Document::DESCRIPCION, $replace_service_description, $documentType);
        }

        $requests[] = $this->replaceTextByType(Document::SERVICIO, "", $documentType);
        $requests[] = $this->replaceTextByType(Document::DESCRIPCION, "", $documentType);


        $responseFromUpdate =  $this->updateDocumentByType($requests, $documentCopyId, $service, $documentType);

        dd($responseFromUpdate);

        //$opportunity->fill(['quotation'=>$documentCopyId])->save();

        return view('documents.quickstart' );
    }

    public function createOpportunityDocument(Opportunity $opportunity, $type, $documentType){
        //POLICIES
        $canCreateDocument= true;
        //END POLICIES

        if(! $canCreateDocument){
            return back()->with('modalMessage',['Aviso', __("Su rol no le permite crear documentos.")]);
        }

        //INITIALIZE GOOGLE VARIABLES
        $client = $this->getClient();
        $driveService = $this->getGoogleServiceDrive($client);
        $docsService = $this->getGoogleServiceDocs($client);
        $sheetsService = $this->getGoogleServiceSheets($client);
        $slidesService = $this->getGoogleServiceSlides($client);

        //DOCUMENT TEMPLATE
        $document_template = $this->getDocumentTemplate($type);
        $document_title = $this->getDocumentTitle($opportunity, $type);

        //VARIABLES
        $documentId = $document_template;
        $copyTitle = $document_title;
        //VARIABLES

        //PICK THE CORRECT SERVICE: DOCS, SPREADSHEETS OR SLIDES
        $service = $this->getServiceByType($docsService, $sheetsService, $slidesService,  $documentType);
        $documentCopyId = $this->copyFromTemplate($documentId, $copyTitle, $driveService);
        $document  = $this->getDocumentByType($service, $documentCopyId, $documentType);

        //REQUESTS
        $requests = $this->requestsDocument( $opportunity, $documentType);

        $responseFromUpdate =  $this->updateDocumentByType($requests, $documentCopyId, $service, $documentType);

        $message = "";
        if ($type == Document::QUOTATION){
            $opportunity->fill(['quotation'=>$documentCopyId])->save();
            $message = "Se generó la cotización.";
        }elseif($type == Document::CONTRACT){
            $opportunity->fill(['contract'=>$documentCopyId])->save();
            $message = "Se generó el contrato.";
        }elseif($type == Document::WORK_ORDER){
            $opportunity->fill(['work_order'=>$documentCopyId])->save();
            $message = "Se generó la orden de trabajo.";
        }

        //dd($responseFromUpdate);

        return back()->with('modalMessage',['Aviso', $message]);
    }
    public function editDocument(Opportunity $opportunity, $type, $documentType){
        //POLICIES
        $canEditDocument= true;
        //END POLICIES

        if(! $canEditDocument){
            return back()->with('modalMessage',['Aviso', __("Su rol no le permite editar documentos.")]);
        }

        $document_google_url="";
        if ($documentType == Document::DOCS){
            $document_google_url = Document::DOCS_GOOGLE_URL;
        }elseif($documentType == Document::SHEETS){
            $document_google_url = Document::SHEETS_GOOGLE_URL;
        }elseif($documentType == Document::SLIDES){
            $document_google_url = Document::SLIDES_GOOGLE_URL;;
        }

        //DOCUMENT ID
        $document_id = $this->getDocumentId($opportunity, $type);

        $document_edit_url = "https://docs.google.com/".$document_google_url."/d/".$document_id."/edit";

        return Redirect::to($document_edit_url);
    }
    public function downloadDocument(Opportunity $opportunity, $type){
        //POLICIES
        $canDownloadDocument= true;
        //END POLICIES

        if(! $canDownloadDocument){
            return back()->with('modalMessage',['Aviso', __("Su rol no le permite editar documentos.")]);
        }

        //DOCUMENT ID
        $document_id = $this->getDocumentId($opportunity, $type);
        //DOCUMENT TITLE
        $document_title = $this->getDocumentTitle($opportunity, $type);
        //GOOGLE TRAIT METHODS
        $client = $this->getClient();
        $driveService = $this->getGoogleServiceDrive($client);

        //DESCARGAMOS EL DOCUMENTO
        $responseD = $this->downloadDocumentFromDrive($document_id, $driveService, $document_title);

        return $responseD;
    }


    public function getDocumentId(Opportunity $opportunity, $type){
        //DOCUMENT ID
        $document_id = "";
        if ($type == Document::QUOTATION){
            $document_id = $opportunity->quotation;
        }elseif($type == Document::CONTRACT){
            $document_id = $opportunity->contract;
        }elseif($type == Document::WORK_ORDER){
            $document_id = $opportunity->work_order;
        }
        return $document_id;
    }

    public function getDocumentTemplate($type){
        //DOCUMENT TEMPLATE
        $document_template = "";
        if ($type == Document::QUOTATION){
            $document_template = Document::QUOTATION_TEMPLATE;
        }elseif($type == Document::CONTRACT){
            $document_template = Document::CONTRACT_TEMPLATE;
        }elseif($type == Document::WORK_ORDER){
            $document_template = Document::WORK_ORDER_TEMPLATE;
        }
        return $document_template;
    }
    public function getDocumentTitle(Opportunity $opportunity, $type){
        //DOCUMENT ID
        $document_title = "";
        if ($type == Document::QUOTATION){
            $document_title = "Propuesta de servicios a ".$opportunity->company->company_name;
        }elseif($type == Document::CONTRACT){
            $document_title = "Contrato de servicios a ".$opportunity->company->company_name;
        }elseif($type == Document::WORK_ORDER){
            $document_title = "Orden de trabajo servicio cotización ".$opportunity->code;
        }
        return $document_title;
    }
    public function requestsDocument(Opportunity $opportunity, $documentType){
        $requests = array();

        //OPPORTUNITY
        $opportunity_id = $opportunity->id;
        $opportunity_name = $opportunity->name;
        $opportunity_code = $opportunity->code;
        $service_price = $opportunity->getRawOriginal('service_price');
        $igv = $service_price*0.18;
        $service_price_igv = $service_price * 1.18;

        $service_price_formatted = number_format($service_price, 2, ".","'");
        $igv_formatted = number_format($igv, 2, ".","'");
        $service_price_igv_formatted = number_format($service_price_igv, 2, ".","'");

        //COMPANY
        $company = $opportunity->company;
        $company_name = strtoupper($company->company_name);
        $ruc = $company->tax_number;
        $address = $company->address;
        $manager_name = $company->manager_name." ".$company->manager_last_name;
        $manager_dni = $company->manager_dni;

        $abbreviation = "";
        $words = explode(" ", $company_name);
        foreach ($words as $w) {
            $abbreviation .= $w[0];
        }
        //USER PROPIETARY
        $userOwner = $opportunity->userOwner;
        $user_owner_name = $userOwner->name." ".$userOwner->last_name;
        $abbreviation_user_owner = "";
        $words_user_owner = explode(" ", $user_owner_name);
        foreach ($words_user_owner as $wuo) {
            $abbreviation_user_owner .= $wuo[0];
        }
        //ORDER CODE
        $opportunity_order_code = "OT-".strtoupper($abbreviation_user_owner)."-".$opportunity_id;

        //CONTACT
        $contact_name = $opportunity->companyContact->name." ".$opportunity->companyContact->last_name;
        $contact_email = $opportunity->companyContact->email;

        //DATE
        //setlocale(LC_ALL, 'es_ES');
        $document_date = Carbon::now();

        $document_date_format_1 = Carbon::parse($document_date)->format('d/m/Y');
        $document_date_format_2= $document_date->formatLocalized('Lima, %d de %B del %Y');

        //SERVICES
        $serviceTypes = $opportunity->serviceTypes;

        //OPPORTUNITY
        $requests[] = $this->replaceTextByType(Document::FECHA, $document_date_format_1, $documentType);
        $requests[] = $this->replaceTextByType(Document::FECHA_FORMATO, $document_date_format_2, $documentType);
        $requests[] = $this->replaceTextByType(Document::OPORTUNIDAD, $opportunity_name, $documentType);
        $requests[] = $this->replaceTextByType(Document::PRECIO, $service_price_formatted, $documentType);
        $requests[] = $this->replaceTextByType(Document::IGV, $igv_formatted, $documentType);
        $requests[] = $this->replaceTextByType(Document::PRECIO_IGV, $service_price_igv_formatted, $documentType);
        $requests[] = $this->replaceTextByType(Document::CODIGO_COTIZACION, $opportunity_code, $documentType);
        $requests[] = $this->replaceTextByType(Document::CODIGO_ORDEN_TRABAJO, $opportunity_order_code, $documentType);
        //COMPANY
        $requests[] = $this->replaceTextByType(Document::EMPRESA, $company_name, $documentType);
        $requests[] = $this->replaceTextByType(Document::PRIMERA_LETRA_EMPRESA, $abbreviation, $documentType);
        $requests[] = $this->replaceTextByType(Document::DIRECCION, $address, $documentType);
        $requests[] = $this->replaceTextByType(Document::RUC, $ruc, $documentType);
        $requests[] = $this->replaceTextByType(Document::GERENTE, $manager_name, $documentType);
        $requests[] = $this->replaceTextByType(Document::DNI_GERENTE, $manager_dni, $documentType);
        //CONTACT
        $requests[] = $this->replaceTextByType(Document::NOMBRE_COMPLETO_CONTACTO, $contact_name, $documentType);
        $requests[] = $this->replaceTextByType(Document::CORREO_CONTACTO, $contact_email, $documentType);
        //USER OWNER
        $requests[] = $this->replaceTextByType(Document::USUARIO_PROPIETARIO, $user_owner_name, $documentType);

        $services_total = "";
        $temp = 0;
        foreach($serviceTypes as $serviceType){
            $replace_service_title = "Servicio ".$serviceType->name;
            $replace_service_description = "$serviceType->description"."\n";
            $replace_service_description.=("\n".Document::SERVICIO."\n".Document::DESCRIPCION);

            $requests[] = $this->replaceTextByType(Document::SERVICIO, $replace_service_title, $documentType);
            $requests[] = $this->replaceTextByType(Document::DESCRIPCION, $replace_service_description, $documentType);

            //TOTAL SERVICE
            if($temp > 0){
                $services_total.= (", Servicio ".$serviceType->name);
            }else{
                $services_total.= ("Servicio ".$serviceType->name);
            }
            $temp++;
        }
        $requests[] = $this->replaceTextByType(Document::SERVICIO_TOTAL, $services_total, $documentType);

        $requests[] = $this->replaceTextByType(Document::SERVICIO, "", $documentType);
        $requests[] = $this->replaceTextByType(Document::DESCRIPCION, "", $documentType);



        return $requests;
    }


}
