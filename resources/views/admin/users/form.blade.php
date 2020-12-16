<div class="container-fluid">
  <div class="animated fadeIn">
  <div class="row">
    <div class="col-md-2" align="center"></div>
    <div class="col-md-8" align="center">
      <div class="card">
        <div class="card-header">
          @if(Auth::user()->hasRole('admin'))

          <strong>{{ $user->name }} {{ $user->last_name }}</strong> </div>
            <div class="card-body">

            <div class="form-group row">
              <label class="col-md-5 col-form-label" for="name">Nombre</label>
              <div class="col-md-5">
                <input class="form-control" id="name" type="text" value="{{ $method == 'EDIT' ? $user->name : '' }}" name="name" placeholder="Nombre" required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-5 col-form-label" for="last_name">Apellidos</label>
              <div class="col-md-5">
                <input class="form-control" id="last_name" type="last_name" value="{{ $method == 'EDIT' ? $user->last_name : '' }}" name="last_name" placeholder="Apellidos" required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-5 col-form-label" for="email">Correo electrónico</label>
              <div class="col-md-5">
                <input class="form-control" id="email" type="email" value="{{ $method == 'EDIT' ? $user->email : '' }}" name="email" placeholder="Correo electrónico" required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-5 col-form-label" for="udg_code">Código UDG</label>
              <div class="col-md-5">
                <input class="form-control" id="udg_code" type="udg_code" value="{{ $method == 'EDIT' ? $user->udg_code : '' }}" name="udg_code" placeholder="Código UDG" required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-5 col-form-label" for="career">Carrera</label>
              <div class="col-md-5">
                <input class="form-control" id="career" type="career" value="{{ $method == 'EDIT' ? $user->career : '' }}" name="career" placeholder="Carrera" required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-5 col-form-label" for="phone">Teléfono</label>
              <div class="col-md-5">
                <input class="form-control" id="phone" type="phone" value="{{ $method == 'EDIT' ? $user->phone : '' }}" name="phone" placeholder="Teléfono" required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-5 col-form-label" for="password">Password</label>
              <div class="col-md-5">
                <input class="form-control" id="password" type="password" value="{{ $method == 'EDIT' ? $user->password : '' }}" name="password" placeholder="Name" required>
              </div>
            </div>

          @else

           <strong>Cambiar Contraseña</strong> </div>
            <div class="card-body">

            <div class="form-group row">
              <label class="col-md-5 col-form-label" for="password">Nueva Contraseña</label>
              <div class="col-md-5">
                <input class="form-control" id="password" type="password" name="password" required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-5 col-form-label" for="password">Repetir Contraseña</label>
              <div class="col-md-5">
                <input class="form-control" id="password" type="password" name="c_password" required>
              </div>
            </div>

          @endif
        </div>
      </div>
      </div>
    </div>
  </div>
</div>
