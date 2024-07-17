@extends('admin.layouts.index')

@section('content-header-title','Пользователи')
@section('content-header-right')
    @if(Auth::user()->permissionExists('user_create'))
        <a href="{{route('admin.user.create',1)}}" class="btn btn-warning btn-sm">создать торговый</a>
        <a href="{{route('admin.user.create',2)}}" class="btn btn-warning btn-sm">создать экспедитор</a>
        <a href="{{route('admin.user.create',10)}}" class="btn btn-warning btn-sm">создать водитель</a>
        <a href="{{route('admin.user.create',3)}}" class="btn btn-danger btn-sm">создать админ</a>
        <a href="{{route('admin.user.create',4)}}" class="btn btn-info btn-sm">кассир</a>
        <a href="{{route('admin.user.create',5)}}" class="btn btn-success btn-sm">бухгалтер</a>
        <a href="{{route('admin.user.create',7)}}" class="btn btn-primary btn-sm">диспетчер</a>
        <a href="{{route('admin.user.create',8)}}" class="btn btn-dark btn-sm">супервайзер</a>
    @endif
@endsection
@section('content')

    <livewire:user-index/>
@endsection
