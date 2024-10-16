@extends('layouts.master')
@section('page-title')
    {{ __('Contract Document') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('users.index')}}">{{__('Lease Management')}}</a></li>
    <li class="breadcrumb-item">{{__('Contract Document')}}</li>
@endsection
@section('content')

<div class="card">
  <div class="card-header border-bottom">
    <h5 class="card-title mb-3"></h5>
    
      
    </div> 
  </div>
  
</div>
@endsection
@section('extrajs')     
 

</script>
@endsection