@extends('layouts.master')
@section('page-title')
    {{__('App Setting')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('App Setting')}}</li>
@endsection
@section('content')
    <div class="row">
        <div class="col-3">
            @include('includes.system_setup')
        </div>
       
        <div class="col-9">
            <div class="card mb-4">
                {{Form::model($data,array('route' => array('app-setting.update', $data->id), 'method' => 'PUT','enctype'=>'multipart/form-data', 'files'=>true)) }}
                <input type="hidden" name="old_app_logo" value="{{ $data->app_logo }}">
                <div class="card-body">
                      <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img
                          src="{{url('/')}}/{{$data->app_logo}}"
                          alt="user-avatar"
                          class="d-block w-px-100 h-px-100 rounded"
                          id="uploadedAvatar" />
                        <div class="button-wrapper">
                          <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                            <span class="d-none d-sm-block">Upload new logo</span>
                            <i class="ti ti-upload d-block d-sm-none"></i>
                            <input
                              type="file"
                              id="upload"
                              name="app_logo"
                              class="account-file-input"
                              hidden
                              accept="image/png, image/jpeg" required />
                          </label>
                          <button type="button" class="btn btn-label-secondary account-image-reset mb-3">
                            <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Reset</span>
                          </button>

                          <div class="text-muted">Allowed JPG, GIF or PNG. Max size of 800K</div>
                        </div>
                      </div>
                </div>
                <hr class="my-0" />
                <div class="card-body table-border-style">
                     
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                {{ Form::label('app_name', __('App Name'), ['class' => 'form-label']) }}
                                {{ Form::text('app_name', null, ['class' => 'form-control', 'placeholder' => __('App Name'), 'required' => 'required']) }}
                                @error('app_name')
                                    <small class="invalid-name" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                {{ Form::label('email', __('Email'), ['class' => 'form-label']) }}
                                {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => __('User Email'), 'required' => 'required']) }}
                                @error('email')
                                    <small class="invalid-email" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                        </div>
                    

                        <div class="col-md-6">
                            <div class="mb-3">
                                {{ Form::label('mobile_no', __('Mobile / Contact Number'), ['class' => 'form-label']) }}
                                {{ Form::text('mobile_no', null, ['class' => 'form-control', 'placeholder' => __('Contact No'),'required' => 'required']) }}
                                @error('mobile_no')
                                    <small class="invalid-email" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="mb-3">
                                {{ Form::label('description', __('Description'), ['class' => 'form-label']) }}
                                {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __('Description'),'rows'=>3]) }}
                              
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                {{ Form::label('address', __('Postal Address'), ['class' => 'form-label']) }}
                                {{ Form::textarea('address', null, ['class' => 'form-control', 'placeholder' => __('Postal Address'),'rows'=>3]) }}
                              
                            </div>
                        </div>
                         <div class="col-md-6">
                            <div class="mb-3">
                                {{ Form::label('Zipcode', __('Zipcode'), ['class' => 'form-label']) }}
                                {{ Form::text('Zipcode', null, ['class' => 'form-control','id'=>'zipCode', 'placeholder' => __(' Zipcode')]) }}
                                @error('Zipcode')
                                    <small class="invalid-email" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                        </div>
                       
                         <div class="col-md-6">
                            <div class="mb-3">
                                {{ Form::label('website_url', __('Website url'), ['class' => 'form-label']) }}
                                {{ Form::text('website_url', null, ['class' => 'form-control', 'placeholder' => __('Website Url')]) }}
                                
                            </div>
                        </div>
                        
                        <div class="pt-4">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light">Update</button>
                            
                        </div>
       
                    </div>
                  
                </div>
                  {{Form::close()}}
            </div>
        </div>
    </div>
@endsection
@section('extrajs')     

 <script src="{{ asset('assets/js/pages-account-settings-account.js') }}"></script>
 @endsection