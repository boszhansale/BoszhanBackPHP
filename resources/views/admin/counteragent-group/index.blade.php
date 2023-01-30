@extends('admin.layouts.index')

@section('content-header-title','Контрагенты')
@section('content-header-right')
    <a href="{{route('admin.counteragent-group.create')}}" class="btn btn-info btn-sm">создать</a>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>название</th>
                    <th>количество</th>
                    <th></th>

                </tr>
                </thead>
                <tbody>
                @foreach($counteragentGroups as $counteragentGroup)
                    <tr>
                        <th>{{$counteragentGroup->id}}</th>


                        <th>
                            {{$counteragentGroup->name}}
                        </th>
                        <td>
                            {{$counteragentGroup->counteragents()->count()}}
                        </td>
                        <td class="project-actions text-right">
                            <a class="btn btn-info btn-sm"
                               href="{{route('admin.counteragent-group.edit',$counteragentGroup->id)}}">
                                <i class="fas fa-pencil-alt">
                                </i>
                            </a>
                            <a class="btn btn-danger btn-sm"
                               href="{{route('admin.counteragent-group.delete',$counteragentGroup->id)}}"
                               onclick="return confirm('Are you sure?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection
