@extends('admin.styles')

@section('content')

  <ol class="breadcrumb">
    <li class="breadcrumb-item">Inicio</li>
    <li class="breadcrumb-item"><a href="{{ URL('admin/users') }}">Usuarios</a></li>
    <li class="breadcrumb-item active">Nuevo</li>
  </ol>

    {!! Form::open([
        'action' => ['UsersController@store'],
        'files' => true
      ])
    !!}

    @include('admin.users.form')

    <div class="card-footer" align="right">
      <button class="btn btn-sm btn-success" type="submit">
        <i class="fa fa-dot-circle-o"></i> Guardar</button>
      <button class="btn btn-sm btn-danger" type="reset">
        <i class="fa fa-ban"></i> Limpiar</button>
      <a href="{{ URL::previous() }}" class="btn btn-sm btn-danger">
        <i class="fa fa-ban"></i> Cancelar</a>
    </div>

  {!! Form::close() !!}

@push('script')

<script>
    $('.datepicker').datepicker({
        format: "dd/mm/yyyy",
        language: "es",
        autoclose: true
    });

    $('.js-example-basic-multiple').select2();
</script>
@endpush

@endsection
