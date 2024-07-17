@extends('admin.layouts.index')

@section('content-header-title','Заявки')
@section('content-header-right')
    {{--    <a href="{{route('admin.order.edi-parse')}}" target="_blank" class="btn btn-info btn-sm  ">ediParse</a>--}}
    @if(Auth::id() == 1)
        <a href="{{route('admin.order.to-onec')}}" class="btn btn-info btn-sm  ">Отправить на 1С</a>
    @endif
@endsection
@section('content')
    @livewire('order-index',['driverId' => $driver_id,'salesrepId' => $salesrep_id,'storeId' => $store_id,'counteragentId'=> $counteragent_id])
@endsection
