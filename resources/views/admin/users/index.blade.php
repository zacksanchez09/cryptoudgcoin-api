@extends('admin.styles')

@section('content')

  <ol class="breadcrumb">
    <li class="breadcrumb-item">Inicio</li>
    <li class="breadcrumb-item active">Usuarios</li>
  </ol>

  @include('flash::message')

  <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <h4 class="card-title mb-0">Todos los Usuarios</h4>
                  </div>
                  <div class="col-md-6" align="right">
                  </div>
                  <div class="col-md-12">
                    <br>
                    <table id="table-users" class="display">
                        <thead>
                            <tr align="center">
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Correo electrónico</th>
                                <th>Código UDG</th>
                                <th>Carrera</th>
                                <th>Teléfono</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($users as $user)
                            <tr align="center">
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }} {{ $user->last_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->udg_code }}</td>
                                <td>{{ $user->career }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>
                                <ul class="list-inline" style="margin: 0px;">
                                  <li class="list-inline-item">
                                    <a class="btn btn-success btn-sm" href="{{ route('admin.users.edit', $user->id) }}" title="{{ trans('Editar Usuario') }}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i>
                                    </a>
                                  </li>
                                  <li class="list-inline-item">
                                    <a class="btn btn-info btn-sm" href="{{ route('admin.user_transactions', $user->id) }}" title="{{ trans('Ver Transacciones') }}">
                                      <i style="color: #fff;" class="fa fa-eye"></i>
                                    </a>
                                  </li>
                                </ul>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
@push('script')

<script>
   @if(App::isLocale('es'))
        $('#table-users').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
             },
             "responsive": true,
             "bSort": false
        });
    @else
       $('#table-users').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/English.json"
             },
             "responsive": true,
             "bSort": false
       });
    @endif
</script>

@endpush

@endsection
