<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Añadido 26/09/22
use App\Http\Controllers\Controller;
use App\Trainer;
use PDF;

class TrainerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //añadido el 27-09-22
        $trainers=Trainer::all();
        return view ('cards',compact('trainers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    return view("cards");//
    }
    public function store(Request $request)
    {
        /* return $request->all(); #Regresa todo los datos como el token y el nombre
        return $request->input('name'); #Regresa el nombre que se tecleó en el campo */

        /* Comentarizado el 27-09-22
        $trainer = new Trainer();
        $trainer->name=$request->input('id');
        $trainer->name=$request->input('name');
        $trainer->save();
        return 'Guardado'; */

        /* Comentarizado el 28-09-22 
        return $request->all(); */

        //Obtiene la imagen
        if ($request->hasFile('avatar')){
            $file= $request->file('avatar');
            $name=time().$file-> getClientOriginalName();
            $file->move(public_path().'/images/',$name);

            //Datos del formulario
            $trainer = new Trainer();
            $trainer->name=$request->input('name');
            $trainer->Apellidos=$request->input('Apellidos');

            //Imagen
            $trainer->avatar=$name;
            $trainer->save();
            return 'Guardado con éxito';
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Trainer $trainer)
    {
        /*Añadido el 03/10/22
        return 'tengo que regresar el id'; 
        return view("show"); */

        /*Añadido el 04/10/22
        $trainer = Trainer::find($id);*/
        //return $trainer;
        return view('show', compact('trainer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Trainer $trainer)
    {
        //Añadido el 04/10/22
        return view('edit', compact('trainer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trainer $trainer)
    {
        //Añadido el 04/10/22
        $trainer->fill($request->except('avatar'));
        if ($request->hasFile('avatar')){
            $file= $request->file('avatar');
            $name=time().$file-> getClientOriginalName();

        //Imagen
        $trainer->avatar=$name;
        $file->move(public_path(  ).'/images',$name);
        }   
        $trainer->save();
        return redirect('trainers/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
            
        //Añadido el 28-09-22
        $data = Trainer::FindOrFail($id);
        $trainer= Trainer::find($id);

        if(file_exists('images/'.$data->Avatar) AND !empty($data->Avatar)){
            unlink('images/'.$data->Avatar);
        }
        try{
            $data->delete();
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }
        if($bug==0){
            echo "success";
        } else {
            echo 'error';
        }

        if ($trainer->delete($id)){
            //return 'El'.$id. "Si se pudo borrar";
            return redirect('trainers/');
        }
            else {return 'El'.$id. "No se pudo borrar";}

       
    }

    public function pdf()
    {
        $trainers=Trainer::all();
        //$pdf = PDF::loadView('pdf.listado', ['Data' => $Data])->setOptions(['defaultFont' => 'sans-serif']);
        $pdf = PDF::loadView('pdf.listado',compact('trainers'));
        return $pdf->download('listado.pdf');
    }
    
}
