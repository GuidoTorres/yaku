<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Http\Requests\SurveyRequest;
use App\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class SurveyController extends Controller
{

    public function listAll(){
        //POLICIES
        $canListAllSurveys = true;
        //END POLICIES

        if(! $canListAllSurveys){
            return back()->with('modalMessage',['Aviso', __("Su rol no le permite ver las encuestas.")]);
        }

        $surveys = Survey::with([]);

        $surveys = $surveys->orderBy('id', 'desc')->paginate(12);

        return view('surveys.listAll', compact('surveys'));
    }

    public function create(){
        $survey = new Survey();

        //POLICIES
        $canCreateElection = true;
        //POLICIES

        if(! $canCreateElection ){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite agregar encuestas.")]);
        }

        $btnText = __("Crear encuesta");

        return view('surveys.create', compact('survey','btnText'));
    }


    public function store(SurveyRequest $surveyRequest){
        //POLICIES
        $canCreateElection = true;
        //POLICIES
        if(! $canCreateElection ){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite agregar encuestas.")]);
        }
        //END POLICIES
        try {
            //$surveyRequest->merge(['user_id' => auth()->user()->id ]);
            $survey = Survey::create($surveyRequest->input());
        } catch(\Illuminate\Database\QueryException $e){
            return back()->with('message',['danger',
                __("Hubo un error agregando la elección,
                por favor verifique que está colocando los datos requeridos, luego inténtelo de nuevo.")]);
        }
        return redirect()->route('surveys.addQuestions', $survey->id);

    }

    public function edit($id){

        $survey = Survey::with([
            'questions.options'
        ])
            ->where('id',$id)
            ->orderBy('id', 'desc')
            ->first();

        //POLICIES
        $canCreateElection = true;
        //POLICIES

        if(! $canCreateElection ){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite editar encuestas.")]);
        }

        $btnText = __("Editar encuesta");

        return view('surveys.create', compact('survey','btnText'));
    }


    public function update(SurveyRequest $surveyRequest, $id){

        $survey = Survey::with([
            'questions.options'
        ])
            ->where('id',$id)
            ->orderBy('id', 'desc')
            ->first();

        //POLICIES
        $canCreateElection = true;
        //POLICIES

        if(! $canCreateElection ){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite editar encuestas.")]);
        }
        //END POLICIES
        try {
            $survey->fill($surveyRequest->input())->save();
        } catch(\Illuminate\Database\QueryException $e){
            return back()->with('message',['danger',
                __("Hubo un error editando la encuesta,
                por favor verifique que está colocando los datos requeridos, luego inténtelo de nuevo.")]);
        }
        return redirect()->route('surveys.addQuestions', $survey->id);

    }

    public function addQuestions($id){

        $survey = Survey::with([
            'questions.options'
        ])
            ->where('id',$id)
            ->orderBy('id', 'desc')
            ->first();

        //POLICIES
        $canAddQuestions = true;
        //END POLICIES

        if(! $canAddQuestions ){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite agregar preguntas a esta encuesta.")]);
        }


        return view('surveys.addQuestions', compact('survey'));
    }

    public function filter(Request $request){
        //POLICIES
        $canListAllSurveys = true;
        //END POLICIES
        if(! ($canListAllSurveys) ){
            return back()->with('modalMessage',['Aviso', __("Su rol no le permite ver las encuestas.")]);
        }
        $surveys = new Survey();

        $name_search = $request->has('name_search') ? $request->input('name_search'): null;

        // Search for a user based on their name.
        if ($name_search) {
            $surveys = $surveys->where('name','LIKE', '%'.$name_search.'%');
        }

        $surveys = $surveys->orderBy('created_at','DESC')->paginate(12);

        //dd($vouchers);
        return view('surveys.listAll', compact('surveys') );
    }


    public function results($id){

        $survey = Survey::with([
            'questions' => function ($q){
                $q
                    ->with([
                        'options' => function ($q){
                            $q->select(array('question_id', \DB::raw("SUM(type) as question_sum, COUNT(question_id) as question_count")))->groupBy('question_id');
                        },
                    ])
                    ->orderBy('id', 'desc');
            },
        ])
            ->where('id',$id)
            ->orderBy('id', 'desc')
            ->first();

        //POLICIES
        $canViewSurveyResults = true;
        //END POLICIES

        if(! $canViewSurveyResults ){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite agregar preguntas a esta encuesta.")]);
        }

        //$survey = $survey->toJson();

        //dd($survey);



        return view('surveys.results', compact('survey'));

    }

    public function vote($uid){

        $id = Survey::decryptSurveyId($uid);

        $survey = Survey::with([
            'questions.options'
        ])
            ->where('id',$id)
            ->orderBy('id', 'desc')
            ->first();

        if(!$survey ){
            return redirect('/')->with('modalMessage',['Aviso', __("No se encuentra la encuesta.")]);
        }

        //POLICIES
        $canVote = $survey->state;
        //END POLICIES

        if($canVote == Survey::INACTIVE ){
            return redirect('/')->with('modalMessage',['Aviso', __("La encuesta se encuentra cerrada.")]);
        }




        return view('surveys.vote', compact('survey'));
    }

    public function storeVote(Request $voteRequest){
        //dd($voteRequest);

        $survey_id_encrypted = $voteRequest->input('survey_id');

        //DECRYPT DATA
        $survey_id = Survey::decryptSurveyId($survey_id_encrypted);

        $options = $voteRequest->input('question');

        $survey = Survey::with([
            'questions.options'
        ])
            ->where('id',$survey_id)
            ->orderBy('id', 'desc')
            ->first();

        try {
            //ADD VOTES

            //dd($candidates_verified);
            foreach ($options as $option) {
                if($option>0){
                    Answer::create(['option_id' => $option]);
                }
            };

            return back()->with('modalMessage',['Aviso', __("Gracias por responder la encuesta.")]);
        } catch(\Illuminate\Database\QueryException $e){
            dd($e);
            return back()->with('modalMessage',['Aviso', __("No se pudo agregar su voto. Por favor, inténtelo de nuevo. Error: ".$e->getCode())]);

        }
    }

}
