<?php

namespace App\Http\Controllers;

use App\Deep;
use App\gPoint;
use App\Http\Requests\AlertNotificationRequest;
use App\Http\Requests\ParametersCSVRequest;
use App\Http\Requests\SamplingRequest;
use App\Mail\NuevaMuestra;
use App\Parameter;
use App\Sampling;
use App\SamplingParameter;
use App\SamplingPoint;
use App\User;
use App\Zone;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;

class SamplingController extends Controller
{
    public function listPoint(SamplingPoint $samplingPoint){
        //POLICIES
        $canListThisCompanyContacts = true;
        if(! $canListThisCompanyContacts){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite ver los contactos de esta empresa.")]);
        }
        //END POLICIES

        $samplings = $samplingPoint->samplings()->orderBy("sampling_date", 'DESC')->paginate(12);
        //dd($samplings);

        return view('samplings.listPoint', compact('samplings', 'samplingPoint'));
    }


    public function create($id){

        $sampling = new Sampling();

        $samplingPoint = SamplingPoint::where('id',$id)->first();

        //POLICIES
        $canCreateSampling = true;

        if(! $canCreateSampling ){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite agregar muestreos.")]);
        }
        //END POLICIES

        $zones = Zone::orderBy('id', 'desc')->get();
        $deeps = Deep::orderBy('id', 'desc')->get();

        $btnText = __("Crear muestreo");

        return view('samplings.createSampling', compact('sampling','btnText', 'samplingPoint', 'zones', 'deeps'));
    }

    public function store(SamplingRequest $samplingRequest){


        //POLICIES
        $canCreateSampling = true;
        //END POLICIES
        if(! $canCreateSampling ){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite agregar muestreos.")]);
        }
        //END POLICIES


        //INTENTAMOS CREAR LA ELECCIÓN, AÑADIENDO EL ID DEL USUARIO QUE CREÓ
        $north = $samplingRequest->north;
        $east = $samplingRequest->east;
        $utmZone = $samplingRequest->utm_zone;

        $gPoint = new gPoint("WGS 84");
        $gPoint->setUTM($east, $north, $utmZone);
        $gPoint->convertTMtoLL();

        $latitude = $gPoint->Lat();
        $longitude = $gPoint->Long();


        //$sampling_date_search = Carbon::createFromFormat('d/m/Y',$sampling_date_search)->format('Y-m-d');
        $sampling_date = $samplingRequest->sampling_date;
        $sampling_date = Carbon::createFromFormat('d/m/Y H:i',$sampling_date)->format('Y-m-d H:i');

        try {
            $samplingRequest->merge([
                'sampling_date' => $sampling_date,
                'user_created_id' => auth()->user()->id,
                'state' => Sampling::FOR_APPROVAL,
                'latitude' => $latitude,
                'longitude' => $longitude
            ]);

            $sampling = Sampling::create($samplingRequest->input());
        } catch(\Illuminate\Database\QueryException $e){
            dd($e->getMessage());
            return back()->with('message',['danger',
                __("Hubo un error agregando el muestreo,
                por favor verifique que está colocando los datos requeridos, luego inténtelo de nuevo.")]);
        }

        /*
        UserActivityLog::create([
            'user_id' => auth()->user()->id,
            'action_id' => Action::ELECTION_ADDED,
            'description' => 'El usuario '.auth()->user()->name.' añadió la elección.',
            'model_modified' => 'Election',
            'model_id' => $election->id,
        ]);*/

        return redirect()->route('samplings.createParameters', $sampling->id);


    }

    public function edit($id){

        $sampling = Sampling::with([])
            ->where('id',$id)
            ->orderBy('id', 'desc')
            ->first();

        $canUpdateSampling= true;
        //dd($companyRequest->all());
        if(! $canUpdateSampling){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite actualizar este muestreo.")]);
        }

        $samplingPoint = $sampling->samplingPoint->first();
        $zones = Zone::orderBy('id', 'desc')->get();
        $deeps = Deep::orderBy('id', 'desc')->get();

        $btnText = __("Crear muestreo");

        //dd($vouchers);
        return view('samplings.createSampling', compact('sampling','btnText', 'samplingPoint', 'zones', 'deeps'));
    }


    public function update(SamplingRequest $samplingRequest, Sampling $sampling){


        //POLICIES
        $canUpdateSampling= true;
        //dd($companyRequest->all());
        if(! $canUpdateSampling){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite actualizar este muestreo.")]);
        }
        //END POLICIES


        //INTENTAMOS CREAR LA ELECCIÓN, AÑADIENDO EL ID DEL USUARIO QUE CREÓ
        $north = $samplingRequest->north;
        $east = $samplingRequest->east;
        $utmZone = $samplingRequest->utm_zone;

        $gPoint = new gPoint("WGS 84");
        $gPoint->setUTM($east, $north, $utmZone);
        $gPoint->convertTMtoLL();

        $latitude = $gPoint->Lat();
        $longitude = $gPoint->Long();

        $sampling_date = $samplingRequest->sampling_date;
        $sampling_date = Carbon::createFromFormat('d/m/Y H:i',$sampling_date)->format('Y-m-d H:i');

        try {
            $samplingRequest->merge([
                'sampling_date' => $sampling_date,
                'user_created_id' => auth()->user()->id,
                'state' => Sampling::FOR_APPROVAL,
                'latitude' => $latitude,
                'longitude' => $longitude
            ]);

            $sampling->fill($samplingRequest->input())->save();
        } catch(\Illuminate\Database\QueryException $e){
            //dd($e->getMessage());
            return back()->with('message',['danger',
                __("Hubo un error agregando el muestreo,
                por favor verifique que está colocando los datos requeridos, luego inténtelo de nuevo.")]);
        }

        /*
        UserActivityLog::create([
            'user_id' => auth()->user()->id,
            'action_id' => Action::ELECTION_ADDED,
            'description' => 'El usuario '.auth()->user()->name.' añadió la elección.',
            'model_modified' => 'Election',
            'model_id' => $election->id,
        ]);*/

        return redirect()->route('samplings.listPoint', $sampling->samplingPoint->id)->with('modalMessage',['Aviso', __("Se actualizó el muestreo correctamente.")]);


    }

    public function filter(Request $request){
        //POLICIES
        $canListAllSamplings = true;
        //END POLICIES
        if(! ($canListAllSamplings) ){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite ver muestreos.")]);
        }
        $samplings = new Sampling();

        $sampling_point_id_search = $request->has('sampling_point_id_search') ? $request->input('sampling_point_id_search'): null;
        $sampling_date_search = $request->has('sampling_date_search') ? $request->input('sampling_date_search'): null;
        $deep_id_search = $request->has('deep_id_search') ? $request->input('deep_id_search'): null;

        // Search for a user based on their name.
        if ($sampling_point_id_search) {
            $samplings = $samplings->where('sampling_point_id',$sampling_point_id_search);
            $samplingPoint = SamplingPoint::where('id', $sampling_point_id_search)->first();
        }else{
            return redirect('/')->with('modalMessage',['Aviso', __("Ocurrió un error. Inténtelo de nuevo.")]);
        }
        // Search for a user based on their name.
        //dd($sampling_date_search);
        if ($sampling_date_search) {
            $sampling_date_search = Carbon::createFromFormat('d/m/Y',$sampling_date_search)->format('Y-m-d');
            $samplings = $samplings->whereDate('sampling_date', $sampling_date_search);
        }
        // Search for a user based on their name.
        if ($deep_id_search) {
            $samplings = $samplings->where('deep_id',$deep_id_search);
        }

        $samplings = $samplings->orderBy("sampling_date",'DESC')->paginate(12);

        //dd($vouchers);
        return view('samplings.listPoint', compact('samplings', 'samplingPoint') );
    }

    public function createParameters($id){

        $sampling = Sampling::where('id',$id)->first();
        //dd($sampling);

        //POLICIES
        $canCreateSampling = true;

        if(! $canCreateSampling ){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite agregar muestreos.")]);
        }
        //END POLICIES

        $btnText = __("Agregar datos de muestreo");

        return view('samplings.addSamplingParameters', compact('sampling','btnText'));
    }

    public function storeParameters(ParametersCSVRequest $samplingRequest, $sampling_id){
        //POLICIES
        $canCreateSampling = true;
        //END POLICIES
        if(! $canCreateSampling ){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite agregar muestreos.")]);
        }
        //END POLICIES


        //INTENTAMOS CREAR LA ELECCIÓN, AÑADIENDO EL ID DEL USUARIO QUE CREÓ


        try {
            if(!$samplingRequest->hasFile('parameters_list')){
                return back()->with('modalMessage',['Aviso',"Por favor seleccione al menos un archivo."]);
            }

            $file = $samplingRequest->file('parameters_list');
            // Get uploaded CSV file

            $document_number_arr = array();
            $data = array();

            $fileOriginalName = $file->getClientOriginalName();
            $data_current_row = 0;

            $getParametersCodeArray = Parameter::pluck('id', 'code')->toArray();
            $getParametersDataTypeArray = Parameter::pluck('data_type', 'id')->toArray();

            //dd($getParametersDataTypeArray);

            //ARRAY TO RETRIEVE ALL THE IDS FROM DNI
            //SO THEN INSERT INTO PIVOT ELECTOR ELECTION

            $header = null;

            $delimiter = $this->getFileDelimiter($file);

            //dd($delimiter);

            if (($csvFile = fopen($file, 'r')) !== false){
                //SKIP THE FIRST LINE
                $parameters = fgetcsv($csvFile,0,$delimiter);
                //dd($parameters);
                $now = Carbon::now('utc')->toDateTimeString();

                $line_number = 1;
                while(($line = fgetcsv($csvFile,0,$delimiter)) !== FALSE) {

                    $temp = 0;
                    $row_parameter_values = [];
                    $data = [];

                    foreach ($parameters as $parameter) {
                        $parameter_value = $line[$temp];
                        //dd($getParametersCodeArray);
                        $parameter_id = $getParametersCodeArray[$parameter];

                        if($parameter_value || is_numeric($parameter_value)){
                            $data_type = $getParametersDataTypeArray[$parameter_id];


                            $check = $this->validateCsvDataInput($data_type, $parameter_value);

                            if($check == 2){
                                $msg= "Error al ingresar el dato '".$parameter_value."' en el campo '".$parameter."' en la fila ".$line_number.".";
                                return back()->with('modalMessage',['Aviso', $msg]);
                            }
                            $row_parameter_values[$parameter_id] = $parameter_value."-".$data_type."-".$check;
                            $data[]=
                            [
                                'value'=>$parameter_value,
                                'sampling_id'=>$sampling_id,
                                'parameter_id'=>$parameter_id,
                                'created_at'=>$now,
                                'updated_at'=>$now,
                            ];


                        }

                        $temp++;
                    }
                    //dd($data);

                    //INSERTANDO LA FILA EN LA TABLA DE MUESTRAS POR PARÁMETRO
                    //SamplingParameter::insert($data);

                    $line_number++;
                }
                //INSERTANDO LA FILA EN LA TABLA DE MUESTRAS POR PARÁMETRO
                //SE HACE ACÁ (SÓLO UNA LÍNEA, LA ÚLTIMA) PARA NO INSERTAR MÚLTIPLES VALORES EN UNA MUESTRA POR PARÁMETRO
                SamplingParameter::insert($data);

            }




/*
            UserActivityLog::create([
                'user_id' => auth()->user()->id,
                'action_id' => Action::GROUP_ADDED,
                'description' => 'El usuario '.auth()->user()->name.' añadió el grupo de electores.',
                'model_modified' => 'Group',
                'model_id' => $group->id,
            ]);*/


            $user = auth()->user();
            $sampling = Sampling::where('id', $sampling_id)->first();
            $samplingPoint = Sampling::where('id', $sampling_id)->first()->samplingPoint;

            //Mail::to($user)->send(new NuevaMuestra($samplingPoint, $sampling, $user));

            $msg = "Muestra añadida con éxito";

            return redirect()->route('samplings.listSampling', $sampling)->with('modalMessage',['Aviso', $msg]);

        } catch(\Illuminate\Database\QueryException $e){
            $message= "Ocurrió un error al ingresar los datos, por favor verifique que los datos de la tabla son correctos. Código de error: ";

            $samplingPoint = Sampling::where('id', $sampling_id)->first()->samplingPoint->id;
            return redirect()->route('samplings.listPoint', $samplingPoint);
            //return redirect()->route('samplings.listPoint', $samplingPoint)->with('modalMessage',['Aviso', $message.$e->getCode()]);
        }


    }


    public function approve($id){


        //POLICIES
        $canApproveSampling = true;
        //END POLICIES
        if(! $canApproveSampling ){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite agregar muestreos.")]);
        }
        //END POLICIES

        $sampling = Sampling::where('id', $id)->first();
        $sampling->update([
            'state'=> Sampling::APPROVED
        ]);

        return back()->with('modalMessage',['Aviso', __("Se aprobó el muestreo.")]);

    }


    public function listSampling(Sampling $sampling){
        //POLICIES
        $canListThisSampling = true;
        if(! $canListThisSampling){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite ver este muestreo.")]);
        }
        //END POLICIES

        $reservoir = $sampling->samplingPoint->reservoir;
        $samplingParameters = $sampling->samplingParameters()->with('parameter.unit')->orderBy("id", 'DESC')->paginate(25);
        $samplingPoint = $sampling->samplingPoint()->first();

        $parametersVerified = $this->getParametersVerified($sampling);

        $alert = $parametersVerified["alert"];
        $alert2 = $parametersVerified["alert2"];
        $parameters_eca2_verified = $parametersVerified["parameters_eca2_verified"];
        $parametersVerified = $parametersVerified["parameters_verified"];

        $users = User::whereIn('role_id', [1,2,3,4])->get();

        return view('samplings.listSampling', compact('samplingPoint','sampling', 'samplingParameters', 'reservoir', 'parametersVerified', 'parameters_eca2_verified', 'alert', 'alert2', 'users'));
    }

    public function alertNotification(AlertNotificationRequest $alertNotificationRequest,Sampling $sampling){
        //POLICIES
        $canSendNotification = true;
        if(! $canSendNotification){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite enviar notificaciones.")]);
        }
        //END POLICIES

        $samplingParameters = $sampling->samplingParameters()->with('parameter.unit')->orderBy("id", 'DESC')->get();
        $samplingPoint = $sampling->samplingPoint()->first();

        $parametersVerified = $this->getParametersVerified($sampling);

        $alert = $parametersVerified["alert"];
        $alert2 = $parametersVerified["alert2"];
        $parameters_eca2_verified = $parametersVerified["parameters_eca2_verified"];
        $parametersVerified = $parametersVerified["parameters_verified"];

        $reservoir_name = $alertNotificationRequest->input('reservoir_name');
        $users_ids = $alertNotificationRequest->input('users');
        $note = $alertNotificationRequest->input('note');
        $sampling_point = $alertNotificationRequest->input('sampling_point');
        $dominant = $alertNotificationRequest->input('dominant');
        $cursiva_dominant = $alertNotificationRequest->input('cursiva_dominant');
        $transition = $alertNotificationRequest->input('transition');
        $color_alert = $alertNotificationRequest->input('color_alert');
        $parameters_to_send = $alertNotificationRequest->input('parameters');
        $showTransition = false;

        if($dominant && $cursiva_dominant == 'true'){
            $dominant = '<i>'.$dominant.'</i>';
        }
        if($transition == 'true'){
            $showTransition = true;
        }


        $users = User::whereIn('id', $users_ids)->get();

        $userSent = auth()->user();


        $parametersVerifiedToSend = [];
        $alert = Sampling::GREEN_ALERT;
        foreach ($parametersVerified as $index => $parameterVerified) {
            if(in_array($parameterVerified->parameter_id, $parameters_to_send)){
                $parametersVerifiedToSend[$index] = $parameterVerified;
                $parameterOnYellowAlert = $parameterVerified->state == Sampling::NEAR_BELLOW_LIMIT || $parameterVerified->state == Sampling::NEAR_UPPER_LIMIT;
                $parameterOnRedAlert = $parameterVerified->state == Sampling::BELLOW_LIMIT || $parameterVerified->state == Sampling::UPPER_LIMIT || $parameterVerified->state == Sampling::DIFFERENT_THAN_ALLOWED;

                if($alert == Sampling::GREEN_ALERT){
                    if($parameterOnYellowAlert){
                        $alert = Sampling::YELLOW_ALERT;
                    }
                    if($parameterOnRedAlert){
                        $alert = Sampling::RED_ALERT;
                    }
                }elseif ($alert == Sampling::YELLOW_ALERT){
                    if($parameterOnRedAlert){
                        $alert = Sampling::RED_ALERT;
                    }
                }
            }
        }
        $alertName = "Verde";
        if($alert == Sampling::GREEN_ALERT){
            $alertName = "Verde";
        }elseif($alert == Sampling::YELLOW_ALERT){
            $alertName = "Amarilla";
        }elseif($alert == Sampling::RED_ALERT){
            $alertName = "Roja";
        }
        $parametersTransitionVerifiedToSend = [];
        foreach ($parameters_eca2_verified as $index =>  $parameter_eca2_verified) {
            if(in_array($parameter_eca2_verified->parameter_id, $parameters_to_send)){

                $parametersTransitionVerifiedToSend[$index] = $parameter_eca2_verified;
            }
        }
        //dd($alertNotificationRequest->parameters);

        foreach ($users as $user){
            Mail::to($user)->send(new NuevaMuestra($samplingPoint, $sampling, $user, $userSent, $reservoir_name, $note,$sampling_point,$dominant,$color_alert, $alert, $alertName, $parametersVerifiedToSend, $parametersTransitionVerifiedToSend, $showTransition));
        }

        return redirect()->route('samplings.listSampling', $sampling)->with('modalMessage',['Aviso', __("Se enviaron las notificaciones.")]);
    }


    public function delete(Sampling $sampling){

        $canDeleteSampling= true;
        //dd($companyRequest->all());
        if(! $canDeleteSampling){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite eliminar este muestreo.")]);
        }

        try {
            $sampling->delete();
        } catch(\Illuminate\Database\QueryException $e){

            $msg = "Hubo un error eliminando el muestreo. Error: ".$e->getMessage();
            //dd($e->getMessage());
            return back()->with('modalMessage',['Aviso', $msg]);
        }

        return back()->with('modalMessage',['Aviso', __("Se eliminó el punto de muestreo correctamente.")]);
    }

    function getParametersVerified(Sampling $sampling){

        $samplingParameters = $sampling->samplingParameters()->with('parameter.unit')->orderBy("id", 'DESC')->get();
        $samplingPoint = $sampling->samplingPoint()->first();

        //VERIFICATION
        //GETTING THE ECA PARAMETERS OF SAMPLING POINT AS ARRAY WHERE INDEX IS THE PARAMETER ID
        $ecaParameters = $samplingPoint->eca->ecaParameters()->get(['min_value','max_value','near_min_value','near_max_value','allowed_value', 'parameter_id'])->keyBy('parameter_id')->toArray();
        $ecaTransitionParameters = $samplingPoint->transitionEca;
        $ecasTransitionDescriptions = [
            "alert" => Sampling::GREEN_ALERT,
            "samplingParametersLimited" => [],
        ];
        if($ecaTransitionParameters){
            $ecaTransitionParameters = $ecaTransitionParameters->ecaParameters()->get(['min_value','max_value','near_min_value','near_max_value','allowed_value', 'parameter_id'])->keyBy('parameter_id')->toArray();
            $ecasTransitionDescriptions = $this->getEcasDescription($samplingParameters, $ecaTransitionParameters);
        }

        $samplingParametersLimited = [];

        //VERIFICATION
        $ecasDescriptions = $this->getEcasDescription($samplingParameters, $ecaParameters);
        //dd($samplingParametersLimited);

        $verified = [
            "alert" => $ecasDescriptions['alert'],
            "alert2" => $ecasTransitionDescriptions['alert'],
            "parameters_verified" => $ecasDescriptions['samplingParametersLimited'],
            "parameters_eca2_verified" => $ecasTransitionDescriptions['samplingParametersLimited'],
        ];
        return $verified;
    }
    public function getEcasDescription($samplingParameters, $ecaParameters){
        $alert = Sampling::GREEN_ALERT;

        foreach ($samplingParameters as $samplingParameter) {

            //SAMPLING PARAMETER INFO
            $sp_ID = $samplingParameter->id;
            $sp_PARAMETER_ID = $samplingParameter->parameter_id;
            $sp_VALUE = $samplingParameter->value;
            //PARAMETER INFOas
            $sp_parameter_name = $samplingParameter->parameter->name;
            $sp_parameter_symbol = $samplingParameter->parameter->unit->symbol ?? null;

            //ECA INFO
            $ecaParameter = $ecaParameters[$sp_PARAMETER_ID] ?? null;
            $ep_MIN = $ecaParameter["min_value"] ?? null;
            $ep_MAX = $ecaParameter["max_value"] ?? null;
            $ep_near_MIN = $ecaParameter["near_min_value"] ?? null;
            $ep_near_MAX = $ecaParameter["near_max_value"] ?? null;
            $ep_ALLOWED = $ecaParameter["allowed_value"] ?? null;


            //SETTING ANALIZING VARIABLES
            $mesage = "Normal";
            $state = Sampling::NORMAL_PARAMETER;
            $eca_type = Sampling::ECA_NULL;

            //SI EL ECA PERMITE SÓLO UN VALOR
            if( !is_null($ep_ALLOWED) ){
                $eca_type = Sampling::ECA_ALLOWED;
                if ($sp_VALUE == $ep_ALLOWED){
                    $state = Sampling::NORMAL_PARAMETER;
                    $mesage = "El valor ".$sp_VALUE." cumple con el estándar permitido.";

                }else{
                    $state = Sampling::DIFFERENT_THAN_ALLOWED;
                    $mesage = "El valor ".$sp_VALUE." no cumple con el estándar permitido de ".$ep_ALLOWED.".";
                    $alert = Sampling::RED_ALERT;

                }

                //SI EL ECA TIENE VALOR MÍNIMO O MÁXIMO
            }elseif( !is_null($ep_MIN) || !is_null($ep_MAX) ) {

                //SI EL ECA TIENE MÍNIMO Y MÁXIMO
                if(!is_null($ep_MIN) && !is_null($ep_MAX)){
                    $eca_type = Sampling::ECA_MIN_MAX;

                    $eca_near_min = $ep_near_MIN ?? (1 + Sampling::ECA_YELLOW_THRESHOLD)*$ep_MIN;
                    $eca_near_max = $ep_near_MAX ?? (1 - Sampling::ECA_YELLOW_THRESHOLD)*$ep_MAX;

                    //SI EL VALOR ESTA DENTRO DE LOS UMBRALES DE MAXIMOS Y MINIMOS
                    if ( ($sp_VALUE >= $eca_near_min ) && ($sp_VALUE <= $eca_near_max ) ){
                        $state = Sampling::NORMAL_PARAMETER;
                        $mesage = "El valor ".$sp_VALUE." cumple con el estándar permitido.";

                        //SI EL VALOR ESTADE BAJO DEL UMBRAL MINIMO
                    }elseif($sp_VALUE < $eca_near_min ){
                        //SI EL VALOR ESTA DENTRO DEL UMBRAL
                        if($sp_VALUE >= $ep_MIN){
                            $state = Sampling::NEAR_BELLOW_LIMIT;
                            $mesage = "El valor ".$sp_VALUE." esta cercano al estándar permitido de ".$ep_MIN.".";

                            if($alert <= Sampling::YELLOW_ALERT){
                                $alert =  Sampling::YELLOW_ALERT;
                            }

                            //SI EL VALOR ESTA DEBAJO DEL MINIMO
                        }else{
                            $state = Sampling::BELLOW_LIMIT;
                            $mesage = "El valor ".$sp_VALUE." mo cumple con el estándar permitido de '".$ep_MIN."'.";
                            $alert = Sampling::RED_ALERT;
                        }

                        //SI EL VALOR ESTA ENCIMA DEL UMBRAL MAXIMO
                    }elseif($sp_VALUE > $eca_near_max ){
                        //SI EL VALOR ESTA DENTRO DEL UMBRAL
                        if($sp_VALUE <= $ep_MAX){
                            $state = Sampling::NEAR_UPPER_LIMIT;
                            $mesage = "El valor ".$sp_VALUE." esta cercano al estándar permitido de ".$ep_MAX.".";

                            if($alert <= Sampling::YELLOW_ALERT){
                                $alert =  Sampling::YELLOW_ALERT;
                            }

                            //SI EL VALOR ESTA ENCIMA DEL MAXIMO
                        }else{
                            $state = Sampling::UPPER_LIMIT;
                            $mesage = "El valor ".$sp_VALUE." no cumple con el estándar permitido de ".$ep_MAX.".";
                            $alert = Sampling::RED_ALERT;

                        }
                    }




                    //SI EL ECA TIENE MÍNIMO
                }elseif(!is_null($ep_MIN)){
                    $eca_type = Sampling::ECA_MIN;

                    $eca_near_min = $ep_near_MIN ?? (1 + Sampling::ECA_YELLOW_THRESHOLD)*$ep_MIN;

                    if ($sp_VALUE >= $eca_near_min){
                        $state = Sampling::NORMAL_PARAMETER;
                        $mesage = "El valor ".$sp_VALUE." cumple con el estándar permitido.";

                    }elseif($sp_VALUE >= $ep_MIN){
                        $state = Sampling::NEAR_BELLOW_LIMIT;
                        $mesage = "El valor ".$sp_VALUE." esta cercano al estándar permitido de ".$ep_MIN.".";

                        if($alert <= Sampling::YELLOW_ALERT){
                            $alert =  Sampling::YELLOW_ALERT;
                        }

                    }else{
                        $state = Sampling::BELLOW_LIMIT;
                        $mesage = "El valor ".$sp_VALUE." está por debajo del valor mínimo permitido ".$ep_MIN.".";
                        $alert = Sampling::RED_ALERT;

                    }

                    //SI EL ECA TIENE MÁXIMO
                }elseif(!is_null($ep_MAX)){
                    $eca_type = Sampling::ECA_MAX;

                    $eca_near_max = $ep_near_MAX ?? (1 - Sampling::ECA_YELLOW_THRESHOLD)*$ep_MAX;

                    if ($sp_VALUE <= $eca_near_max){
                        $state = Sampling::NORMAL_PARAMETER;
                        $mesage = "El valor ".$sp_VALUE." cumple con el estándar permitido.";

                    }elseif($sp_VALUE <= $ep_MAX){
                        $state = Sampling::NEAR_UPPER_LIMIT;
                        $mesage = "El valor ".$sp_VALUE." esta cercano al estándar permitido de ".$ep_MAX.".";

                        if($alert <= Sampling::YELLOW_ALERT){
                            $alert =  Sampling::YELLOW_ALERT;
                        }

                    }else{
                        $state = Sampling::UPPER_LIMIT;
                        $mesage = "El valor ".$sp_VALUE." no cumple con el estándar permitido de ".$ep_MAX.".";
                        $alert = Sampling::RED_ALERT;

                    }
                }

                //SI NO TIENE ECA
            }else{
                $eca_type = Sampling::ECA_NULL;
            }

            $parameterVerifiedObj = new \stdClass();

            $parameterVerifiedObj->id =  $sp_ID;
            $parameterVerifiedObj->parameter_id =  $sp_PARAMETER_ID;
            $parameterVerifiedObj->parameter_name =  $sp_parameter_name;
            $parameterVerifiedObj->parameter_symbol =  $sp_parameter_symbol;
            $parameterVerifiedObj->value =  $sp_VALUE;
            $parameterVerifiedObj->min_value =  $ep_MIN;
            $parameterVerifiedObj->max_value =  $ep_MAX;
            $parameterVerifiedObj->allowed_value =  $ep_ALLOWED;
            $parameterVerifiedObj->message =  $mesage;
            $parameterVerifiedObj->state =  $state;
            $parameterVerifiedObj->eca_type =  $eca_type;

            $samplingParametersLimited[$sp_ID] = $parameterVerifiedObj;
        }

        return [
            'samplingParametersLimited' => $samplingParametersLimited,
            'alert' => $alert
        ];
    }

    function getFileDelimiter($file, $checkLines = 2){
        $file = new \SplFileObject($file);
        $delimiters = array(
            ',',
            '\t',
            ';',
            '|',
            ':'
        );
        $results = array();
        $i = 0;
        while($file->valid() && $i <= $checkLines){
            $line = $file->fgets();
            foreach ($delimiters as $delimiter){
                $regExp = '/['.$delimiter.']/';
                $fields = preg_split($regExp, $line);
                if(count($fields) > 1){
                    if(!empty($results[$delimiter])){
                        $results[$delimiter]++;
                    } else {
                        $results[$delimiter] = 1;
                    }
                }
            }
            $i++;
        }
        $results = array_keys($results, max($results));
        return $results[0];
    }
    function getFileDelimiterFromStoredCSV($file, $checkLines = 2){
        $file = new \SplFileObject($file);
        $delimiters = array(
            ',',
            '\t',
            ';',
            '|',
            ':'
        );
        $results = array();
        $i = 0;
        while($file->valid() && $i <= $checkLines){
            $line = $file->fgets();
            foreach ($delimiters as $delimiter){
                $regExp = '/['.$delimiter.']/';
                $fields = preg_split($regExp, $line);
                if(count($fields) > 1){
                    if(!empty($results[$delimiter])){
                        $results[$delimiter]++;
                    } else {
                        $results[$delimiter] = 1;
                    }
                }
            }
            $i++;
        }
        $results = array_keys($results, max($results));
        return $results[0];
    }

    public function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
    }

    public function addCsvRowToArray($line, $now){
        $fathers_last_name  = isset($line[0]) ? utf8_encode($line[0]) : null;
        $mothers_last_name  = isset($line[1]) ? utf8_encode($line[1]) : null;
        $name               = isset($line[2]) ? utf8_encode($line[2]) : null;
        $document_number    = isset($line[3]) ? utf8_encode($line[3]) : null;
        $mail               = isset($line[4]) ? utf8_encode($line[4]) : null;
        $country_code       = isset($line[6]) ? utf8_encode($line[6]) : null;
        $cellphone          = isset($line[7]) ? utf8_encode($line[7]) : null;

        $row_elector = [
            "name" => $name,
            "fathers_last_name" => $fathers_last_name,
            "mothers_last_name" => $mothers_last_name,
            "email" => $mail,
            "document_number" => $document_number,
            "country_code" => $country_code,
            "cellphone" => $cellphone,
            'created_at'=> $now,
            'updated_at'=> $now
        ];

        return $row_elector;
    }

    public function validateCsvDataInput($data_type, $value){

        $validate = 2;

        if($data_type == Parameter::POSITIVE_INTEGER){
            if ((is_int($value) || ctype_digit($value)) && (int)$value >= 0 ) {
                $validate = 1;
            }
        }elseif($data_type == Parameter::NEGATIVE_INTEGER){
            if (filter_var($value, FILTER_VALIDATE_INT) || (is_numeric($value) && $value == 0) ) {
                if((int)$value <= 0){
                    $validate = 1;
                }
            }
        }elseif($data_type == Parameter::INTEGER){
            if (filter_var($value, FILTER_VALIDATE_INT) || (is_numeric($value) && $value == 0) ) {
                $validate = 1;
            }
        }elseif($data_type == Parameter::POSITIVE_FLOAT){
            if ( (filter_var($value, FILTER_VALIDATE_FLOAT) && $value >= 0) || (is_numeric($value) && $value == 0) ) {
                $validate = 1;
            }
        }elseif($data_type == Parameter::NEGATIVE_FLOAT){
            if ( (filter_var($value, FILTER_VALIDATE_FLOAT) && $value <= 0) || (is_numeric($value) && $value == 0) ) {
                $validate = 1;
            }
        }elseif($data_type == Parameter::FLOAT){
            if ( filter_var($value, FILTER_VALIDATE_FLOAT) || (is_numeric($value) && $value == 0) ) {
                $validate = 1;
            }
        }elseif($data_type == Parameter::STRING){
            $validate = 1;
        }elseif($data_type == Parameter::BOOLEAN){
            if (  (is_numeric($value) && $value == 0) ||
                (is_numeric($value) && $value == 1)   ||
                is_bool($value) ||
                $value == "true" ||
                $value == "false"
            ) {
                $validate = 1;
            }
        }elseif($data_type == Parameter::ZERO_TO_ONE_DECIMAL){
            if ( (filter_var($value, FILTER_VALIDATE_FLOAT) && $value >= 0  && $value <= 1) || (is_numeric($value) && $value == 0)  ) {
                $validate = 1;
            }
        }

        return $validate;
    }

    public function updateSampling(Request $request,$samplingId ){

        $sp = SamplingParameter::where('id', $samplingId)->first()->update([
            "value"=>$request->input('value')
        ]);
        return back()->with('modalMessage',['Aviso', __("Se actualizó la muestra.")]);
    }


    public function deleteSampling($samplingId ){

        $sp = SamplingParameter::where('id', $samplingId)->first()->delete();
        return back()->with('modalMessage',['Aviso', __("Se eliminó la muestra.")]);
    }
    public function addSampling(Request $request,$samplingId ){

        SamplingParameter::create([
            "sampling_id" => $samplingId,
            "value" => $request->input('value'),
            "parameter_id" => $request->input('parameter_id')
        ]);
        return back()->with('modalMessage',['Aviso', __("Se agregó la muestra.")]);
    }

}
