<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                    <input wire:model="search" type="search" name="search" placeholder="поиск" class="form-control">
                </div>
                <div class="col-md-1">
                    <select wire:model="status_id" class="form-control">
                        <option value="">Все статусы</option>
                        @foreach($statuses as $status)
                            <option value="{{$status->id}}">{{$status->description}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select wire:model="salesrep_id" class="form-control">
                        <option value="">все торговые</option>
                        @foreach($salesreps as $salesrep)
                            <option value="{{$salesrep->id}}">{{$salesrep->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select wire:model="driver_id" class="form-control">
                        <option value="">все водители</option>
                        @foreach($drivers as $driver)
                            <option value="{{$driver->id}}">{{$driver->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input wire:model="start_date" type="date" required class="form-control">
                    <input wire:model="end_date" type="date" required class="form-control">
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="row justify-content-between">
                <div class="col">
                    <div class="btn btn-info">Кол. заявок: <b>{{$order_count}}</b></div>
                </div>
                <div class="col">
                    <div class="btn btn-info">
                        Сумма заявок: <b class="price">{{(int)$order_purchase_price}}</b> тг
                    </div>
                </div>
                <div class="col">
                    <div class="btn btn-warning">
                        Кол. возврат: <b>{{(int)$order_return_count}}</b>
                    </div>
                </div>
                <div class="col">
                    <div class="btn btn-warning">
                        Сумма возврат : <b class="price">{{(int)$order_return_price}}</b> тг
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover text-nowrap table-responsive">
                <thead>
                <tr>
                    <th>ID</th>
                    <th></th>
                    <th>Контрагент</th>
                    <th>Контрагент(BIN)</th>
                    <th>ТТ</th>
                    <th>Статус</th>
                    <th>Торговый</th>
                    <th>Водитель</th>
                    <th>сумма</th>
                    <th>возврат</th>
                    <th>процент Возврат</th>
                    <th>Дата создание</th>
                    <th>Дата доставки</th>
                    <th>Дата закрытие</th>
                    <th>тип оплаты</th>
                    <th>статус оплаты</th>
                    <th>версия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr class="{{$order->removed_at != null ?'bg-red':''}}">
                        <td>{{$order->id}}</td>
                        <td class="project-actions text-right">
                            <a class="btn btn-primary btn-sm" href="{{route('admin.order.show',$order->id)}}">
                                <i class="fas fa-folder">
                                </i>

                            </a>
                            <a class="btn btn-info btn-sm" href="{{route('admin.order.edit',$order->id)}}">
                                <i class="fas fa-pencil-alt">
                                </i>

                            </a>
                            @if($order->removed_at != null  AND  in_array(Auth::id(),[1,153]))
                                <a class="btn btn-warning btn-sm" href="{{route('admin.order.recover',$order->id)}}"
                                   onclick="return confirm('уверен?')">
                                    <i class="fas fa-eraser"></i>
                                </a>

                            @endif
                            @if(in_array(Auth::id(),[1,153]))
                                <a class="btn btn-danger btn-sm" href="{{route('admin.order.delete',$order->id)}}"
                                   onclick="return confirm('Удалить?')">
                                    <i class="fas fa-trash"></i>
                                </a>

                            @else
                                <a class="btn btn-danger btn-sm" href="{{route('admin.order.remove',$order->id)}}"
                                   onclick="return confirm('Удалить?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            @endif
                            <a class="btn btn-info btn-sm" href="{{route('admin.order.export-excel',$order->id)}}">
                                <i class="fas fa-download">
                                </i>
                            </a>

                        </td>
                        <td>
                            @if($order->store?->counteragent_id)
                                <a href="{{route('admin.counteragent.show',$order->store->counteragent_id)}}">{{$order->store->counteragent->name}}</a>
                            @endif
                        </td>
                        <td>
                            @if($order->store?->counteragent_id)
                                {{$order->store?->counteragent?->bin}}
                            @endif
                        </td>
                        <td><a href="{{route('admin.store.show',$order->store_id)}}">{{$order->store?->name}}</a></td>
                        <td>{{$order->status->description}}</td>
                        <td><a href="{{route('admin.user.show',$order->salesrep_id)}}">{{$order->salesrep->name}}</a>
                        </td>
                        <td><a href="{{route('admin.user.show',$order->driver_id)}}">{{$order->driver->name}}</a></td>
                        <td class="price">{{$order->purchase_price}}</td>
                        <td class="price">{{$order->return_price}}</td>
                        @if($order->return_price > 0)
                            @if(($order->return_price / $order->purchase_price)*100 >= 60 )
                                <th style="color: red">{{ round(($order->return_price / $order->purchase_price)*100)  }}
                                    %
                                </th>
                            @else
                                <th>{{ round(($order->return_price / $order->purchase_price)*100)  }}%</th>
                            @endif

                        @else
                            <td>0%</td>
                        @endif
                        <td>{{$order->created_at}}</td>
                        <td>{{$order->delivery_date}}</td>
                        <td>{{$order->delivered_date}}</td>
                        <td>{{$order->paymentType->name}}</td>
                        <td>{{$order->paymentStatus->name}}</td>
                        <td>{{$order->salesrep_mobile_app_version}}</td>

                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
    {{$orders->links()}}
</div>
