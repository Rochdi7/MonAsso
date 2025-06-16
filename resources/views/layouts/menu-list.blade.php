<ul class="pc-navbar">

  {{-- Dashboard for all roles --}}
  @hasanyrole('super_admin|admin|membre')
  <li class="pc-item">
    <a href="{{ route('dashboard') }}" class="pc-link">
      <span class="pc-micon"><i class="ph-duotone ph-gauge"></i></span>
      <span class="pc-mtext" data-i18n="Dashboard">Dashboard</span>
    </a>
  </li>
  @endhasanyrole

  {{-- Statistiques: available for all roles --}}
  @hasanyrole('super_admin|admin|membre')
  <li class="pc-item">
    <a href="{{ route('admin.statistics.index') }}" class="pc-link">
      <span class="pc-micon"><i class="ph-duotone ph-chart-bar"></i></span>
      <span class="pc-mtext" data-i18n="Statistics">Statistics</span>
    </a>
  </li>
  @endhasanyrole

  {{-- Roles Management: super_admin only --}}
  @role('super_admin')
  <li class="pc-item">
    <a href="{{ route('admin.roles.index') }}" class="pc-link">
      <span class="pc-micon"><i class="ph-duotone ph-shield-star"></i></span>
      <span class="pc-mtext" data-i18n="Roles">Manage Roles</span>
    </a>
  </li>
  @endrole

  {{-- Permissions Management: super_admin only --}}
  @role('super_admin')
  <li class="pc-item">
    <a href="{{ route('admin.permissions.index') }}" class="pc-link">
      <span class="pc-micon"><i class="ph-duotone ph-keyhole"></i></span>
      <span class="pc-mtext" data-i18n="Permissions">Manage Permissions</span>
    </a>
  </li>
  @endrole

  {{-- Associations: super_admin only --}}
  @role('super_admin')
  <li class="pc-item">
    <a href="{{ route('admin.associations.index') }}" class="pc-link">
      <span class="pc-micon"><i class="ph-duotone ph-users-three"></i></span>
      <span class="pc-mtext" data-i18n="Associations">Manage Associations</span>
    </a>
  </li>
  @endrole

  {{-- Membres: admin only --}}
  @role('admin')
  <li class="pc-item">
    <a href="{{ route('admin.membres.index') }}" class="pc-link">
      <span class="pc-micon"><i class="ph-duotone ph-user-circle"></i></span>
      <span class="pc-mtext" data-i18n="Membres">Manage Membres</span>
    </a>
  </li>
  @endrole

  {{-- Meetings: admin and super_admin --}}
  @hasanyrole('admin|super_admin')
  <li class="pc-item">
    <a href="{{ route('admin.meetings.index') }}" class="pc-link">
      <span class="pc-micon"><i class="ph-duotone ph-calendar-blank"></i></span>
      <span class="pc-mtext" data-i18n="Meetings">Manage Meetings</span>
    </a>
  </li>
  @endhasanyrole

  {{-- Cotisations: admin and super_admin --}}
  @hasanyrole('admin|super_admin')
  <li class="pc-item">
    <a href="{{ route('admin.cotisations.index') }}" class="pc-link">
      <span class="pc-micon"><i class="ph-duotone ph-currency-circle-dollar"></i></span>
      <span class="pc-mtext" data-i18n="Cotisations">Manage Cotisations</span>
    </a>
  </li>
  @endhasanyrole

  {{-- My Cotisations: for membre --}}
  @role('membre')
  <li class="pc-item">
    <a href="{{ route('admin.cotisations.index') }}" class="pc-link">
      <span class="pc-micon"><i class="ph-duotone ph-receipt"></i></span>
      <span class="pc-mtext" data-i18n="My Cotisations">My Cotisations</span>
    </a>
  </li>
  @endrole

</ul>