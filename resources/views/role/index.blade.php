@extends('layouts.master')
@section('page-title')
    {{ __('Manage Role') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('roles.index')}}">{{__('Role & Permissions')}}</a></li>
    <li class="breadcrumb-item">{{__('Role')}}</li>
@endsection

@section('action-btn')
    <div class="float-end">
        @can('role-add')
            <a href="#" data-url="{{ route('roles.create') }}" data-ajax-popup="true" data-title="{{__('Create New Role')}}" data-bs-toggle="tooltip" data-size="lg" title="{{__('Create')}}"  class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
        @endcan
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('Role') }} </th>
                                    <th>{{ __('Permissions') }} </th>
                                    <th width="150">{{ __('Action') }} </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                        <tr class="font-style">
                                            <td class="Role">{{ $role->se_name }}</td>
                                            <td class="Permission">
                                                @foreach ($role->permissions()->pluck('se_name') as $permissionName)
                                                    <span
                                                        class="badge rounded p-2 m-1 px-3 bg-primary">{{ $permissionName }}</span>
                                                @endforeach
                                            </td>
                                            <td class="Action">
                                                 <div class="btn-group btn-group-xs">
                                                    @can('role-edit')
                                                        <div class="action-btn bg-info ms-2">
                                                            <a href="#"
                                                                class="btn btn-sm btn-primary d-inline-flex align-items-center"
                                                                data-url="{{ route('roles.edit', $role->id) }}"
                                                                data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip"
                                                                title="{{ __('Edit') }}"
                                                                data-title="{{ __('Edit Role') }}">
                                                                <i class="ti ti-pencil text-white"></i>
                                                            </a>
                                                        </div>
                                                    @endcan

                                                        @can('role-delete')
                                                            <div class="action-btn bg-danger ms-2">
                                                                {!! Form::open([
                                                                    'method' => 'DELETE',
                                                                    'route' => ['roles.destroy', $role->id],
                                                                    'id' => 'delete-form-' . $role->id,
                                                                ]) !!}
                                                                <a href="#"
                                                                    class="btn btn-sm btn-danger  align-items-center bs-pass-para"
                                                                    data-bs-toggle="tooltip" title="{{ __('Delete') }}"><i
                                                                        class="ti ti-trash text-white"></i></a>
                                                                {!! Form::close() !!}
                                                            </div>
                                                        @endcan
                        
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
@endsection
@section('extrajs')  


@endsection