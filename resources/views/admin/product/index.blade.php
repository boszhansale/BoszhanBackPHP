@extends('admin.layouts.index')

@section('content-header-title','Продукты')
@section('content-header-right')
    @if(Auth::user()->permissionExists('product_create'))
        <a href="{{route('admin.product.create')}}" class="btn btn-info btn-sm  ">создать</a>
        <a href="{{route('admin.product.priceParse')}}" class="btn btn-info btn-sm ">импорт цены</a>
    @endif
@endsection
@section('content')
    <livewire:product-index/>
@endsection
