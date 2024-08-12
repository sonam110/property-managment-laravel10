<div class="card sticky-top" style="top:30px">
    <div class="list-group list-group-flush" id="useradd-sidenav">

        <a href="{{ route('app-setting.index')}}" class="list-group-item list-group-item-action border-0 {{ (request()->is('app-setting*') ? 'active' : '')}}">{{__('App Setting')}} <div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="{{route('property-type.index')}}" class="list-group-item list-group-item-action border-0 {{ (request()->is('property-type*') ? 'active' : '')}}">{{__('Property')}} <div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="{{ route('lease-type.index') }}" class="list-group-item list-group-item-action border-0 {{ (request()->is('lease-type*') ? 'active' : '')}}">{{__('Lease')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="{{ route('unit-type.index') }}" class="list-group-item list-group-item-action border-0 {{ (request()->is('unit-type*') ? 'active' : '')}}">{{__('Tenant')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

       <!--  <a href="{{ route('extra-charge.index') }}" class="list-group-item list-group-item-action border-0 {{ (Request::route()->getName() == 'extra-charge.index' ? 'active' : '')}}">{{__('Extra Charge Type')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="{{ route('late-fees.index') }}" class="list-group-item list-group-item-action border-0 {{ (Request::route()->getName() == 'late-fees.index' ? 'active' : '')}}">{{__('Late Fee Type')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="{{ route('lease-type.index') }}" class="list-group-item list-group-item-action border-0 {{ (request()->is('lease-type*') ? 'active' : '')}}">{{__('Lease Type')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a> -->

        

    </div>
</div>
