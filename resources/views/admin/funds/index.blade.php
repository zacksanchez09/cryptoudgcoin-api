@extends('admin.styles')

@section('content')

  <ol class="breadcrumb">
    <li class="breadcrumb-item">Inicio</li>
    <li class="breadcrumb-item active">Fondeos</li>
  </ol>

  @include('flash::message')

  <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <h4 class="card-title mb-0">Todos los Fondeos</h4>
                  </div>
                  <div class="col-md-6" align="right">
                  </div>
                  <div class="col-md-12">
                    <br>
                    <table id="table-funds" class="display">
                        <thead>
                            <tr align="center">
                                <th>ID</th>
                                <th>ID Transacción</th>
                                <th>Usuario</th>
                                <th>Cantidad</th>
                                <th>Método</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($funds as $fund)
                            <tr align="center">
                                <td>{{ $fund->id }}</td>
                                <td>{{ $fund->transaction_id }}</td>
                                <td>{{ $fund->user }}</td>
                                <td>${{ $fund->amount }}</td>
                                @if($fund->type == 'credit')
                                  <td>Tarjeta de Crédito/Débito</td>
                                @elseif($fund->type == 'oxxo')
                                  <td>OxxoPay</td>
                                @endif
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
        $('#table-funds').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
             },
             "responsive": true,
             "bSort": false
        });
    @else
       $('#table-funds').DataTable({
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
