<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                    <small>поиск</small>
                    <input wire:model="search" type="search" name="search" placeholder="поиск" class="form-control">
                </div>
                <div class="col-md-1">
                    <small>статус</small>
                    <select wire:model="statusId" class="form-control">
                        <option value="">Все статусы</option>
                        @foreach($statuses as $status)
                            <option value="{{$status->id}}">{{$status->description}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <small>торговый</small>

                    <select wire:model="salesrepId" class="form-control">
                        <option value="">все торговые</option>
                        @foreach($salesreps as $salesrep)
                            <option value="{{$salesrep->id}}">{{$salesrep->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <small>водитель</small>
                    <select wire:model="driverId" class="form-control">
                        <option value="">все водители</option>
                        @foreach($drivers as $driver)
                            <option value="{{$driver->id}}">{{$driver->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <small>даты создания заявки</small>
                    <input wire:model="start_created_at" type="date" required class="form-control">
                    <input wire:model="end_created_at" type="date" required class="form-control">
                </div>
                <div class="col-md-2">
                    <small>даты доставки</small>
                    <input wire:model="start_delivery_date" type="date" required class="form-control">
                    <input wire:model="end_delivery_date" type="date" required class="form-control">
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="row justify-content-between">
                <div class="col">
                    <h5>Общая:</h5>
                    <ul>
                        <li>кол. заявок : {{$query->clone()->count()}}</li>
                        <li>кол. закрытых : {{$query->clone()->whereNotNull('delivered_date')->count()}}</li>
                        <li>сумма заявок: <span class="price">{{$query->clone()->sum('orders.purchase_price')}}</span>
                        </li>
                        <li>кол. возврат: {{$query->clone()->where('orders.return_price', '>', 0)->count()}}</li>
                        <li>сумма. возврат: <span class="price">{{$query->clone()->sum('orders.return_price')}}</span>
                        </li>
                    </ul>
                </div>
                <div class="col">
                    <h5>Юр лицо</h5>
                    <ul>
                        <li>кол. заявок: {{$query->clone()->whereNotNull('stores.counteragent_id')->count()}}</li>
                        <li>кол. закрытых
                            : {{$query->clone()->whereNotNull('stores.counteragent_id')->whereNotNull('delivered_date')->count()}}</li>
                        <li>сумма заявок: <span
                                class="price">{{$query->clone()->whereNotNull('stores.counteragent_id')->sum('orders.purchase_price')}}</span>
                        </li>
                        <li>кол.
                            возврат: {{$query->clone()->whereNotNull('stores.counteragent_id')->where('orders.return_price', '>', 0)->count()}}</li>
                        <li>сумма. возврат: <span
                                class="price">{{$query->clone()->whereNotNull('stores.counteragent_id')->sum('orders.return_price')}}</span>
                        </li>
                    </ul>
                </div>
                <div class="col">
                    <h5>Физ лицо</h5>
                    <ul>
                        <li>кол. заявок: {{$query->clone()->whereNull('stores.counteragent_id')->count()}}</li>
                        <li>кол. закрытых
                            : {{$query->clone()->whereNull('stores.counteragent_id')->whereNotNull('delivered_date')->count()}}</li>
                        <li>сумма заявок: <span
                                class="price">{{$query->clone()->whereNull('stores.counteragent_id')->sum('orders.purchase_price')}}</span>
                        </li>
                        <li>кол.
                            возврат: {{$query->clone()->whereNull('stores.counteragent_id')->where('orders.return_price', '>', 0)->count()}}</li>
                        <li>сумма. возврат: <span
                                class="price">{{$query->clone()->whereNull('stores.counteragent_id')->sum('orders.return_price')}}</span>
                        </li>
                    </ul>
                </div>
                <div class="col">
                    <ul>
                        @if($order_return_price > 0)
                            @if(($order_return_price / $order_purchase_price)*100 >= 60 )
                                <li style="color: red">процент
                                    возврата: {{ round(($order_return_price / $order_purchase_price)*100)  }} %
                                </li>
                            @else
                                <li>процент возврата: {{ round(($order_return_price / $order_purchase_price)*100)  }}%
                                </li>
                            @endif

                        @else
                            <li>процент возврата: 0%</li>
                        @endif
                    </ul>

                </div>

            </div>
        </div>
        <form action="{{route('admin.order.many-edit')}}" method="get">
            @csrf
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
                        @if($order->deleted_at)
                            <tr class="bg-red">
                        @elseif($order->removed_at)
                            <tr class="bg-black">
                        @else
                            <tr>
                                @endif

                                <td>{{$order->id}}
                                    <input type="checkbox" name="orders[]" value="{{$order->id}}">

                                </td>
                                <td class="project-actions text-left">
                                    <a class="btn btn-primary btn-sm" href="{{route('admin.order.show',$order->id)}}">
                                        <i class="fas fa-folder">
                                        </i>

                                    </a>
                                    <a class="btn btn-info btn-sm" href="{{route('admin.order.edit',$order->id)}}">
                                        <i class="fas fa-pencil-alt">
                                        </i>

                                    </a>
                                    <a class="btn btn-info btn-sm"
                                       href="{{route('admin.order.export-excel',$order->id)}}">
                                        <i class="fas fa-download">
                                        </i>
                                    </a>


                                    @if(($order->removed_at OR $order->deleted_at)  AND  in_array(Auth::id(),[1,153]))
                                        <a class="btn btn-warning btn-sm"
                                           href="{{route('admin.order.recover',$order->id)}}"
                                           onclick="return confirm('восстановить?')">
                                            <i class="fas fa-eraser"></i>
                                        </a>

                                    @endif

                                    @if(!$order->deleted_at AND in_array(Auth::id(),[1,153]))
                                        <a class="btn btn-danger btn-sm"
                                           href="{{route('admin.order.delete',$order->id)}}"
                                           onclick="return confirm('Удалить?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    @endif

                                    @if(($order->removed_at == null and $order->deleted_at == null) AND !in_array(Auth::id(),[1,153]))
                                        <a class="btn btn-danger btn-sm"
                                           href="{{route('admin.order.remove',$order->id)}}"
                                           onclick="return confirm('Удалить?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    @endif


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
                                <td>
                                    <a href="{{route('admin.store.show',$order->store_id)}}">{{$order->store?->name}}</a>
                                </td>
                                <td>{{$order->status->description}}</td>
                                <td>
                                    <a href="{{route('admin.user.show',$order->salesrep_id)}}">{{$order->salesrep->name}}</a>
                                </td>
                                <td>
                                    <a href="{{route('admin.user.show',$order->driver_id)}}">{{$order->driver?->name}}</a>
                                </td>
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
            @if(in_array(Auth::id(),[1,153]))
                <button type="submit" class="btn btn-warning">редактировать</button>
            @endif
        </form>
    </div>
    {{$orders->links()}}
</div>
