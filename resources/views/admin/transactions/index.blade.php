@extends('admin.styles')

@section('content')

  <ol class="breadcrumb">
    <li class="breadcrumb-item">Inicio</li>
    <li class="breadcrumb-item active">Transacciones</li>
  </ol>

  @include('flash::message')

  <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    @if(Auth::user()->hasRole('admin'))
                      <h4 class="card-title mb-0">Todas las Transacciones</h4>
                    @else
                      <h4 class="card-title mb-0">Todas mis Transacciones</h4>
                    @endif
                  </div>
                  <div class="col-md-6" align="right">
                  </div>
                  <div class="col-md-12">
                    <br>
                    <table id="table-transactions" class="display">
                        <thead>
                            <tr align="center">
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Cartera</th>
                                <th>Concepto</th>
                                <th>Cantidad</th>
                                <th>Fecha Operación</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($transactions as $transaction)
                            <tr align="center">
                                <td>{{ $transaction->id }}</td>
                                <td>{{ $transaction->user }}</td>
                                @if($transaction->wallet->name == 'MXN')
                                  <td>Peso mexicano</td>
                                @elseif($transaction->wallet->name == 'UDGC')
                                  <td>CryptoUDGCoin</td>
                                @endif
                                @if($transaction->concept == NULL)
                                  <td>No hay concepto</td>
                                @else
                                  <td>{{ $transaction->concept }}</td>
                                @endif
                                <td>${{ $transaction->amount }}</td>
                                <td>{{ $transaction->created_at }}</td>
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
        $('#table-transactions').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
             },
             "responsive": true,
             "bSort": false
        });
    @else
       $('#table-transactions').DataTable({
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
