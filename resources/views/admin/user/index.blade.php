@extends('admin.layouts.index')

@section('content-header-title','Пользователи')
@section('content-header-right')
    <a href="{{route('admin.user.create',1)}}" class="btn btn-info btn-sm  ">создать торговый</a>
    <a href="{{route('admin.user.create',2)}}" class="btn btn-info btn-sm  ">создать водитель</a>
@endsection
@section('content')

    <livewire:user-index />
@endsection
