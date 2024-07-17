@extends('admin.layouts.index')

@section('content-header-title','Контрагенты')
@section('content-header-right')
    {{--    <a href="{{route('admin.counteragent.import')}}" class="btn btn-info btn-sm">импорт excel</a>--}}
    @if(Auth::user()->permissionExists('counteragent_create'))
        <a href="{{route('admin.counteragent.create')}}" class="btn btn-info btn-sm">создать</a>
    @endif
@endsection
@section('content')

    @livewire('counteragent-index')

@endsection
