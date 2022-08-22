@extends('admin.layouts.index')

@section('content-header-title','Водитель')
@section('content-header-right')
    <a href="{{route('admin.user.create',2)}}" class="btn btn-info btn-sm">создать водитель</a>
@endsection
@section('content')

    <livewire:driver-index />
@endsection
