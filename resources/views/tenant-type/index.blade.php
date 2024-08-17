@extends('layouts.master')
@section('page-title')
    {{__('Property Settings')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('app-setting.index')}}">{{__('Settings')}}</a></li>
    <li class="breadcrumb-item">{{__('Tenant')}}</li>
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
                      <h6 class="mt-4"> {{__('Tenant Settings')}}</h6>
                      <div class="card mb-3">
                        <div class="card-header pt-2">
                          <ul class="nav nav-tabs card-header-tabs" role="tablist">
                            <li class="nav-item">
                              <button
                                class="nav-link {{ (request()->is('tenant-setting') ? 'active' : '')}}"
                                data-bs-toggle="tab"
                                data-bs-target="#form-tabs-Tenant"
                                role="tab"
                                aria-selected="true">
                                Tenant
                              </button>
                            </li>
                            <li class="nav-item {{ (request()->is('tenant-type') ? 'active' : '')}}">
                              <button
                                class="nav-link"
                                data-bs-toggle="tab"
                                data-bs-target="#form-tabs-TenantType"
                                role="tab"
                                aria-selected="false">
                                Tenant Type
                              </button>
                            </li>
                            
                          </ul>
                        </div>

                        <div class="tab-content">
                            <div class="tab-pane fade {{ (request()->is('tenant-setting*') ? 'active show' : '')}}" id="form-tabs-Tenant" role="tabpanel">
                             {{Form::model($appSetting,array('route' => array('tenantupdate', $appSetting->id), 'method' => 'PUT','enctype'=>'multipart/form-data', 'files'=>true)) }}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        {{ Form::label('tenant_prefix', __('Tenant Number Prefix'), ['class' => 'form-label']) }}
                                        {{ Form::text('tenant_prefix', 'TNT', ['class' => 'form-control', 'placeholder' => __('Tenant Number Prefix'), 'required' => 'required']) }}
                                        @error('tenant_prefix')
                                            <small class="invalid-name" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                                
                        <div class="pt-4">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light">Update</button>
                            
                        </div>
       
                    </div>
                      {{Form::close()}}
                          </div>
                          <div class="tab-pane fade {{ (request()->is('tenant-type*') ? 'active show' : '')}}" id="form-tabs-TenantType" role="tabpanel">

                             <a href="#" data-url="{{ route('tenant-type.create') }}" data-ajax-popup="true" data-title="{{__('Create Tenant Type')}}" data-bs-toggle="tooltip" title="{{__('Create')}}"  class="btn btn-sm btn-primary">
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
                                    @foreach ($tenantTypes as $tenantType)
                                        <tr>
                                            <td>{{ $tenantType->name }}</td>
                                            <td>{{ $tenantType->display_name }}</td>
                                            <td>{{ $tenantType->description }}</td>
                                            <td class="Action text-end">
                                               <div class="btn-group btn-group-xs">
                
                                                      <div class="action-btn bg-info ms-2">

                                                        <a href="#" class="btn btn-sm btn-primary d-inline-flex align-items-center" data-url="{{ URL::to('tenant-type/'.$tenantType->id.'/edit') }}"  data-ajax-popup="true" data-title="{{__('Edit Tenant Type')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}"><i class="ti ti-pencil text-white"></i></a>
                                                    </div>
                                                    
                                                        <div class="action-btn bg-danger ms-2">
                                                                {!! Form::open([
                                                                    'method' => 'DELETE',
                                                                    'route' => ['tenant-type.destroy', $tenantType->id],
                                                                    'id' => 'delete-form-' . $tenantType->id,
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
