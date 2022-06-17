@extends('admin.layouts.index')

@section('content-header-title',$user->name)

@section('content')
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
                            <th>Роли</th>
                            <td>
                                @foreach($user->roles as $role)
                                    {{$role->description}}
                                @endforeach
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        @if($user->roles()->where('roles.id', 1)->exists())
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
        @if($user->roles()->where('roles.id', 1)->exists())
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Количество заявок</th>
                                <td>{{$user->salesrepOrders()->count()}}</td>
                            </tr>
                            <tr>
                                <th>Количество заявок за сегодня </th>
                                <td>{{$user->salesrepOrders()->whereDate('created_at',today())->count()}}</td>
                            </tr>
                            <tr>
                                <th>Количество заявок за неделю </th>
                                <td>{{$user->salesrepOrders()->whereDate('created_at','>=',now()->startOfWeek())->count()}}</td>
                            </tr>
                            <tr>
                                <th>Количество заявок за месец </th>
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover text-nowrap table-responsive">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th></th>
                                <th>Контрагент</th>
                                <th>ТТ</th>
                                <th>Статус</th>
                                <th>Торговый</th>
                                <th>Водитель</th>
                                <th>сумма</th>
                                <th>возврат</th>
                                <th>Дата создание</th>
                                <th>Дата доставки</th>
                                <th>тип оплаты</th>
                                <th>статус оплаты</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($salesrepOrders as $order)
                                <tr>
                                    <td>{{$order->id}}</td>
                                    <td  class="project-actions text-right">
                                        <a class="btn btn-primary btn-sm" href="{{route('admin.order.show',$order->id)}}">
                                            <i class="fas fa-folder">
                                            </i>

                                        </a>
                                        <a class="btn btn-info btn-sm" href="{{route('admin.order.edit',$order->id)}}">
                                            <i class="fas fa-pencil-alt">
                                            </i>

                                        </a>
                                        <a  class="btn btn-danger btn-sm" href="{{route('admin.order.delete',$order->id)}}" onclick="return confirm('Удалить?')">
                                            <i class="fas fa-trash"></i>

                                        </a>
                                    </td>
                                    <td>
                                        @if($order->store->counteragent)
                                            <a href="{{route('admin.counteragent.show',$order->store->counteragent_id)}}">{{$order->store->counteragent->name}}</a>
                                        @endif
                                    </td>
                                    <td><a href="{{route('admin.store.show',$order->store_id)}}">{{$order->store->name}}</a></td>
                                    <td>{{$order->status->description}}</td>
                                    <td><a href="{{route('admin.user.show',$order->salesrep_id)}}">{{$order->salesrep->name}}</a></td>
                                    <td><a href="{{route('admin.user.show',$order->driver_id)}}">{{$order->driver->name}}</a></td>
                                    <td class="price">{{$order->purchase_price}}</td>
                                    <td class="price">{{$order->return_price}}</td>
                                    <td>{{$order->created_at}}</td>
                                    <td>{{$order->delivery_date}}</td>
                                    <td>{{$order->paymentType->name}}</td>
                                    <td>{{$order->paymentStatus->name}}</td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        {{$salesrepOrders->links()}}
                    </div>
                </div>
            </div>
        @endif
        @if($user->roles()->where('roles.id', 2)->exists())
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Количество заявок</th>
                                <td>{{$user->driverOrders()->count()}}</td>
                            </tr>
                            <tr>
                                <th>Количество заявок за сегодня </th>
                                <td>{{$user->driverOrders()->whereDate('created_at',today())->count()}}</td>
                            </tr>
                            <tr>
                                <th>Количество заявок за неделю </th>
                                <td>{{$user->driverOrders()->whereDate('created_at','>=',now()->startOfWeek())->count()}}</td>
                            </tr>
                            <tr>
                                <th>Количество заявок за месец </th>
                                <td>{{$user->driverOrders()->whereDate('created_at','>=',now()->startOfMonth())->count()}}</td>
                            </tr>

                            @foreach($user->salesreps as $salesrep)
                                <tr>
                                    <td>Кол. заявок  <b><a href="{{route('admin.user.show',$salesrep->id)}}">{{$salesrep->name}}</a></b></td>
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover text-nowrap table-responsive">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th></th>
                                <th>Контрагент</th>
                                <th>ТТ</th>
                                <th>Статус</th>
                                <th>Торговый</th>
                                <th>Водитель</th>
                                <th>сумма</th>
                                <th>возврат</th>
                                <th>Дата создание</th>
                                <th>Дата доставки</th>
                                <th>тип оплаты</th>
                                <th>статус оплаты</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($driverOrders as $order)
                                <tr>
                                    <td>{{$order->id}}</td>
                                    <td  class="project-actions text-right">
                                        <a class="btn btn-primary btn-sm" href="{{route('admin.order.show',$order->id)}}">
                                            <i class="fas fa-folder">
                                            </i>

                                        </a>
                                        <a class="btn btn-info btn-sm" href="{{route('admin.order.edit',$order->id)}}">
                                            <i class="fas fa-pencil-alt">
                                            </i>

                                        </a>
                                        <a  class="btn btn-danger btn-sm" href="{{route('admin.order.delete',$order->id)}}" onclick="return confirm('Удалить?')">
                                            <i class="fas fa-trash"></i>

                                        </a>
                                    </td>
                                    <td>
                                        @if($order->store->counteragent)
                                            <a href="{{route('admin.counteragent.show',$order->store->counteragent_id)}}">{{$order->store->counteragent->name}}</a>
                                        @endif
                                    </td>
                                    <td><a href="{{route('admin.store.show',$order->store_id)}}">{{$order->store->name}}</a></td>
                                    <td>{{$order->status->description}}</td>
                                    <td><a href="{{route('admin.user.show',$order->salesrep_id)}}">{{$order->salesrep->name}}</a></td>
                                    <td><a href="{{route('admin.user.show',$order->driver_id)}}">{{$order->driver->name}}</a></td>
                                    <td class="price">{{$order->purchase_price}}</td>
                                    <td class="price">{{$order->return_price}}</td>
                                    <td>{{$order->created_at}}</td>
                                    <td>{{$order->delivery_date}}</td>
                                    <td>{{$order->paymentType->name}}</td>
                                    <td>{{$order->paymentStatus->name}}</td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        {{$driverOrders->links()}}
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
