@extends('layouts.app')

@section('content')
<div class="container">

@if(Session::has('mensaje'))
<div class="alert alert-success alert-dismissible" role="alert">
    {{Session::get('mensaje')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<a href="{{ url('empleado/create') }}" class='btn btn-success'>Registrar Nuevo Empleado</a><br><br>

<table class="table table-light">
    
    <thead class="thead-light">
        <tr>
            <th>#</th>
            <th>Foto</th>
            <th>Nombre</th>
            <th>Apellido Paterno</th>
            <th>Apellido Materno</th>
            <th>Correo</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
        @foreach($empleados as $empleado)
        <tr>
            <td>{{$empleado->id}}</td>

            <th>
                <img src="{{ asset('storage'.'/'.$empleado->Foto) }}" width="100" alt="" class="img-thumbnail img-fluid"></th>

            <th>{{$empleado->Nombre}}</th>
            <th>{{$empleado->ApellidoPaterno}}</th>
            <th>{{$empleado->ApellidoMaterno}}</th>
            <th>{{$empleado->Correo}}</th>
            <th>
                <a href="{{ url('/empleado/'.$empleado->id.'/edit') }}" class="btn btn-warning">
                    EDITAR
                </a>
                |
            <form action="{{ url('/empleado/'.$empleado->id) }}" class="d-inline" method="post">
                @csrf
                {{method_field('DELETE')}}
                <input type="submit" onclick="return confirm('¿Quieres Borrar?')" value="Borrar" class="btn btn-danger">
            </form>
            </th>
        </tr>
        @endforeach
    </tbody>

</table>
{!! $empleados->links() !!}
</div>
@endsection