@extends('supervisor.layouts.index')

@section('content-header-title')
    <a href="{{route('supervisor.user.show',$user->id)}}">{{$user->name}}</a>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            @if($user->isSalesrep())
                <a href="{{route('supervisor.user.order',[$user->id,1])}}" class="btn btn-primary">заявки торгового</a>
            @endif
        </div>
    </div>
    <hr>
    <br>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>ID</th>
                            <td>{{$user->id}}</td>
                        </tr>
                        <tr>
                            <th>Логин</th>
                            <td>{{$user->login}}</td>
                        </tr>
                        <tr>
                            <th>Телефон номер</th>
                            <td>{{$user->phone}}</td>
                        </tr>
                        <tr>
                            <th>id_1c</th>
                            <td>{{$user->id_1c}}</td>
                        </tr>
                        <tr>
                            <th>Роль</th>
                            <td>
                                {{$user->role->description}}
                            </td>
                        </tr>
                        <tr>
                            <th>последний GPS</th>
                            <td>
                                @if($user->userPositions()->exists())
                                    <a href="{{route('supervisor.user.position',$user->id)}}">
                                        {{$user->userPositions()->latest()->first()->created_at}}
                                    </a>
                                @else
                                    нету данных
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        @if($user->isSalesrep())
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>личный план</th>
                                <td class="price">{{$user->planGroupUser->plan}}</td>
                            </tr>
                            <tr>
                                <th>выполнено</th>
                                <td class="price">{{$user->planGroupUser->completed}}</td>
                            </tr>
                            <tr>
                                <th>позиция</th>
                                <td>{{$user->planGroupUser->position}}</td>
                            </tr>

                            @foreach($user->brandPlans as $brandPlan)
                                <tr>
                                    <th>{{$brandPlan->brand->name}} <span class="price">{{$brandPlan->plan}}</span></th>
                                    <td class="price">{{$brandPlan->completed}} </td>
                                </tr>
                            @endforeach

                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Группа</th>
                                <td>{{$user->planGroupUser->planGroup->name}}</td>
                            </tr>
                            <tr>
                                <th>план</th>
                                <td class="price">{{$user->planGroupUser->planGroup->plan}}</td>
                            </tr>
                            <tr>
                                <th>выполнено</th>
                                <td class="price">{{$user->planGroupUser->planGroup->completed}}</td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="row">
        @if($user->isSalesrep())
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Количество заявок</th>
                                <td>{{$user->salesrepOrders()->count()}}</td>
                            </tr>
                            <tr>
                                <th>Количество заявок за сегодня</th>
                                <td>{{$user->salesrepOrders()->whereDate('created_at',today())->count()}}</td>
                            </tr>
                            <tr>
                                <th>Количество заявок за неделю</th>
                                <td>{{$user->salesrepOrders()->whereDate('created_at','>=',now()->startOfWeek())->count()}}</td>
                            </tr>
                            <tr>
                                <th>Количество заявок за месец</th>
                                <td>{{$user->salesrepOrders()->whereDate('created_at','>=',now()->startOfMonth())->count()}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered">
                            @foreach(\App\Models\Status::all() as $status)
                                <tr>
                                    <td>Количество {{$status->description}}</td>
                                    <td>{{$user->salesrepOrders()->where('orders.status_id',$status->id)->count()}}</td>
                                </tr>
                            @endforeach

                        </table>
                    </div>
                </div>
            </div>
        @endif
        @if($user->isDriver())
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Количество заявок</th>
                                <td>{{$user->driverOrders()->count()}}</td>
                            </tr>
                            <tr>
                                <th>Количество заявок за сегодня</th>
                                <td>{{$user->driverOrders()->whereDate('created_at',today())->count()}}</td>
                            </tr>
                            <tr>
                                <th>Количество заявок за неделю</th>
                                <td>{{$user->driverOrders()->whereDate('created_at','>=',now()->startOfWeek())->count()}}</td>
                            </tr>
                            <tr>
                                <th>Количество заявок за месец</th>
                                <td>{{$user->driverOrders()->whereDate('created_at','>=',now()->startOfMonth())->count()}}</td>
                            </tr>

                            @foreach($user->salesreps as $salesrep)
                                <tr>
                                    <td>Кол. заявок <b><a
                                                href="{{route('admin.user.show',$salesrep->id)}}">{{$salesrep->name}}</a></b>
                                    </td>
                                    <td>{{$salesrep->salesrepOrders()->where('driver_id',$user->id)->count()}}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered">
                            @foreach(\App\Models\Status::all() as $status)
                                <tr>
                                    <td>Количество {{$status->description}}</td>
                                    <td>{{$user->driverOrders()->where('orders.status_id',$status->id)->count()}}</td>
                                </tr>
                            @endforeach

                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection


