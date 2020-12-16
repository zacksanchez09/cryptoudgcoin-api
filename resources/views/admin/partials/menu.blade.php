    <div class="sidebar">
        <nav class="sidebar-nav">
          <ul class="nav">
            <li class="nav-title">Menu</li>
            @if(Auth::user()->hasRole('admin'))
            <li class="nav-item">
              <a  href="{{ URL('/admin') }}" class="nav-link">
                <i class="nav-icon icon-speedometer"></i> Dashboard
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ URL('admin/users') }}" class="nav-link">
                <i class="nav-icon icon-people"></i> Usuarios
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ URL('admin/transactions') }}" class="nav-link">
                <i class="nav-icon icon-book-open"></i> Transacciones
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ URL('admin/wallets') }}" class="nav-link">
                <i class="nav-icon icon-wallet"></i> Carteras
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ URL('admin/funds') }}" class="nav-link">
                <i class="nav-icon fa fa-money"></i> Fondeos
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ URL('admin/faqs') }}" class="nav-link">
                <i class="nav-icon icon-question"></i> FAQs
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ URL('admin/charts') }}" class="nav-link">
                <i class="nav-icon icon-pie-chart"></i> Gráficos
              </a>
            </li>
            @else
            @php
              $user = Auth::user();
            @endphp
            <li class="nav-item">
              <a href="{{ route('admin.user_transactions', $user->id) }}" class="nav-link">
                <i class="nav-icon icon-doc"></i> Mis Transacciones
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('admin.users.edit', $user->id) }}" class="nav-link">
                <i class="nav-icon icon-lock"></i> Cambiar Contraseña
              </a>
            </li>
            @endif
          </ul>
        </nav>
      </div>
