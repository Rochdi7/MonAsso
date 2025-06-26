<ul class="pc-navbar">

  {{-- Dashboard for all roles --}}
  @can('view dashboard')
    <li class="pc-item">
    <a href="{{ route('dashboard') }}" class="pc-link">
      <span class="pc-micon"><i class="ph-duotone ph-gauge"></i></span>
      <span class="pc-mtext" data-i18n="Dashboard">Dashboard</span>
    </a>
    </li>
  @endcan

  {{-- Statistics --}}
  @can('view statistics')
    <li class="pc-item">
    <a href="{{ route('statistics') }}" class="pc-link">
      <span class="pc-micon"><i class="ph-duotone ph-chart-bar"></i></span>
      <span class="pc-mtext" data-i18n="Statistics">Statistics</span>
    </a>
    </li>
  @endcan


  {{-- Roles Management --}}
  @can('manage roles')
    <li class="pc-item">
    <a href="{{ route('admin.roles.index') }}" class="pc-link">
      <span class="pc-micon"><i class="ph-duotone ph-shield-star"></i></span>
      <span class="pc-mtext" data-i18n="Roles">Manage Roles</span>
    </a>
    </li>
  @endcan

  {{-- Permissions --}}
  @can('manage permissions')
    <li class="pc-item">
    <a href="{{ route('admin.permissions.index') }}" class="pc-link">
      <span class="pc-micon"><i class="ph-duotone ph-keyhole"></i></span>
      <span class="pc-mtext" data-i18n="Permissions">Manage Permissions</span>
    </a>
    </li>
  @endcan

  {{-- Associations --}}
  @can('manage associations')
    <li class="pc-item">
    <a href="{{ route('admin.associations.index') }}" class="pc-link">
      <span class="pc-micon"><i class="ph-duotone ph-users-three"></i></span>
      <span class="pc-mtext" data-i18n="Associations">Manage Associations</span>
    </a>
    </li>
  @endcan

  {{-- Membres (Admin, Board, Supervisor have 'view members') --}}
  @can('view members')
    <li class="pc-item">
    <a href="{{ route('admin.membres.index') }}" class="pc-link">
      <span class="pc-micon"><i class="ph-duotone ph-user-circle"></i></span>
      <span class="pc-mtext" data-i18n="Membres">Manage Membres</span>
    </a>
    </li>
  @endcan

  {{-- Meetings (Admin, Board, Supervisor, Member have 'view meetings') --}}
  @can('view meetings')
    <li class="pc-item">
    <a href="{{ route('admin.meetings.index') }}" class="pc-link">
      <span class="pc-micon"><i class="ph-duotone ph-calendar-blank"></i></span>
      <span class="pc-mtext" data-i18n="Meetings">Manage Meetings</span>
    </a>
    </li>
  @endcan

  {{-- Events (All roles that need access have 'view events') --}}
  @can('view events')
    <li class="pc-item">
    <a href="{{ auth()->user()->hasRole('member') ? route('membre.events.index') : route('admin.events.index') }}"
      class="pc-link">
      <span class="pc-micon"><i class="ph-duotone ph-calendar-check"></i></span>
      <span class="pc-mtext">
      @role('member') Events @else Manage Events @endrole
      </span>
    </a>
    </li>
  @endcan

  {{-- Cotisations --}}
  {{-- Members view their own cotisations via a specific route --}}
  @can('view cotisations')
    @role('member')
    <li class="pc-item">
    <a href="{{ route('membre.cotisations.index') }}" class="pc-link">
      <span class="pc-micon"><i class="ph-duotone ph-receipt"></i></span>
      <span class="pc-mtext" data-i18n="My Cotisations">My Cotisations</span>
    </a>
    </li>
    @endrole

    {{-- Admin, Superadmin, Board manage cotisations via their route --}}
    @hasanyrole('admin|superadmin|board')
    <li class="pc-item">
    <a href="{{ route('admin.cotisations.index') }}" class="pc-link">
      <span class="pc-micon"><i class="ph-duotone ph-receipt"></i></span>
      <span class="pc-mtext" data-i18n="Cotisations">Manage Cotisations</span>
    </a>
    </li>
    @endhasanyrole
  @endcan


  {{-- Contributions (Admin, Superadmin, Board have 'view contributions') --}}
  @can('view contributions')
    <li class="pc-item">
    <a href="{{ route('admin.contributions.index') }}" class="pc-link">
      <span class="pc-micon"><i class="ph-duotone ph-hand-heart"></i></span>
      <span class="pc-mtext" data-i18n="Contributions">Manage Contributions</span>
    </a>
    </li>
  @endcan

  {{-- Expenses (Admin, Superadmin, Board have 'view expenses') --}}
  @can('view expenses')
    <li class="pc-item">
    <a href="{{ route('admin.expenses.index') }}" class="pc-link">
      <span class="pc-micon"><i class="ph-duotone ph-currency-circle-dollar"></i></span>
      <span class="pc-mtext" data-i18n="Expenses">Manage Expenses</span>
    </a>
    </li>
  @endcan

</ul>