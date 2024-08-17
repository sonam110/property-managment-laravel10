@extends('layouts.master')
@section('page-title')
    {{__('Property Settings')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('app-setting.index')}}">{{__('Settings')}}</a></li>
    <li class="breadcrumb-item">{{__('Property')}}</li>
@endsection


@section('content')
    <div class="row">
        <div class="col-3">
            @include('includes.system_setup')
        </div>
        <div class="col-9">
            <div class="card">
                <div class="card-body table-border-style">

                <div class="row">
                    <div class="col">
                      <h6 class="mt-4"> {{__('Property Settings')}}</h6>
                      <div class="card mb-3">
                        <div class="card-header pt-2">
                          <ul class="nav nav-tabs card-header-tabs" role="tablist">
                            <li class="nav-item">
                              <button
                                class="nav-link {{ (request()->is('property-type*') ? 'active' : '')}}"
                                data-bs-toggle="tab"
                                data-bs-target="#form-tabs-Property"
                                role="tab"
                                aria-selected="true">
                                Property Type
                              </button>
                            </li>
                            <li class="nav-item">
                              <button
                                class="nav-link {{ (request()->is('utility*') ? 'active' : '')}}"
                                data-bs-toggle="tab"
                                data-bs-target="#form-tabs-Utilies"
                                role="tab"
                                aria-selected="false">
                                Utilities
                              </button>
                            </li>
                            <li class="nav-item">
                              <button
                                class="nav-link {{ (request()->is('unit-type*') ? 'active' : '')}}"
                                data-bs-toggle="tab"
                                data-bs-target="#form-tabs-unit"
                                role="tab"
                                aria-selected="false">
                                Unit Type
                              </button>
                            </li>
                          </ul>
                        </div>

                        <div class="tab-content">
                          <div class="tab-pane fade {{ (request()->is('property-type*') ? 'active show' : '')}}" id="form-tabs-Property" role="tabpanel">

                             <a href="#" data-url="{{ route('property-type.create') }}" data-ajax-popup="true" data-title="{{__('Create Property Type')}}" data-bs-toggle="tooltip" title="{{__('Create')}}"  class="btn btn-sm btn-primary">
                                  <i class="ti ti-plus"></i>
                              </a>
                             <div class="table-responsive">
                                <table class="table datatable" id="example">
                                    <thead>
                                    <tr>
                                        <th>{{__('Name')}}</th>
                                        <th>{{__('Display Name')}}</th>
                                        <th>{{__('Description')}}</th>
                                        <th width="200px">{{__('Action')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody class="font-style">
                                    @foreach ($propertyTypes as $property)
                                        <tr>
                                            <td>{{ $property->name }}</td>
                                            <td>{{ $property->display_name }}</td>
                                            <td>{{ $property->description }}</td>
                                            <td class="Action text-end">
                                               <div class="btn-group btn-group-xs">
                
                                                      <div class="action-btn bg-info ms-2">

                                                        <a href="#" class="btn btn-sm btn-primary d-inline-flex align-items-center" data-url="{{ URL::to('property-type/'.$property->id.'/edit') }}"  data-ajax-popup="true" data-title="{{__('Edit Property Type')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}"><i class="ti ti-pencil text-white"></i></a>
                                                    </div>
                                                    
                                                        <div class="action-btn bg-danger ms-2">
                                                                {!! Form::open([
                                                                    'method' => 'DELETE',
                                                                    'route' => ['property-type.destroy', $property->id],
                                                                    'id' => 'delete-form-' . $property->id,
                                                                ]) !!}
                                                                <a href="#"
                                                                    class="btn btn-sm btn-danger  align-items-center bs-pass-para"
                                                                    data-bs-toggle="tooltip" title="{{ __('Delete') }}"><i
                                                                        class="ti ti-trash text-white"></i></a>
                                                                {!! Form::close() !!}
                                                            </div>
                                                  
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                          </div>
                          <div class="tab-pane fade {{ (request()->is('utility*') ? 'active show' : '')}}" id="form-tabs-Utilies" role="tabpanel">
                            <a href="#" data-url="{{ route('utility.create') }}" data-ajax-popup="true" data-title="{{__('Create utility')}}" data-bs-toggle="tooltip" title="{{__('Create')}}"  class="btn btn-sm btn-primary">
                                  <i class="ti ti-plus"></i>
                              </a>
                             <div class="table-responsive">
                                <table class="table datatable" id="example">
                                    <thead>
                                    <tr>
                                        <th>{{__('Name')}}</th>
                                        <th>{{__('Display Name')}}</th>
                                        <th>{{__('Description')}}</th>
                                        <th width="200px">{{__('Action')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody class="font-style">
                                    @foreach ($utilities as $utility)
                                        <tr>
                                            <td>{{ $utility->name }}</td>
                                            <td>{{ $utility->display_name }}</td>
                                            <td>{{ $utility->description }}</td>
                                            <td class="Action text-end">
                                               <div class="btn-group btn-group-xs">
                
                                                      <div class="action-btn bg-info ms-2">

                                                        <a href="#" class="btn btn-sm btn-primary d-inline-flex align-items-center" data-url="{{ URL::to('utility/'.$utility->id.'/edit') }}"  data-ajax-popup="true" data-title="{{__('Edit Utility')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}"><i class="ti ti-pencil text-white"></i></a>
                                                    </div>
                                                    
                                                        <div class="action-btn bg-danger ms-2">
                                                                {!! Form::open([
                                                                    'method' => 'DELETE',
                                                                    'route' => ['utility.destroy', $utility->id],
                                                                    'id' => 'delete-form-' . $utility->id,
                                                                ]) !!}
                                                                <a href="#"
                                                                    class="btn btn-sm btn-danger  align-items-center bs-pass-para"
                                                                    data-bs-toggle="tooltip" title="{{ __('Delete') }}"><i
                                                                        class="ti ti-trash text-white"></i></a>
                                                                {!! Form::close() !!}
                                                            </div>
                                                  
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                          </div>
                          <div class="tab-pane fade {{ (request()->is('unit-type*') ? 'active show' : '')}}" id="form-tabs-unit" role="tabpanel">
                            <a href="#" data-url="{{ route('unit-type.create') }}" data-ajax-popup="true" data-title="{{__('Create unit Type')}}" data-bs-toggle="tooltip" title="{{__('Create')}}"  class="btn btn-sm btn-primary">
                                  <i class="ti ti-plus"></i>
                              </a>
                             <div class="table-responsive">
                                <table class="table datatable" id="example">
                                    <thead>
                                    <tr>
                                        <th>{{__('Name')}}</th>
                                        <th>{{__('Display Name')}}</th>
                                        <th>{{__('Description')}}</th>
                                        <th width="200px">{{__('Action')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody class="font-style">
                                    @foreach ($unitTypes as $unitType)
                                        <tr>
                                            <td>{{ $unitType->name }}</td>
                                            <td>{{ $unitType->display_name }}</td>
                                            <td>{{ $unitType->description }}</td>
                                            <td class="Action text-end">
                                               <div class="btn-group btn-group-xs">
                
                                                      <div class="action-btn bg-info ms-2">

                                                        <a href="#" class="btn btn-sm btn-primary d-inline-flex align-items-center" data-url="{{ URL::to('unit-type/'.$unitType->id.'/edit') }}"  data-ajax-popup="true" data-title="{{__('Edit unit Type')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}"><i class="ti ti-pencil text-white"></i></a>
                                                    </div>
                                                    
                                                        <div class="action-btn bg-danger ms-2">
                                                                {!! Form::open([
                                                                    'method' => 'DELETE',
                                                                    'route' => ['unit-type.destroy', $unitType->id],
                                                                    'id' => 'delete-form-' . $unitType->id,
                                                                ]) !!}
                                                                <a href="#"
                                                                    class="btn btn-sm btn-danger  align-items-center bs-pass-para"
                                                                    data-bs-toggle="tooltip" title="{{ __('Delete') }}"><i
                                                                        class="ti ti-trash text-white"></i></a>
                                                                {!! Form::close() !!}
                                                            </div>
                                                  
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
              </div>
                </div>
            </div>
        </div>
    </div>
@endsection
