@extends('supervisor.layouts.index')

@section('content-header-title','ТТ')
@section('content-header-right')
    {{--    <a href="{{route('supervisor.store.create')}}" class="btn btn-info btn-sm  ">создать</a>--}}
@endsection
@section('content')
    <livewire:supervisor.store-index/>
@endsection
