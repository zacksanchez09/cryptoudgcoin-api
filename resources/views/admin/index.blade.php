@extends('admin.styles')

@section('content')

  <ol class="breadcrumb">
    <li class="breadcrumb-item">Inicio</li>
    <li class="breadcrumb-item active">Dashboard</li>
  </ol>
  <div class="container-fluid">
  <div class="animated fadeIn">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-sm-5">
            <h4 class="card-title mb-0"></h4>
            <div class="small text-muted">
            @php
              $date = Carbon\Carbon::now()->subHours(5);
              $newHour = $date->isMidday();
              $dateFormated = Carbon\Carbon::parse($date)->format('d/m/Y');
              $hour = Carbon\Carbon::parse($date)->format('H:i');
            @endphp
            <h5 style="color:black;">
            Bienvenido, {{ Auth::user()->name }} {{ Auth::user()->last_name }}
            <br>
            <br>
            @php
              $date = Carbon\Carbon::now();
              $newHour = $date->isMidday();
              $dateFormated = Carbon\Carbon::parse($date)->format('d/m/Y');
              $hour = Carbon\Carbon::parse($date)->format('H:i');
            @endphp
            Son las: {{ $hour }}
            <br><br>
            @if($date->dayOfWeekIso == 1)
              Lunes
            @elseif($date->dayOfWeekIso == 2)
              Martes
            @elseif($date->dayOfWeekIso == 3)
              Miércoles
            @elseif($date->dayOfWeekIso == 4)
              Jueves
            @elseif($date->dayOfWeekIso == 5)
              Viernes
            @elseif($date->dayOfWeekIso == 6)
              Sábado
            @elseif($date->dayOfWeekIso == 7)
              Domingo
            @endif
            {{$date->day}} de
            @if($date->month == 1)
              Enero
            @elseif($date->month == 2)
              Febrero
            @elseif($date->month == 3)
              Marzo
            @elseif($date->month == 4)
              Abril
            @elseif($date->month == 5)
              Mayo
            @elseif($date->month == 6)
              Junio
            @elseif($date->month == 7)
              Julio
            @elseif($date->month == 8)
              Agosto
            @elseif($date->month == 9)
              Septiembre
            @elseif($date->month == 10)
              Octubre
            @elseif($date->month == 11)
              Noviembre
            @elseif($date->month == 12)
              Diciembre
            @endif
            de {{$date->year}}.
          </div>
        </div>
      </div>

  <br>
  <!-- Dashboard metrics -->
  <div class="row">

    <div class="col-sm-4 col-lg-4">
      <div class="brand-card">
        <div class="brand-card-header bg-warning">
          <div class="col-md-6" align="center">
            <h3 style="color:#fff;">
              {{ count($users) }}
            </h3>
          </div>
          <div class="col-md-6" align="center">
            <i class="nav-icon icon-people"></i>
          </div>
        </div>
        <div class="brand-card-body">
            <div class="text-muted small">
              <h4>
                Usuarios Totales
              </h4>
            </div>
        </div>
      </div>
    </div>

    <div class="col-sm-4 col-lg-4">
        <div class="brand-card">
          <div class="brand-card-header bg-info">
            <div class="col-md-6" align="center">
              <h3 style="color:#fff;">
                {{ count($wallets) }}
              </h3>
            </div>
            <div class="col-md-6" align="center">
              <i class="nav-icon icon-wallet"></i>
            </div>
          </div>
          <div class="brand-card-body">
              <div class="text-muted small">
                <h4>
                  Carteras Totales
                </h4>
              </div>
          </div>
        </div>
    </div>

    <div class="col-sm-4 col-lg-4">
        <div class="brand-card">
          <div class="brand-card-header bg-facebook">
            <div class="col-md-6" align="center">
              <h3 style="color:#fff;">
                {{ count($transactions) }}
              </h3>
            </div>
            <div class="col-md-6" align="center">
              <i class="nav-icon icon-list"></i>
            </div>
          </div>
          <div class="brand-card-body">
              <div class="text-muted small">
                <h4>
                  Transacciones Totales
                </h4>
              </div>
          </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-6">
        <div class="brand-card">
          <div class="brand-card-header bg-success">
            <div class="col-md-6" align="center">
              <h3 style="color:#fff;">
                ${{ $funds }}
              </h3>
            </div>
            <div class="col-md-6" align="center">
              <i class="nav-icon fa fa-money"></i>
            </div>
          </div>
          <div class="brand-card-body">
              <div class="text-muted small">
                <h4>
                  Total Fondeado
                </h4>
              </div>
          </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-6">
        <div class="brand-card">
          <div class="brand-card-header bg-danger">
            <div class="col-md-6" align="center">
              <h3 style="color:#fff;">
                ${{ $withdraws }}
              </h3>
            </div>
            <div class="col-md-6" align="center">
              <i class="nav-icon fa fa-money"></i>
            </div>
          </div>
          <div class="brand-card-body">
              <div class="text-muted small">
                <h4>
                  Total Retirado
                </h4>
              </div>
            </div>
          </div>
        </div>
      </div>
      </div>
    </div>

  </div>
</div>

@push('script')
<script>

</script>
@endpush

@endsection
