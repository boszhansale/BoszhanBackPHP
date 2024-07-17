@extends('admin.layouts.index')

@section('content-header-title','экспедиторы')
@section('content-header-right')
    @if(Auth::user()->permissionExists('user_create'))
        <a href="{{route('admin.user.create',2)}}" class="btn btn-info btn-sm">создать экспедитор</a>
    @endif
@endsection
@section('content')

    <livewire:driver-index/>
@endsection
