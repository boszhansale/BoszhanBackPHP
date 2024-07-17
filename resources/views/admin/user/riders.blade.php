@extends('admin.layouts.index')

@section('content-header-title','водители')
@section('content-header-right')
    @if(Auth::user()->permissionExists('user_create'))
        <a href="{{route('admin.user.create',10)}}" class="btn btn-info btn-sm">создать водитель</a>
    @endif
@endsection
@section('content')

    <livewire:rider-index/>
@endsection
