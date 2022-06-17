@extends('admin.layouts.index')

@section('content-header-title','План групп')
@section('content-header-right')
    <a href="{{route('admin.plan-group.create')}}" class="btn btn-info btn-sm">создать</a>
@endsection
@section('content')

    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Группа</th>
            <th>план</th>
            <th>выполнено</th>
            <th>выполнено %</th>
            <th>в группе</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($planGroups as $planGroup)
            <tr>
                <th>{{$planGroup->id}}</th>
                <th>
                    {{$planGroup->name}}
                </th>

                <th>
                    {{$planGroup->plan}}
                </th>

                <th>
                    {{$planGroup->completed}}
                </th>
                <th>
                    {{round($planGroup->completed / $planGroup->plan * 100 ,1)}}%
                </th>
                <th>
                    {{$planGroup->planGroupUser()->count()}}
                </th>

                <td class="project-actions text-right">
                    <a class="btn btn-info btn-sm" href="{{route('admin.plan-group.edit',$planGroup->id)}}">
                        <i class="fas fa-pencil-alt">
                        </i>
                        изменить
                    </a>
                  @if($planGroup->id != 1)
                        <a  class="btn btn-danger btn-sm" href="{{route('admin.plan-group.delete',$planGroup->id)}}" onclick="return confirm('Удалить?')">
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
