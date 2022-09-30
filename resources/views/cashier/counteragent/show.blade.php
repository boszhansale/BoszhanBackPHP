@extends('cashier.layouts.index')

@section('content-header-title',$counteragent->name)

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body ">
                    <table class="table table-bordered">
                        <tr>
                            <td>id_1c</td>
                            <td>{{$counteragent->id_1c}}</td>
                        </tr>
                        <tr>
                            <td>bin</td>
                            <td>{{$counteragent->bin}}</td>
                        </tr>
                        <tr>
                            <td>тип оплаты</td>
                            <td>{{$counteragent->paymentType->name}}</td>
                        </tr>
                        <tr>
                            <td>категория цен</td>
                            <td>{{$counteragent->pricetype->name}}</td>
                        </tr>
                        <tr>
                            <td>скидка</td>
                            <td>{{$counteragent->discount}}</td>
                        </tr>
                        <tr>
                            <td>активность</td>
                            <td>{{$counteragent->enabled}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body ">
                    <table class="table table-bordered">
                        <tr>
                            <td>долг</td>
                            <td class="price">{{$counteragent->debt()}}</td>
                        </tr>
                        <tr>
                            <td>количество ТТ</td>
                            <td>{{$counteragent->stores()->count()}}</td>
                        </tr>
                        <tr>
                            <td>количество заявок</td>
                            <td>
                                <a href="{{route('cashier.order',$counteragent->id)}}">{{$counteragent->orders()->count()}}</a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
