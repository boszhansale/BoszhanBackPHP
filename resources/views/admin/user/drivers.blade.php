@extends('admin.layouts.index')

@section('content-header-title','экспедиторы')
@section('content-header-right')
    <a href="{{route('admin.user.create',2)}}" class="btn btn-info btn-sm">создать экспедитор</a>
@endsection
@section('content')

    <livewire:driver-index/>
@endsection
