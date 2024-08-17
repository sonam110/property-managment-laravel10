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
                      <h6 class="mt-4"> {{__('Lease Settings')}}</h6>
                      <div class="card mb-3">
                        <div class="card-header pt-2">
                          <ul class="nav nav-tabs card-header-tabs" role="tablist">
                            <li class="nav-item">
                              <button
                                class="nav-link {{ (request()->is('lease-setting') ? 'active' : '')}}"
                                data-bs-toggle="tab"
                                data-bs-target="#form-tabs-leasesetting"
                                role="tab"
                                aria-selected="true">
                                Lease Setting
                              </button>
                            </li>
                            <li class="nav-item">
                              <button
                                class="nav-link {{ (request()->is('lease-type*') ? 'active ' : '')}}"
                                class="nav-link "
                                data-bs-toggle="tab"
                                data-bs-target="#form-tabs-Leasetype"
                                role="tab"
                                aria-selected="false">
                                Lease Type
                              </button>
                            </li>
                            <li class="nav-item">
                              <button
                                class="nav-link {{ (request()->is('extra-charge*') ? 'active ' : '')}}"
                                class="nav-link "
                                data-bs-toggle="tab"
                                data-bs-target="#form-tabs-extracharge"
                                role="tab"
                                aria-selected="false">
                                Extra Charge 
                              </button>
                            </li>
                            <li class="nav-item">
                              <button
                                class="nav-link {{ (request()->is('late-fees*') ? 'active ' : '')}}"
                                class="nav-link "
                                data-bs-toggle="tab"
                                data-bs-target="#form-tabs-lateFees"
                                role="tab"
                                aria-selected="false">
                                Late Fees 
                              </button>
                            </li>
                            <li class="nav-item">
                              <button
                                class="nav-link"
                                data-bs-toggle="tab"
                                data-bs-target="#form-tabs-Contract"
                                role="tab"
                                aria-selected="false">
                                Contract Document 
                              </button>
                            </li>
                          </ul>
                        </div>

                        <div class="tab-content">
                            <div class="tab-pane fade {{ (request()->is('lease-setting*') ? 'active show' : '')}}" id="form-tabs-leasesetting" role="tabpanel">
                             {{Form::model($appSetting,array('route' => array('leaseupdate', $appSetting->id), 'method' => 'PUT','enctype'=>'multipart/form-data', 'files'=>true)) }}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        {{ Form::label('lease_prefix', __('Lease Number Prefix'), ['class' => 'form-label']) }}
                                        {{ Form::text('lease_prefix', 'LS', ['class' => 'form-control', 'placeholder' => __('Lease Number Prefix'), 'required' => 'required']) }}
                                        @error('lease_prefix')
                                            <small class="invalid-name" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                                
                               <div class="col-md-6">
                                    <div class="mb-3">
                                        {{ Form::label('invoice_prefix', __('Invoice Number Prefix'), ['class' => 'form-label']) }}
                                        {{ Form::text('invoice_prefix', 'INV', ['class' => 'form-control', 'placeholder' => __('Invoice Number Prefix'), 'required' => 'required']) }}
                                        @error('invoice_prefix')
                                            <small class="invalid-name" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                            

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        {{ Form::label('invoice_disclaimer', __('Invoice disclaimer'), ['class' => 'form-label']) }}
                                        {{ Form::text('invoice_disclaimer', null, ['class' => 'form-control', 'placeholder' => __('Invoice disclaimer')]) }}
                                        @error('invoice_disclaimer')
                                            <small class="invalid-email" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                                 <div class="col-md-12">
                                    <div class="mb-3">
                                        {{ Form::label('invoice_terms', __('Invoice terms'), ['class' => 'form-label']) }}
                                        {{ Form::text('invoice_terms', null, ['class' => 'form-control', 'placeholder' => __('Invoice terms')]) }}
                                        @error('invoice_terms')
                                            <small class="invalid-email" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        {{ Form::label('recipt_note', __('Recipt note'), ['class' => 'form-label']) }}
                                        {{ Form::textarea('recipt_note', null, ['class' => 'form-control', 'placeholder' => __('Recipt note'),'rows'=>2]) }}
                                      
                                    </div>
                                </div>
                                
                                 <div class="col-md-12">
                                    <div class="mb-3">
                                        {{ Form::label('generate_invoice_day', __('Generate Invoice on(Day of month)'), ['class' => 'form-label']) }}
                                        <select name="generate_invoice_day" class="form-control">
                                        @for ($i = 1; $i <= 28; $i++) 
                                        <option value="{{ $i }}" {{ ($appSetting->generate_invoice_day == $i) ?
                                            'selected' :'' }}> {{ $i }}</option><br>
                                        @endfor
                                        </select>
                                    </div>
                                </div>
                               
                                
                        
                        <div class="pt-4">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light">Update</button>
                            
                        </div>
       
                    </div>
                      {{Form::close()}}
                          </div>
                          <div class="tab-pane fade {{ (request()->is('lease-type*') ? 'active show' : '')}}" id="form-tabs-Leasetype" role="tabpanel">

                             <a href="#" data-url="{{ route('lease-type.create') }}" data-ajax-popup="true" data-title="{{__('Create Lease Type')}}" data-bs-toggle="tooltip" title="{{__('Create')}}"  class="btn btn-sm btn-primary">
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
                                    @foreach ($LeaseTypes as $leaseType)
                                        <tr>
                                            <td>{{ $leaseType->name }}</td>
                                            <td>{{ $leaseType->display_name }}</td>
                                            <td>{{ $leaseType->description }}</td>
                                            <td class="Action text-end">
                                               <div class="btn-group btn-group-xs">
                
                                                      <div class="action-btn bg-info ms-2">

                                                        <a href="#" class="btn btn-sm btn-primary d-inline-flex align-items-center" data-url="{{ URL::to('lease-type/'.$leaseType->id.'/edit') }}"  data-ajax-popup="true" data-title="{{__('Edit Lease Type')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}"><i class="ti ti-pencil text-white"></i></a>
                                                    </div>
                                                    
                                                        <div class="action-btn bg-danger ms-2">
                                                                {!! Form::open([
                                                                    'method' => 'DELETE',
                                                                    'route' => ['lease-type.destroy', $leaseType->id],
                                                                    'id' => 'delete-form-' . $leaseType->id,
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
                          <div class="tab-pane fade {{ (request()->is('extra-charge*') ? 'active show' : '')}}" id="form-tabs-extracharge" role="tabpanel">
                            <a href="#" data-url="{{ route('extra-charge.create') }}" data-ajax-popup="true" data-title="{{__('Create Extra Charge')}}" data-bs-toggle="tooltip" title="{{__('Create')}}"  class="btn btn-sm btn-primary">
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
                                    @foreach ($extraCharges as $extraCharge)
                                        <tr>
                                            <td>{{ $extraCharge->name }}</td>
                                            <td>{{ $extraCharge->display_name }}</td>
                                            <td>{{ $extraCharge->description }}</td>
                                            <td class="Action text-end">
                                               <div class="btn-group btn-group-xs">
                
                                                      <div class="action-btn bg-info ms-2">

                                                        <a href="#" class="btn btn-sm btn-primary d-inline-flex align-items-center" data-url="{{ URL::to('extra-charge/'.$extraCharge->id.'/edit') }}"  data-ajax-popup="true" data-title="{{__('Edit Extra Charge')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}"><i class="ti ti-pencil text-white"></i></a>
                                                    </div>
                                                    
                                                        <div class="action-btn bg-danger ms-2">
                                                                {!! Form::open([
                                                                    'method' => 'DELETE',
                                                                    'route' => ['extra-charge.destroy', $extraCharge->id],
                                                                    'id' => 'delete-form-' . $extraCharge->id,
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
                          <div class="tab-pane fade {{ (request()->is('late-fees*') ? 'active show' : '')}}" id="form-tabs-Leasetype" role="tabpanel">

                             <a href="#" data-url="{{ route('late-fees.create') }}" data-ajax-popup="true" data-title="{{__('Create Late Fee')}}" data-bs-toggle="tooltip" title="{{__('Create')}}"  class="btn btn-sm btn-primary">
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
                                    @foreach ($LateFees as $lateFee)
                                        <tr>
                                            <td>{{ $lateFee->name }}</td>
                                            <td>{{ $lateFee->display_name }}</td>
                                            <td>{{ $lateFee->description }}</td>
                                            <td class="Action text-end">
                                               <div class="btn-group btn-group-xs">
                
                                                      <div class="action-btn bg-info ms-2">

                                                        <a href="#" class="btn btn-sm btn-primary d-inline-flex align-items-center" data-url="{{ URL::to('late-fees/'.$lateFee->id.'/edit') }}"  data-ajax-popup="true" data-title="{{__('Edit Late Fee')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}"><i class="ti ti-pencil text-white"></i></a>
                                                    </div>
                                                    
                                                        <div class="action-btn bg-danger ms-2">
                                                                {!! Form::open([
                                                                    'method' => 'DELETE',
                                                                    'route' => ['late-fees.destroy', $lateFee->id],
                                                                    'id' => 'delete-form-' . $lateFee->id,
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
                          <div class="tab-pane fade" id="form-tabs-Contract" role="tabpanel">
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
