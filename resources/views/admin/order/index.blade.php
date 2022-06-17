@extends('admin.layouts.index')

@section('content-header-title','Заявки')
{{--@section('content-header-right')--}}
{{--    <a href="{{route('admin.order.create')}}" class="btn btn-info btn-sm  ">создать</a>--}}
{{--@endsection--}}
@section('content')
    <livewire:order-index />
@endsection
