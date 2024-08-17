@extends('layouts.master')

@section('page-title')
    {{ __('Manage Permissions') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Role & Permissions')}}</a></li>
    <li class="breadcrumb-item">{{__('Permissions')}}</li>
@endsection


@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
               
                <div class="card-body">
                    <div class="card-body p-0">
                        <div id="table-1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                            <div class="table-responsive">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-flush" id="dataTable">
                                            <thead>
                                                <tr>
                                                        <th> {{__('Permissions')}}</th>
                                                        <th class="text-end" width="200px"> {{__('Action')}}</th>
                                                    </tr>
                                            </thead>

                                            <tbody>
                                                    @foreach ($permissions as $permission)
                                                        <tr>
                                                            <td>{{ $permission->se_name }}</td>

                                                            <td class="action">
                                                                  <div class="btn-group btn-group-xs">
                                                                    <a href="#"
                                                                        class="btn btn-sm btn-primary d-inline-flex align-items-center"
                                                                        data-url="{{ route('permissions.edit', $permission->id) }}"
                                                                        data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                                        title="{{ __('Edit') }}"
                                                                        data-title="{{ __('Edit Permissions') }}">
                                                                        <i class="ti ti-pencil text-white"></i>
                                                                    </a>
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

@endsection
