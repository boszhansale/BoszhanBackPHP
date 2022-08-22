@extends('admin.layouts.index')

@section('content-header-title','Торговые')
@section('content-header-right')
    <a href="{{route('admin.user.create',1)}}" class="btn btn-info btn-sm  ">создать торговый</a>
@endsection
@section('content')
    <livewire:salesrep-index/>
@endsection
