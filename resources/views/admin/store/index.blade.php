@extends('admin.layouts.index')

@section('content-header-title','ТТ')
@section('content-header-right')
    <a href="{{route('admin.store.create')}}" class="btn btn-info btn-sm  ">создать</a>
@endsection
@section('content')

    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Название</th>
            <th>Телефон</th>
            <th>ТП</th>
            <th>Контрагент</th>
            <th>БИН</th>
            <th>id_1c</th>
            <th>скидка %</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($stores as $store)
            <tr>
                <th>{{$store->id}}</th>
                <th>
                    <b>{{$store->name}}</b><br>
                    <small>{{$store->address}}</small>
                </th>
                <td>
                    {{$store->phone}}
                </td>
                <td>
                    {{$store->salesrep->name}}
                </td>
                <td>
                    {{$store->counteragent?->name}}
                </td>

                <td>
                    {{$store->bin}}
                </td>
                <td>
                    {{$store->id_1c}}
                </td>

                <td>
                    {{$store->discount}}
                </td>


                <td class="project-actions text-right">
                    <a class="btn btn-primary btn-sm" href="{{route('admin.store.show',$store->id)}}">
                        <i class="fas fa-folder">
                        </i>
                    </a>
                    <a class="btn btn-info btn-sm" href="{{route('admin.store.edit',$store->id)}}">
                        <i class="fas fa-pencil-alt">
                        </i>
                    </a>
                    <a  class="btn btn-danger btn-sm" href="{{route('admin.store.delete',$store->id)}}" onclick="return confirm('Удалить?')">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{$stores->links()}}
@endsection
