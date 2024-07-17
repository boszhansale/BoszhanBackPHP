@extends('admin.layouts.index')

@section('content-header-title','ТТ')
@section('content-header-right')
    @if(Auth::user()->permissionExists('store_create'))
        <a href="{{route('admin.store.create')}}" class="btn btn-info btn-sm  ">создать</a>
    @endif
@endsection
@section('content')
    @livewire('store-index',['driverId' => $driver_id,'salesrepId' => $salesrep_id,'counteragentId' => $counteragent_id])
@endsection
