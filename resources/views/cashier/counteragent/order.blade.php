@extends('cashier.layouts.index')

@section('content-header-title')
   Контрагент: <a href="{{route('cashier.show',$counteragent->id)}}">{{$counteragent->name}}</a>
@endsection

@section('content')
    @livewire('cashier.counteragent-order-index', ['counteragent_id' => $counteragent->id])
@endsection

