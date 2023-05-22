@extends('admin.layouts.index')

@section('content-header-title','ТТ')
@section('content-header-right')
    <a href="{{route('admin.store.create')}}" class="btn btn-info btn-sm  ">создать</a>
@endsection
@section('content')
    @livewire('store-index',['driverId' => $driver_id,'salesrepId' => $salesrep_id,'counteragentId' => $counteragent_id])
@endsection
