 <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
          
              <a class="header-brand" href="{{url('/')}}" class="app-brand-link">
                <img src="{{url('/')}}/{{ $appSetting->app_logo}}" class="" alt="{{$appSetting->app_name}}">
              </a>
            
            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
              <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
              <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboards -->
             <li class="menu-header small text-uppercase">
              <span class="menu-header-text">DASHBOARD</span>
            </li>
            <li class="menu-item {{ (request()->is('dashboard*') ? 'active' : '')}}">
              <a href="{{ route('dashboard') }}" class="menu-link">
                 <i class="menu-icon tf-icons ti ti-smart-home"></i>
                <div data-i18n="Dashboards">Dashboard</div>
              </a>
            </li>
            @can('user-browse')
            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">USER MANAGEMENT</span>
            </li>
            @endcan
             @can('user-browse')
            <li class="menu-item {{ (request()->is('users*') || request()->is('tenants*') ? 'active open' : '')}}">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-users"></i>
                <div data-i18n="Manage Users">Manage Users</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item {{ (request()->is('users*') ? 'active' : '')}}">
                  <a href="{{ route('users.index') }}" class="menu-link">
                    <div data-i18n="Users">Users</div>
                  </a>
                </li>
                <li class="menu-item {{ (request()->is('tenants*') ? 'active' : '')}}">
                  <a href="{{ route('tenants.index') }}" class="menu-link">
                    <div data-i18n="Tenants">Tenants</div>
                  </a>
                </li>

                
              </ul>
            </li>
            @endcan
           
            <li class="menu-item {{ (request()->is('roles*') || request()->is('permissions*') ? 'active open' : '')}}">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-layout-sidebar"></i>
              
                <div data-i18n="Roles & Permissions">Roles & Permissions</div>
              </a>
              <ul class="menu-sub">
                @can('role-browse')
                <li class="menu-item {{ (request()->is('roles*') ? 'active' : '')}}">
                  <a href="{{ route('roles.index') }}" class="menu-link">
                    <div data-i18n="Roles">Roles</div>
                  </a>
                </li>
                @endcan
                @can('permission-browse')
                <li class="menu-item {{ (request()->is('permissions*') ? 'active' : '')}}">
                  <a href="{{ route('permissions.index') }}" class="menu-link">
                    <div data-i18n="Permission">Permission</div>
                  </a>
                </li>
                @endcan
              </ul>
            </li>

             <!-- Dashboards -->
             <li class="menu-header small text-uppercase">
              <span class="menu-header-text">PROPERTY MANAGEMENT</span>
            </li>
            <li class="menu-item {{ (request()->is('property*') ? 'active' : '')}}">
              <a href="{{ route('property.index') }}" class="menu-link">
                 <i class="menu-icon tf-icons ti ti-color-swatch"></i>
                <div data-i18n="Property">Property</div>
              </a>
            </li>
            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">SETTINGS</span>
            </li>
            <li class="menu-item {{ (request()->is('app-setting*')  || request()->is('app-setting*') || request()->is('tenant-setting*') || request()->is('user-profile*') || request()->is('property-type*') ? 'active' : '')}}">
              <a href="{{ route('app-setting.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons ti ti-settings"></i>
                <div data-i18n="System Setup">System Setup</div>
              </a>
            </li>

          
          </ul>
        </aside>