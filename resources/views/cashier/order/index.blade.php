@extends('cashier.layouts.index')

@section('content-header-title','Заявки')
@section('content-header-right')
    <a href="{{route('cashier.order.to-onec')}}" class="btn btn-info btn-sm  ">Отправить на 1С</a>
@endsection
@section('content')
    @livewire('cashier.order-index')
@endsection
