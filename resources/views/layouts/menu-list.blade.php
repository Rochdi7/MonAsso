{{-- Dashboard: Visible to everyone logged in --}}
<li class="pc-item">
  <a href="/dashboard" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-gauge"></i>
    </span>
    <span class="pc-mtext" data-i18n="Dashboard">Dashboard</span>
  </a>
</li>

{{-- Roles CRUD: Only for super_admin --}}
@role('super_admin')
<li class="pc-item">
  <a href="{{ url('/admin/roles') }}" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-shield-star"></i>
    </span>
    <span class="pc-mtext" data-i18n="Roles">Manage Roles</span>
  </a>
</li>
@endrole

{{-- Permissions CRUD: Only for super_admin --}}
@role('super_admin')
<li class="pc-item">
  <a href="{{ url('/admin/permissions') }}" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-keyhole"></i>
    </span>
    <span class="pc-mtext" data-i18n="Permissions">Manage Permissions</span>
  </a>
</li>
@endrole

{{-- Associations CRUD: Only for super_admin --}}
@role('super_admin')
<li class="pc-item">
  <a href="{{ url('/admin/associations') }}" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-users-three"></i>
    </span>
    <span class="pc-mtext" data-i18n="Associations">Manage Associations</span>
  </a>
</li>
@endrole

{{-- Membres CRUD: For super_admin and admin --}}
@role('super_admin|admin')
<li class="pc-item">
  <a href="{{ url('/admin/membres') }}" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-user-circle"></i>
    </span>
    <span class="pc-mtext" data-i18n="Membres">Manage Membres</span>
  </a>
</li>
@endrole

{{-- Meetings CRUD: For super_admin and admin --}}
@role('super_admin|admin')
<li class="pc-item">
  <a href="{{ url('/admin/meetings') }}" class="pc-link">
    <span class="pc-micon">
      <i class="ph-duotone ph-calendar-blank"></i>
    </span>
    <span class="pc-mtext" data-i18n="Meetings">Manage Meetings</span>
  </a>
</li>
@endrole
