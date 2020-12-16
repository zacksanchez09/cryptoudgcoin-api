@extends('admin.styles')

@section('content')

  <ol class="breadcrumb">
    <li class="breadcrumb-item">Inicio</li>
    <li class="breadcrumb-item active">Carteras</li>
  </ol>

  @include('flash::message')

  <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <h4 class="card-title mb-0">Todas las Carteras</h4>
                  </div>
                  <div class="col-md-6" align="right">
                  </div>
                  <div class="col-md-12">
                    <br>
                    <table id="table-wallets" class="display">
                        <thead>
                            <tr align="center">
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Nombre</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($wallets as $wallet)
                            <tr align="center">
                                <td>{{ $wallet->id }}</td>
                                <td>{{ $wallet->user }}</td>
                                @if($wallet->name == 'MXN')
                                  <td>Peso mexicano</td>
                                @elseif($wallet->name == 'UDGC')
                                  <td>CryptoUDGCoin</td>
                                @endif
                                <td>${{ $wallet->balance }}</td>
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
        $('#table-wallets').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
             },
             "responsive": true,
             "bSort": false
        });
    @else
       $('#table-wallets').DataTable({
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
