
<!-- //modo viene de create o edit blade.php  -->
<h1>{{$modo}} Empleado</h1>

@if(count($errors)>0)

    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach($errors->all() as $error)
            <li>
                {{ $error }}
            </li>
            @endforeach
        </ul>
    </div>

@endif

<div class="form-group">

<label for="Nombre">Nombre</label>
<input class="form-control" type="text" value="{{ isset($empleado->Nombre)?$empleado->Nombre:old('Nombre') }}" name="Nombre" id="Nombre">

<label for="ApellidoPaterno">Apellido Paterno</label>
<input class="form-control" type="text" value="{{ isset($empleado->ApellidoPaterno)?$empleado->ApellidoPaterno:old('ApellidoPaterno') }}" name="ApellidoPaterno" id="ApellidoPaterno">

<label for="ApellidoMaterno">Apellido Materno</label>
<input class="form-control" type="text" value="{{ isset($empleado->ApellidoMaterno)?$empleado->ApellidoMaterno:old('ApellidoMaterno') }}" name="ApellidoMaterno" id="ApellidoMaterno">

<label for="Correo">Correo</label>
<input class="form-control" type="text" value="{{ isset($empleado->Correo)?$empleado->Correo:old('Correo') }}" name="Correo" id="Correo">

<label for="Foto"></label>
@if(isset($empleado->Foto))
<img class="img-thumbnail img-fluid" src="{{ asset('storage'.'/'.$empleado->Foto) }}" width="100" alt=""></th>
@endif
<input class="form-control" type="file" value="" name="Foto" id="Foto"><br>

</div>


<input class="btn btn-success" type="submit" value="{{$modo}} Datos"><br><br>

<a class="btn btn-primary" href="{{ url('empleado') }}">Regresar</a>

