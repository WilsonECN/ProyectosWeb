<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $datos['empleados']=Empleado::paginate(2);
        return view('empleado.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('empleado.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //recolectar todos los datos del form
        // $datosEmpleado= request()->all();
    
        //comprobacion de datos

        $campos=[
            'Nombre'=>'required|string|max:100',
            'ApellidoPaterno'=>'required|string|max:100',
            'ApellidoMaterno'=>'required|string|max:100',
            'Correo'=>'required|email',
            'Foto'=>'required|max:1000|mimes:jpeg,png,jpg'
        ];
        $mensaje = [
            'required'=>'El :attribute es requerido',
            'Foto.required' => 'La foto es requerida'
        ];

        $this->validate($request, $campos, $mensaje);

        //comprobacion de datos FIN

        $datosEmpleado= request()->except('_token');
        if($request->hasFile('Foto')){
            $datosEmpleado['Foto']=$request->file('Foto')->store('uploads', 'public');
        }

        Empleado::insert($datosEmpleado);


        // return response()->json($datosEmpleado); //esto enviava a una página solo imprimiendo el json de los datos del form 

        return redirect('empleado')->with('mensaje', 'Empleado agregado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $empleado = Empleado::findOrFail($id);

        return view('empleado.edit', compact('empleado'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $campos=[
            'Nombre'=>'required|string|max:100',
            'ApellidoPaterno'=>'required|string|max:100',
            'ApellidoMaterno'=>'required|string|max:100',
            'Correo'=>'required|email',
        ];
        $mensaje = [
            'required'=>'El :attribute es requerido',
            'Foto.required' => 'La foto es requerida'
        ];

        //validacion por si el usuario decide no cambiar la foto o deja el campo vacio y por si cambia la foto la valida
        //en este punto el campo de la foto siempre va a seguir siendo el mismo por lo que si el usuario no cambia la foto
        //no debe de validarse el campo como el $campos de arriba
        //si el usuario decide cambiar su foto se valida con el $campos de aca abajo
        if($request->hasFile('Foto')){
            $campos=['Foto'=>'required|max:1000|mimes:jpeg,png,jpg',];
            $mensaje = ['Foto.required' => 'La foto es requerida'];
        }



        $this->validate($request, $campos, $mensaje);

        $datosEmpleado= request()->except('_token', '_method');

        if($request->hasFile('Foto')){
            $empleado = Empleado::findOrFail($id);
            Storage::delete('public/'.$empleado->Foto); //elimina la foto de la ruta local si es que se edita la foto
            $datosEmpleado['Foto']=$request->file('Foto')->store('uploads', 'public');
        }

        Empleado::where('id', '=',$id)->update($datosEmpleado);

        $empleado = Empleado::findOrFail($id);
        // return view('empleado.edit', compact('empleado'));
        return redirect('empleado')->with('mensaje', 'Empleado Modificado');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        $empleado = Empleado::findOrFail($id);
        if(Storage::delete('public/'.$empleado->Foto)){
            
            Empleado::destroy($id);
        }

        return redirect('empleado')->with('mensaje', 'Empleado eliminado');
    }
}
