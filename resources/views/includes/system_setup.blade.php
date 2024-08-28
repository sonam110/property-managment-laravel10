<div class="card sticky-top" style="top:30px">
    <div class="list-group list-group-flush" id="useradd-sidenav">

        <a href="{{ route('app-setting.index')}}" class="list-group-item list-group-item-action border-0 {{ (request()->is('app-setting*') ? 'active' : '')}}">{{__('App Setting')}} <div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="{{route('utility.index')}}" class="list-group-item list-group-item-action border-0 {{ (request()->is('property-type*')  || request()->is('unit-type*')  || request()->is('utility*') ? 'active' : '')}}">{{__('Property')}} <div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="{{ route('lease-setting') }}" class="list-group-item list-group-item-action border-0 {{ (request()->is('lease-type*') || request()->is('lease-setting*')  || request()->is('extra-type*')  || request()->is('late-fees*') ? 'active' : '')}}">{{__('Lease')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <!-- <a href="{{ route('tenant-setting') }}" class="list-group-item list-group-item-action border-0 {{ (request()->is('tenant-type*') || request()->is('tenant-setting*')  ? 'active' : '')}}">{{__('Tenant')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a> -->

        <a href="{{ route('user-profile.index') }}" class="list-group-item list-group-item-action border-0 {{ (request()->is('user-profile*') ||  request()->is(' change-password*') ? 'active' : '')}}">{{__('User Profile')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

     

        

    </div>
</div>
