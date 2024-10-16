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
             <!--<li class="menu-header small text-uppercase">
              <span class="menu-header-text">DASHBOARD</span>
            </li>-->
            <li class="menu-item {{ (request()->is('dashboard*') ? 'active' : '')}}">
              <a href="{{ route('dashboard') }}" class="menu-link">
                 <i class="menu-icon tf-icons ti ti-smart-home"></i>
                <div data-i18n="Dashboards">Dashboard</div>
              </a>
            </li>
            @can('user-browse')
            <!--<li class="menu-header small text-uppercase">
              <span class="menu-header-text">USER MANAGEMENT</span>
            </li>-->
            <li class="menu-item {{ (request()->is('users*') ? 'active' : '')}}">
              <a href="{{ route('users.index') }}" class="menu-link">
                 <i class="menu-icon tf-icons ti ti-user"></i>
                <div data-i18n="Users">Users</div>
              </a>
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

             <!-- PROPERTY -->
             @can('property-browse')
            <!--<li class="menu-header small text-uppercase">
              <span class="menu-header-text">PROPERTY MANAGEMENT</span>
            </li>-->
           
            <li class="menu-item {{ (request()->is('property*') ? 'active' : '')}}">
              <a href="{{ route('property.index') }}" class="menu-link">
                 <i class="menu-icon tf-icons ti ti-home"></i>
                <div data-i18n="Properties">Properties</div>
              </a>
            </li>
            @endcan
            <!-- TENANT -->
            <!--<li class="menu-header small text-uppercase">
              <span class="menu-header-text">LEASE MANAGEMENT</span>
            </li>-->
             @can('tenant-browse')
            <li class="menu-item {{ (request()->is('tenants*') ? 'active' : '')}}">
              <a href="{{ route('tenants.index') }}" class="menu-link">
                 <i class="menu-icon tf-icons ti ti-user"></i>
                <div data-i18n="Tenants">Tenants</div>
              </a>
            </li>
             @endcan
             @can('lease-browse')
            <li class="menu-item {{ (request()->is('leases*') ? 'active' : '')}}">
              <a href="{{ route('leases.index') }}" class="menu-link">
                 <i class="menu-icon tf-icons ti ti-server"></i>
                <div data-i18n="Leases">Leases</div>
              </a>
            </li>
            @endcan
            @can('lease-contract')
            
             <!--  <li class="menu-item {{ (request()->is('contract-document*') ? 'active' : '')}}">
                <a href="{{ route('contract-document') }}" class="menu-link">
                   <i class="menu-icon tf-icons ti ti-files"></i>
                  <div data-i18n="Contract Document">Contract Document </div>
                </a>
              </li> -->
              @endcan
              @can('invoice-browse')
             <!--<li class="menu-header small text-uppercase">
              <span class="menu-header-text">INVOICE MANAGEMENT</span>
            </li>-->
            <li class="menu-item {{ (request()->is('invoice*') ? 'active' : '')}}">
              <a href="{{ route('invoice') }}" class="menu-link">
                 <i class="menu-icon tf-icons ti ti-file-invoice"></i>
                <div data-i18n="Invoices">Invoices</div>
              </a>
            </li>
            <li class="menu-item {{ (request()->is('payment-history') ? 'active' : '')}}">
              <a href="{{ route('payment-history') }}" class="menu-link">
                 <i class="menu-icon tf-icons ti ti-bookmarks"></i>
                <div data-i18n="Payment History">Payment History</div>
              </a>
            </li>
             @endcan
              <!--<li class="menu-header small text-uppercase">
              <span class="menu-header-text">ACCOUNT MANAGEMENT</span>
            </li>-->
            <li class="menu-item {{ (request()->is('expense*') ? 'active' : '')}}">
              <a href="{{ route('expense.index') }}" class="menu-link">
                 <i class="menu-icon tf-icons ti ti-file"></i>
                <div data-i18n="Expenses">Expenses</div>
              </a>
            </li>
             @can('app-setting')
            <!--<li class="menu-header small text-uppercase">
              <span class="menu-header-text">SETTINGS</span>
            </li>-->
            <li class="menu-item {{ (request()->is('app-setting*')  || request()->is('app-setting*') || request()->is('tenant-setting*') || request()->is('user-profile*') || request()->is('property-type*') ? 'active' : '')}}">
              <a href="{{ route('app-setting.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons ti ti-settings"></i>
                <div data-i18n="System Setup">System Setup</div>
              </a>
            </li>
            @endcan
          
          </ul>
        </aside>