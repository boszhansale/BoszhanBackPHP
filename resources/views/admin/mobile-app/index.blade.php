@extends('admin.layouts.index')

@section('content-header-title','Мобильный версии')
@section('content-header-right')
    <a href="{{route('admin.mobile-app.create')}}" class="btn btn-info btn-sm  ">создать</a>
@endsection
@section('content')

    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Тип</th>
            <th>Версия</th>
            <th>Дата</th>
            <th>Скачать</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($mobile_apps as $mobileApp)
            <tr>
                <th>{{$mobileApp->id}}</th>
                <th>
                    {{$mobileApp->typeDescription()}}
                </th>
                <th>
                    {{$mobileApp->version}}
                </th>
                <th>
                    {{\Carbon\Carbon::parse($mobileApp->created_at)->format('d.m.Y')}}
                </th>
                <th>
                    <a target="_blank" href="{{route('admin.mobile-app.download',$mobileApp->id)}}">Скачать</a>
                </th>

                <td class="project-actions text-right">

                    <a  class="btn btn-danger btn-sm" href="{{route('admin.mobile-app.delete',$mobileApp->id)}}" onclick="return confirm('Удалить?')">
                        <i class="fas fa-trash"></i>
                        удалить
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
