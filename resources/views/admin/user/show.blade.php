@extends('admin.layouts.index')

@section('content-header-title')
    <a href="{{route('admin.user.show',$user->id)}}">{{$user->name}}</a>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            @if(Auth::user()->permissionExists('user_edit'))
                <a href="{{route('admin.user.edit',$user->id)}}" class="btn btn-warning">изменить</a>
            @endif
            @if(Auth::user()->permissionExists('user_delete'))
                <a class="btn btn-danger" href="{{route('admin.user.delete',$user->id)}}"
                   onclick="return confirm('Удалить?')">
                    удалит
                </a>
            @endif
            @if($user->isSalesrep())
                <a href="{{route('admin.order.index',['salesrep_id' => $user->id])}}" class="btn btn-primary">заявки</a>
                <a href="{{route('admin.store.index',['salesrep_id' => $user->id])}}" class="btn btn-primary">торговые
                    точки</a>
                <a href="{{route('admin.store.position',$user->id)}}" class="btn btn-primary"> торговые точки на
                    карте</a>
            @endif

            @if($user->isDriver())
                <a href="{{route('admin.order.index',['driver_id' => $user->id])}}" class="btn btn-primary">заявки</a>
                <a href="{{route('admin.store.index',['driver_id' => $user->id])}}" class="btn btn-primary">торговые
                    точки</a>
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
                                    <a href="{{route('admin.user.position',$user->id)}}">
                                        {{$user->userPositions()->latest()->first()->created_at}}
                                    </a>
                                @else
                                    нету данных
                                @endif
                            </td>
                        </tr>
                      
                        <th>количество ТТ</th>
                        <td>{{$user->stores()->count()}}</td>
                    </table>
                </div>
            </div>
        </div>
        @if($user->isDriver())
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="areaChart"
                                    style="height: 340px; max-height: 450px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        @endif
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


@section('js')
    <script>
        var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
        new Chart(areaChartCanvas, {
            type: 'line',
            data: {
                labels: @js($hours),
                datasets: [
                    {
                        label: 'доставлено',
                        fill: false,
                        borderColor: "#3cba9f",
                        data: @js($hourOrders)
                    }
                ]
            },
            options: {
                maintainAspectRatio: true,
                responsive: true,
                legend: {
                    display: true
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: true,
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            display: true,
                        }
                    }]
                }
            }
        })
    </script>
@endsection

