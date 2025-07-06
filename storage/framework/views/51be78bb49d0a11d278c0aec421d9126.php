<ul class="pc-navbar">

  
  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view dashboard')): ?>
    <li class="pc-item">
    <a href="<?php echo e(route('dashboard')); ?>" class="pc-link">
      <span class="pc-micon"><i class="ph-duotone ph-gauge"></i></span>
      <span class="pc-mtext" data-i18n="Dashboard">Dashboard</span>
    </a>
    </li>
  <?php endif; ?>

  
  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view statistics')): ?>
    <li class="pc-item">
    <a href="<?php echo e(route('statistics')); ?>" class="pc-link">
      <span class="pc-micon"><i class="ph-duotone ph-chart-bar"></i></span>
      <span class="pc-mtext" data-i18n="Statistics">Statistics</span>
    </a>
    </li>
  <?php endif; ?>


  
  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage roles')): ?>
    <li class="pc-item">
    <a href="<?php echo e(route('admin.roles.index')); ?>" class="pc-link">
      <span class="pc-micon"><i class="ph-duotone ph-shield-star"></i></span>
      <span class="pc-mtext" data-i18n="Roles">Manage Roles</span>
    </a>
    </li>
  <?php endif; ?>

  
  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage permissions')): ?>
    <li class="pc-item">
    <a href="<?php echo e(route('admin.permissions.index')); ?>" class="pc-link">
      <span class="pc-micon"><i class="ph-duotone ph-keyhole"></i></span>
      <span class="pc-mtext" data-i18n="Permissions">Manage Permissions</span>
    </a>
    </li>
  <?php endif; ?>

  
  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage associations')): ?>
    <li class="pc-item">
    <a href="<?php echo e(route('admin.associations.index')); ?>" class="pc-link">
      <span class="pc-micon"><i class="ph-duotone ph-users-three"></i></span>
      <span class="pc-mtext" data-i18n="Associations">Manage Associations</span>
    </a>
    </li>
  <?php endif; ?>

  
  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view members')): ?>
    <li class="pc-item">
    <a href="<?php echo e(route('admin.membres.index')); ?>" class="pc-link">
      <span class="pc-micon"><i class="ph-duotone ph-user-circle"></i></span>
      <span class="pc-mtext" data-i18n="Membres">Manage Membres</span>
    </a>
    </li>
  <?php endif; ?>

  
  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view meetings')): ?>
    <li class="pc-item">
    <a href="<?php echo e(route('admin.meetings.index')); ?>" class="pc-link">
      <span class="pc-micon"><i class="ph-duotone ph-calendar-blank"></i></span>
      <span class="pc-mtext" data-i18n="Meetings">Manage Meetings</span>
    </a>
    </li>
  <?php endif; ?>

  
  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view events')): ?>
    <li class="pc-item">
    <a href="<?php echo e(auth()->user()->hasRole('member') ? route('membre.events.index') : route('admin.events.index')); ?>"
      class="pc-link">
      <span class="pc-micon"><i class="ph-duotone ph-calendar-check"></i></span>
      <span class="pc-mtext">
      <?php if (\Illuminate\Support\Facades\Blade::check('role', 'member')): ?> Events <?php else: ?> Manage Events <?php endif; ?>
      </span>
    </a>
    </li>
  <?php endif; ?>

  
  
  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view cotisations')): ?>
    <?php if (\Illuminate\Support\Facades\Blade::check('role', 'member')): ?>
    <li class="pc-item">
    <a href="<?php echo e(route('membre.cotisations.index')); ?>" class="pc-link">
      <span class="pc-micon"><i class="ph-duotone ph-receipt"></i></span>
      <span class="pc-mtext" data-i18n="My Cotisations">My Cotisations</span>
    </a>
    </li>
    <?php endif; ?>

    
    <?php if (\Illuminate\Support\Facades\Blade::check('hasanyrole', 'admin|superadmin|board')): ?>
    <li class="pc-item">
    <a href="<?php echo e(route('admin.cotisations.index')); ?>" class="pc-link">
      <span class="pc-micon"><i class="ph-duotone ph-receipt"></i></span>
      <span class="pc-mtext" data-i18n="Cotisations">Manage Cotisations</span>
    </a>
    </li>
    <?php endif; ?>
  <?php endif; ?>


  
  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view contributions')): ?>
    <li class="pc-item">
    <a href="<?php echo e(route('admin.contributions.index')); ?>" class="pc-link">
      <span class="pc-micon"><i class="ph-duotone ph-hand-heart"></i></span>
      <span class="pc-mtext" data-i18n="Contributions">Manage Contributions</span>
    </a>
    </li>
  <?php endif; ?>

  
  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view expenses')): ?>
    <li class="pc-item">
    <a href="<?php echo e(route('admin.expenses.index')); ?>" class="pc-link">
      <span class="pc-micon"><i class="ph-duotone ph-currency-circle-dollar"></i></span>
      <span class="pc-mtext" data-i18n="Expenses">Manage Expenses</span>
    </a>
    </li>
  <?php endif; ?>

</ul><?php /**PATH C:\Users\Outlaw\Desktop\Projects\MonAsso\resources\views/layouts/menu-list.blade.php ENDPATH**/ ?>