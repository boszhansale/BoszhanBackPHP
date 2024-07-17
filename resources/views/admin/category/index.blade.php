@extends('admin.layouts.index')

@section('content-header-title',$brand->name)
@section('content-header-right')
    @if(Auth::user()->permissionExists('category_create'))
        <a href="{{route('admin.category.create',$brand->id)}}" class="btn btn-info btn-sm">создать</a>
    @endif
@endsection
@section('content')

    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>категория</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($categories as $category)
            <tr>
                <th>{{$category->id}}</th>
                <th>
                    {{$category->name}}
                </th>

                <td class="project-actions text-right">
                    @if(Auth::user()->permissionExists('category_edit'))
                        <a class="btn btn-info btn-sm" href="{{route('admin.category.edit',$category->id)}}">
                            <i class="fas fa-pencil-alt">
                            </i>
                            изменить
                        </a>
                    @endif
                    @if(Auth::user()->permissionExists('category_delete'))
                        <a class="btn btn-danger btn-sm" href="{{route('admin.category.delete',$category->id)}}"
                           onclick="return confirm('Удалить?')">
                            <i class="fas fa-trash"></i>
                            удалить
                        </a>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
