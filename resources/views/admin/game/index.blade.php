@extends('admin.layouts.index')

@section('content-header-title','Игры')
@section('content-header-right')
@endsection
@section('content')
    @livewire('game-index')
@endsection
