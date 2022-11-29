<aside class="main-sidebar sidebar-dark-danger elevation-4">
    <a href="{{ route('admin.dashboard') }}" class="brand-link bg-bakebe">
        @include('partials.brand')
    </a>

    <div class="sidebar">
        @if (auth()->check())
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ $self->renderAvatar() }}" class="img-circle elevation-2" style="width: 35px; height: 35px;">
                </div>
                <div class="info">
                    <a href="{{ route('admin.profiles.show') }}" class="d-block">
                        {{ $self->renderName() }}
                    </a>
                </div>
            </div>
        @endif

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ $checker->route->areOnRoutes([
                        'admin.dashboard',
                    ]) }}">
                        <i class="nav-icon fa fa-th"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                @if ($self->hasAnyPermission(['admin.bookings.index', 'admin.bookings.show']))
                <li class="nav-item">
                    <a href="{{ route('admin.bookings.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                        'admin.bookings.index','admin.bookings.show'
                    ]) }}">
                        <i class="nav-icon fas fa-calendar-check"></i>
                        <p>
                            Reservations
                        </p>
                    </a>
                </li>
                @endif

                @if ($self->hasAnyPermission(['admin.pastries.index', 'admin.pastries.store', 'admin.pastries.update', 'admin.pastries.restore', 'admin.pastries.archive', 'admin.categories.index', 'admin.categories.store', 'admin.categories.update', 'admin.categories.restore', 'admin.categories.archive',]))
                    <li class="nav-item has-treeview {{ $checker->route->areOnRoutes([
                            'admin.categories.index','admin.categories.create','admin.categories.show',
                            'admin.pastries.index','admin.pastries.create','admin.pastries.show',                            
                        ]) }}">
                        <a href="javascript:void(0)" class="nav-link">
                            <i class="nav-icon fas fa-birthday-cake"></i>
                            <p>
                                Pastry Management
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">                
                            
                            @if ($self->hasAnyPermission(['admin.categories.index', 'admin.categories.store', 'admin.categories.update', 'admin.categories.restore', 'admin.categories.archive']))
                            <li class="nav-item">
                                <a href="{{ route('admin.categories.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                    'admin.categories.index','admin.categories.create','admin.categories.show'
                                ]) }}">
                                    <i class="nav-icon fas fa-circle"></i>
                                    <p>
                                        Pastry Category
                                    </p>
                                </a>
                            </li>
                            @endif
                            
                            @if ($self->hasAnyPermission(['admin.pastries.index', 'admin.pastries.store', 'admin.pastries.update', 'admin.pastries.restore', 'admin.pastries.archive']))
                            <li class="nav-item">
                                <a href="{{ route('admin.pastries.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                    'admin.pastries.index','admin.pastries.create','admin.pastries.show'
                                ]) }}">
                                    <i class="nav-icon fas fa-circle"></i>
                                    <p>
                                        Pastry
                                    </p>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>
                @endif   


                @if ($self->hasAnyPermission(['admin.branches.index', 'admin.branches.store', 'admin.branches.update']))
                <li class="nav-item">
                    <a href="{{ route('admin.branches.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                        'admin.branches.index','admin.branches.create','admin.branches.show'
                    ]) }}">
                        <i class="nav-icon fas fa-store"></i>
                        <p>
                            Branch
                        </p>
                    </a>
                </li>
                @endif

                @if ($self->hasAnyPermission(['admin.coupons.index', 'admin.coupons.store', 'admin.coupons.update','admin.couponusages.crud']))
                    <li class="nav-item has-treeview {{ $checker->route->areOnRoutes([
                            'admin.coupons.index','admin.coupons.create','admin.coupons.show',
                        'admin.couponusages.index','admin.couponusages.create','admin.couponusages.show',                            
                        ]) }}">
                        <a href="javascript:void(0)" class="nav-link">
                            <i class="nav-icon fas fa-ticket-alt"></i>
                            <p>
                                Coupon Management
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                        @if ($self->hasAnyPermission(['admin.coupons.index', 'admin.coupons.store', 'admin.coupons.update', 'admin.coupons.restore', 'admin.coupons.archive']))
                            <li class="nav-item">
                                <a href="{{ route('admin.coupons.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                    'admin.coupons.index','admin.coupons.create','admin.coupons.show'
                                ]) }}">
                                    <i class="nav-icon fas fa-circle"></i>
                                    <p>
                                        Coupon
                                    </p>
                                </a>
                            </li>
                            @endif
                            @if ($self->hasAnyPermission(['admin.couponusages.crud']))
                            <li class="nav-item">
                                <a href="{{ route('admin.couponusages.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                    'admin.couponusages.index','admin.couponusages.create','admin.couponusages.show'
                                ]) }}">
                                    <i class="nav-icon fas fa-circle"></i>
                                    <p>
                                        Coupon Usages
                                    </p>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>
                @endif
                
                @if ($self->hasAnyPermission(['admin.promos.index', 'admin.promos.store', 'admin.promos.update', 'admin.promos.restore', 'admin.promos.archive']))
                <li class="nav-item">
                    <a href="{{ route('admin.promos.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                        'admin.promos.index','admin.promos.create','admin.promos.show'
                    ]) }}">
                        <i class="nav-icon fas fa-percentage"></i>
                        <p>
                            Ticket Type
                        </p>
                    </a>
                </li>
                @endif
                
                @if ($self->hasAnyPermission(['admin.intervals.index', 'admin.intervals.store', 'admin.intervals.update', 'admin.intervals.restore', 'admin.intervals.archive']))
                <li class="nav-item">
                    <a href="{{ route('admin.intervals.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                        'admin.intervals.index','admin.intervals.create','admin.intervals.show'
                    ]) }}">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        <p>
                            Block Date Interval
                        </p>
                    </a>
                </li>
                @endif
                
                @if ($self->hasAnyPermission(['admin.types.index', 'admin.types.show']))
                <li class="nav-item">
                    <a href="{{ route('admin.types.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                        'admin.types.index','admin.types.create','admin.types.show'
                    ]) }}">
                        <i class="nav-icon far fa-calendar"></i>
                        <p>
                            Booking Type
                        </p>
                    </a>
                </li>
                @endif           

                @if ($self->hasAnyPermission(['admin.pages.crud', 'admin.page-items.crud']))
                    <li class="nav-item has-treeview {{ $checker->route->areOnRoutes([
                            'admin.pages.index','admin.pages.create','admin.pages.show',
                            'admin.page-items.index','admin.page-items.create','admin.page-items.show',
                        ]) }}">
                        <a href="javascript:void(0)" class="nav-link">
                            <i class="nav-icon fas fa-feather"></i>
                            <p>
                                Content Management
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if ($self->hasAnyPermission(['admin.pages.crud']))
                                <li class="nav-item">
                                    <a href="{{ route('admin.pages.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                        'admin.pages.index','admin.pages.create','admin.pages.show',
                                    ]) }}">
                                        <i class="nav-icon far fa-circle"></i>
                                        <p>
                                            Pages
                                        </p>
                                    </a>
                                </li>
                            @endif
                            
                            @if ($self->hasAnyPermission(['admin.page-items.crud']))
                                <li class="nav-item">
                                    <a href="{{ route('admin.page-items.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                        'admin.page-items.index','admin.page-items.create','admin.page-items.show',
                                    ]) }}">
                                        <i class="nav-icon far fa-circle"></i>
                                        <p>
                                            Page Items
                                        </p>
                                    </a>
                                </li>
                            @endif

                            <li class="nav-item">
                                <a href="{{ route('admin.hows.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                    'admin.hows.index','admin.hows.create','admin.hows.show'
                                ]) }}">
                                    <i class="nav-icon far fa-calendar"></i>
                                    <p>
                                        How To Reserve Steps
                                    </p>
                                </a>
                            </li>     
                        </ul>
                    </li>
                @endif

                @if ($self->hasAnyPermission(['admin.admin-users.crud', 'admin.roles.crud', 'admin.users.crud', 'admin.activity-logs.crud']))
                    <li class="nav-header">Admin Management</li>
                @endif

                @if ($self->hasAnyPermission(['admin.admin-users.crud', 'admin.roles.crud']))
                    <li class="nav-item has-treeview {{ $checker->route->areOnRoutes([
                            'admin.admin-users.index','admin.admin-users.create','admin.admin-users.show',
                            'admin.roles.index', 'admin.roles.create', 'admin.roles.show',
                        ]) }}">
                        <a href="javascript:void(0)" class="nav-link">
                            <i class="nav-icon fas fa-user-shield"></i>
                            <p>
                                Admin Management
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if ($self->hasAnyPermission(['admin.admin-users.crud']))
                                <li class="nav-item">
                                    <a href="{{ route('admin.admin-users.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                        'admin.admin-users.index','admin.admin-users.create','admin.admin-users.show',
                                    ]) }}">
                                        <i class="nav-icon far fa-circle"></i>
                                        <p>
                                            Admins
                                        </p>
                                    </a>
                                </li>
                            @endif

                            @if ($self->hasAnyPermission(['admin.roles.crud']))
                                <li class="nav-item">
                                    <a href="{{ route('admin.roles.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                        'admin.roles.index', 'admin.roles.create', 'admin.roles.show'
                                    ]) }}">
                                        <i class="nav-icon far fa-circle"></i>
                                        <p>
                                            Roles & Permissions
                                        </p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if ($self->hasAnyPermission(['admin.users.crud']))
                    <li class="nav-item has-treeview {{ $checker->route->areOnRoutes([
                            'admin.users.index','admin.users.create','admin.users.show',
                        ]) }}">
                        <a href="javascript:void(0)" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                User Management
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if ($self->hasAnyPermission(['admin.users.crud']))
                                <li class="nav-item">
                                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                        'admin.users.index','admin.users.create','admin.users.show',
                                    ]) }}">
                                        <i class="nav-icon far fa-circle"></i>
                                        <p>
                                            Users
                                        </p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if ($self->hasAnyPermission(['admin.activity-logs.crud']))
                    <li class="nav-item">
                        <a href="{{ route('admin.activity-logs.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                            'admin.activity-logs.index',
                        ]) }}">
                            <i class="nav-icon fa fa-file-alt"></i>
                            <p>
                                Activity Logs
                            </p>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>

    </div>
</aside>