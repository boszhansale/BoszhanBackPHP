@extends('admin.layouts.index')

@section('content-header-title','Возврат')
@section('content')
    @livewire('refund-index',['salesrepId' => $salesrep_id,'storeId' => $store_id,'counteragentId'=> $counteragent_id])
@endsection
