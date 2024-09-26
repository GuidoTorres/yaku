<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Option;
use App\Question;
use App\Survey;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function store(QuestionRequest $questionRequest){
        //POLICIES
        $canCreateQuestion = true;
        //POLICIES
        if(! $canCreateQuestion ){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite agregar preguntas.")]);
        }
        //END POLICIES

        $survey_id = $questionRequest->input('survey_id');
        $survey = Survey::where('id', $survey_id)->first();

        $count = $survey->questions->count();
        $new_order = (++$count);

        try {
            $questionRequest->merge([
                'order' => $new_order,
                'order_updated_at' => now(),
            ]);
            $question = Question::create($questionRequest->input());
        } catch(\Illuminate\Database\QueryException $e){
            return back()->with('message',['danger',
                __("Hubo un error agregando la pregunta,
                por favor verifique que está colocando los datos requeridos, luego inténtelo de nuevo.")]);
        }

        try {
            $question_id = $question->id;
            for ($i=1; $i<=\App\Survey::QUESTIONS;$i++){
                Option::create([
                    'type' => $i,
                    'question_id' => $question_id,
                ]);
            }
        } catch(\Illuminate\Database\QueryException $e){
            $question->delete();
            return back()->with('message',['danger',
                __("Hubo un error agregando la pregunta,
                por favor verifique que está colocando los datos requeridos, luego inténtelo de nuevo.")]);
        }



        return redirect()->route('surveys.addQuestions', $survey->id);

    }
}
