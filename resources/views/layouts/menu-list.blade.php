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

@role('super_admin')
<li class="pc-item">
  <a href="{{ url('/admin/permissions') }}" class="pc-link">
    <span class="pc-micon"><i class="ph-duotone ph-keyhole"></i></span>
    <span class="pc-mtext" data-i18n="Permissions">Manage Permissions</span>
  </a>
</li>
@endrole
