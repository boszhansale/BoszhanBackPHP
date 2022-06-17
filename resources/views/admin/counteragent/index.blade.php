@extends('admin.layouts.index')

@section('content-header-title','Контрагенты')
@section('content-header-right')
    <a href="{{route('admin.counteragent.create')}}" class="btn btn-info btn-sm">создать</a>
@endsection
@section('content')
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>название</th>
            <th>id_1c</th>
            <th>БИН</th>
            <th>тип оплаты</th>
            <th>цена</th>
            <th>скидка</th>
            <th>активность</th>
        </tr>
        </thead>
        <tbody>
        @foreach($counteragents as $counteragent)
            <tr>
                <th>{{$counteragent->id}}</th>
                <th>{{$counteragent->name}}</th>
                <th>{{$counteragent->id_1c}}</th>
                <th>{{$counteragent->bin}}</th>
                <th>{{$counteragent->paymentType->name}}</th>
                <th>{{$counteragent->priceType->name}}</th>
                <th>{{$counteragent->discount}}</th>
                <th>{{$counteragent->enabled}}</th>

                <td class="project-actions text-right">
                    <a class="btn btn-info btn-sm" href="{{route('admin.counteragent.edit',$counteragent->id)}}">
                        <i class="fas fa-pencil-alt">
                        </i>
                        изменить
                    </a>
                    <a  class="btn btn-danger btn-sm" href="{{route('admin.counteragent.delete',$counteragent->id)}}" onclick="return confirm('Are you sure?')">
                        <i class="fas fa-trash"></i>
                        удалить
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
