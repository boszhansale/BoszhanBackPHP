@extends('admin.layouts.index')

@section('content-header-title','Роли')
@section('content-header-right')
    <a href="{{route('admin.role.create')}}" class="btn btn-info btn-sm">создать</a>
@endsection
@section('content')

    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>роль</th>
                    <th>описание</th>
                    <th>кол. пользователей</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($roles as $role)
                    <tr>
                        <th>{{$role->id}}</th>
                        <th>
                            {{$role->name}}
                        </th>

                        <th>
                            {{$role->description}}
                        </th>
                        <th>
                            {{$role->users()->count()}}
                        </th>

                        <td class="project-actions text-right">
                            <a class="btn btn-info btn-sm" href="{{route('admin.role.edit',$role->id)}}">
                                <i class="fas fa-pencil-alt">
                                </i>
                            </a>
{{--                            <a  class="btn btn-danger btn-sm" href="{{route('admin.role.delete',$role->id)}}" onclick="return confirm('Удалить?')">--}}
{{--                                <i class="fas fa-trash"></i>--}}
{{--                            </a>--}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
