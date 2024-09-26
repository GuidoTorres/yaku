<?php

namespace App\Http\Controllers;

use App\Http\Requests\PointNoteRequest;
use App\PointNote;
use Illuminate\Http\Request;

class PointNoteController extends Controller
{
    public function listNotes($point_id){
        $notes = PointNote::with([])
            ->where('sampling_point_id',$point_id)
            ->orderBy('id', 'desc')
            ->paginate(12);

        //dd($vouchers);
        return view('pointNotes.list', compact('notes', 'point_id'));
    }

    public function modalSeeForm(Request $request){

        $point_id = (int) $request->has('point_id') ? $request->input('point_id'): null;

        return self::listNotes($point_id);
    }

    public function create($accounting_id){
        $note = new PointNote();

        $btnText = __("Agregar nota");
        return view('partials.accountings.modalCompanyBook', compact('note','btnText'));
    }

    public function store(PointNoteRequest $pointNoteRequest){

        try {
            $pointNoteRequest->merge(['user_id' => auth()->user()->id ]);

            if($pointNoteRequest->has('url')){


                $file = $pointNoteRequest->file('url');

                $fileName = random_int(0,10000)."-".time().'.'.$file->extension();

                $file->move(public_path('notes'), $fileName);

                $pointNoteRequest->merge(['url' => $fileName ]);
            }


            PointNote::create($pointNoteRequest->input());
            return back()->with('modalMessage',['Aviso',
                __("Se agregó la nota.")]);
        } catch(\Illuminate\Database\QueryException $e){
            return back()->with('message',['danger',
                __("Hubo un error agregando la nota, 
                por favor verifique que está colocando los datos requeridos.")]);

        }

    }

    public function edit($id){

        $note = PointNote::with([])
            ->where('id',$id)
            ->orderBy('id', 'desc')
            ->first();

        $canUpdateNote= true;
        //dd($companyRequest->all());
        if(! $canUpdateNote){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite actualizar esta nota.")]);
        }
        $btnText = __("Actualizar");

        //dd($vouchers);
        return view('pointNotes.editNotes', compact('note','btnText'));
    }
    public function update(Request $request, $id){

        $canUpdateNote= true;
        //dd($companyRequest->all());
        if(! $canUpdateNote){
            return redirect('/')->with('modalMessage',['Aviso', __("Su rol no le permite actualizar esta nota.")]);
        }


        try {
            $note = PointNote::with([])
                ->where('id',$id)
                ->orderBy('id', 'desc')
                ->first();

            $file = $request->file('url');
            $description = $request->input('description');

            if($file){
                $file = $request->file('url');
                $fileName = random_int(0,10000)."-".time().'.'.$file->extension();
                $file->move(public_path('notes'), $fileName);

                $note->update([
                   "description"=>  $description,
                   "url"=>  $fileName,
                ]);
            }else{
                $note->update([
                    "description"=>  $description,
                ]);
            }

            return back()->with('modalMessage',['Aviso',
                __("Se actualizó la nota.")]);
        } catch(\Illuminate\Database\QueryException $e){
            return back()->with('message',['danger',
                __("Hubo un error actualizando la nota, 
                por favor verifique que está colocando los datos requeridos.")]);

        }

    }
}
