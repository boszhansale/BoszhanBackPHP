@extends('supervisor.layouts.index')

@section('content-header-title')
    <a href="{{route('admin.user.show',$user->id)}}">{{$user->name}}</a>
@endsection

@section('content')
    @livewire('supervisor.user-order-index', ['user' => $user,'role' => $role])

@endsection

