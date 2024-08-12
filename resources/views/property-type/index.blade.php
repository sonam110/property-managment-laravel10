@extends('layouts.master')
@section('page-title')
    {{__('Property Settings')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('app-setting.index')}}">{{__('Settings')}}</a></li>
    <li class="breadcrumb-item">{{__('Propert Type')}}</li>
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
                                class="nav-link active"
                                data-bs-toggle="tab"
                                data-bs-target="#form-tabs-Property"
                                role="tab"
                                aria-selected="true">
                                Property Type
                              </button>
                            </li>
                            <li class="nav-item">
                              <button
                                class="nav-link"
                                data-bs-toggle="tab"
                                data-bs-target="#form-tabs-Utilies"
                                role="tab"
                                aria-selected="false">
                                Utilies
                              </button>
                            </li>
                            <li class="nav-item">
                              <button
                                class="nav-link"
                                data-bs-toggle="tab"
                                data-bs-target="#form-tabs-Unit"
                                role="tab"
                                aria-selected="false">
                                Unit Type
                              </button>
                            </li>
                          </ul>
                        </div>

                        <div class="tab-content">
                          <div class="tab-pane fade active show" id="form-tabs-Property" role="tabpanel">

                            @section('action-btn')
                                <div class="float-end">
                                 
                                        <a href="#" data-url="{{ route('property-type.create') }}" data-ajax-popup="true" data-title="{{__('Create Propert Type')}}" data-bs-toggle="tooltip" title="{{__('Create')}}"  class="btn btn-sm btn-primary">
                                            <i class="ti ti-plus"></i>
                                        </a>
                                   
                                </div>
                            @endsection
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
                                                <span>
                
                                                        <div class="action-btn bg-primary ms-2">

                                                        <a href="#" class="mx-3 btn btn-sm align-items-center" data-url="{{ URL::to('property-type/'.$property->id.'/edit') }}"  data-ajax-popup="true" data-title="{{__('Edit Property Type')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}"><i class="ti ti-pencil text-white"></i></a>
                                                    </div>
                                                    
                                                        <div class="action-btn bg-danger ms-2">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['property-type.destroy', $property->id],'id'=>'delete-form-'.$branch->id]) !!}

                                                        <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$property->id}}').submit();"><i class="ti ti-trash text-white text-white"></i></a>
                                                        {!! Form::close() !!}
                                                    </div>
                                                  
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                          </div>
                          <div class="tab-pane fade" id="form-tabs-Utilies" role="tabpanel">
                            <form>
                              <div class="row g-3">
                                <div class="col-md-6">
                                  <label class="form-label" for="formtabs-username">Username</label>
                                  <input type="text" id="formtabs-username" class="form-control" placeholder="john.doe" />
                                </div>
                                <div class="col-md-6">
                                  <label class="form-label" for="formtabs-email">Email</label>
                                  <div class="input-group input-group-merge">
                                    <input
                                      type="text"
                                      id="formtabs-email"
                                      class="form-control"
                                      placeholder="john.doe"
                                      aria-label="john.doe"
                                      aria-describedby="formtabs-email2" />
                                    <span class="input-group-text" id="formtabs-email2">@example.com</span>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-password-toggle">
                                    <label class="form-label" for="formtabs-password">Password</label>
                                    <div class="input-group input-group-merge">
                                      <input
                                        type="password"
                                        id="formtabs-password"
                                        class="form-control"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="formtabs-password2" />
                                      <span class="input-group-text cursor-pointer" id="formtabs-password2"
                                        ><i class="ti ti-eye-off"></i
                                      ></span>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-password-toggle">
                                    <label class="form-label" for="formtabs-confirm-password">Confirm Password</label>
                                    <div class="input-group input-group-merge">
                                      <input
                                        type="password"
                                        id="formtabs-confirm-password"
                                        class="form-control"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="formtabs-confirm-password2" />
                                      <span class="input-group-text cursor-pointer" id="formtabs-confirm-password2"
                                        ><i class="ti ti-eye-off"></i
                                      ></span>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="pt-4">
                                <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                                <button type="reset" class="btn btn-label-secondary">Cancel</button>
                              </div>
                            </form>
                          </div>
                          <div class="tab-pane fade" id="form-tabs-unit" role="tabpanel">
                            <form>
                              <div class="row g-3">
                                <div class="col-md-6">
                                  <label class="form-label" for="formtabs-twitter">Twitter</label>
                                  <input
                                    type="text"
                                    id="formtabs-twitter"
                                    class="form-control"
                                    placeholder="https://twitter.com/abc" />
                                </div>
                                <div class="col-md-6">
                                  <label class="form-label" for="formtabs-facebook">Facebook</label>
                                  <input
                                    type="text"
                                    id="formtabs-facebook"
                                    class="form-control"
                                    placeholder="https://facebook.com/abc" />
                                </div>
                                <div class="col-md-6">
                                  <label class="form-label" for="formtabs-google">Google+</label>
                                  <input
                                    type="text"
                                    id="formtabs-google"
                                    class="form-control"
                                    placeholder="https://plus.google.com/abc" />
                                </div>
                                <div class="col-md-6">
                                  <label class="form-label" for="formtabs-linkedin">Linkedin</label>
                                  <input
                                    type="text"
                                    id="formtabs-linkedin"
                                    class="form-control"
                                    placeholder="https://linkedin.com/abc" />
                                </div>
                                <div class="col-md-6">
                                  <label class="form-label" for="formtabs-instagram">Instagram</label>
                                  <input
                                    type="text"
                                    id="formtabs-instagram"
                                    class="form-control"
                                    placeholder="https://instagram.com/abc" />
                                </div>
                                <div class="col-md-6">
                                  <label class="form-label" for="formtabs-quora">Quora</label>
                                  <input
                                    type="text"
                                    id="formtabs-quora"
                                    class="form-control"
                                    placeholder="https://quora.com/abc" />
                                </div>
                              </div>
                              <div class="pt-4">
                                <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                                <button type="reset" class="btn btn-label-secondary">Cancel</button>
                              </div>
                            </form>
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
