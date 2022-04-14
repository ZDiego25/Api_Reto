<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use Carbon\Carbon;

class CursoController extends Controller{
    

    public function index(){
        $datosCurso = Curso::all();

        return response()->json(["cursos"=>$datosCurso]);
    }

    public function store(Request $request){

        $datosCurso = new Curso;

        $nombreFile = '';

        if($request->hasFile('imagen')){
            $nombreArchivoOrg = $request->file('imagen')->getClientOriginalName();
            $nombreFile = Carbon::now()->timestamp."_".$nombreArchivoOrg;

            $request->file('imagen')->move('./upload/',$nombreFile);
        }

        $datosCurso->titulo = $request->titulo;
        $datosCurso->imagen = $nombreFile;
        $datosCurso->descripcion = $request->descripcion;
        $datosCurso->autor = $request->autor;
        $datosCurso->valoracion = '';

        $datosCurso->save();

        return response()->json("Registro Exitoso");
    }

    public function view($id){
        $datosCurso = new Curso;
        $datosEncontrados = $datosCurso->find($id);
        return response()->json($datosEncontrados);
    }

    public function delete($id){

        $datosCurso = Curso::find($id);
        if($datosCurso){
            $rutaArchivo = base_path('public').'/upload/'.$datosCurso->imagen;
            if(file_exists($rutaArchivo)){
                unlink($rutaArchivo);
            }

            $datosCurso->delete();
        }

        return response()->json("Registro Eliminado");
    }

    public function update(Request $request,$id){

        $curso = Curso::find($id);
        
        $nombreFile = '';
        if($request->hasFile('imagen')){
            //BORRAR VIEDO ANTIGUA
            if($curso){

                $rutaArchivo = base_path('public').'/upload/'.$curso->imagen;
                if(file_exists($rutaArchivo)){
                    unlink($rutaArchivo);
                }
            }

            // GARCAR NUEVO Imagen
            $nombreArchivoOrg = $request->file('imagen')->getClientOriginalName();
            $nombreFile = Carbon::now()->timestamp."_".$nombreArchivoOrg;

            $request->file('imagen')->move('./upload/',$nombreFile);
        }

        $curso->titulo = $request->titulo;
        $curso->imagen = $nombreFile;
        $curso->descripcion = $request->descripcion;
        $curso->autor = $request->autor;
        $curso->valoracion = $request->valoracion;
        $curso->save();

        return response()->json("Datos Actualizados");

    }

}