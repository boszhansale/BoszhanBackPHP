@extends('admin.layouts.index')

@section('content-header-title','Бренды')
@section('content-header-right')
    <a href="{{route('admin.brand.create')}}" class="btn btn-info btn-sm  ">создать</a>
@endsection
@section('content')

    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Бренд</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($brands as $brand)
            <tr>
                <th>{{$brand->id}}</th>
                <th>
                    {{$brand->name}}
                </th>

                <td class="project-actions text-right">
                    <a class="btn btn-primary btn-sm" href="{{route('admin.category.index',$brand->id)}}">
                        <i class="fas fa-folder">
                        </i>
                        Категории
                    </a>
                    <a class="btn btn-info btn-sm" href="{{route('admin.brand.edit',$brand->id)}}">
                        <i class="fas fa-pencil-alt">
                        </i>
                        изменить
                    </a>
                    <a  class="btn btn-danger btn-sm" href="{{route('admin.brand.delete',$brand->id)}}" onclick="return confirm('Удалить?')">
                        <i class="fas fa-trash"></i>
                        удалить
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
