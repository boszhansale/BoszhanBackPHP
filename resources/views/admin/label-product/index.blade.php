@extends('cashier.layouts.index')

@section('content-header-title','Продукты')
@section('content-header-right')
    <a href="{{route('cashier.label-product.create')}}" class="btn btn-info btn-sm  ">создать</a>
@endsection
@section('content')
    @livewire('label-product-index')
@endsection
