<div>
    <div class="card">
        <div class="card-body">
            <table class="table table-hover text-nowrap table-responsive">
                <thead>

                <tr>
                    <th>#</th>
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
                    <th>Дата закрытие</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    @if(count($order->error_message) > 0 )
                        <tr class="bg-red">
                    @else
                        <tr>
                            @endif
                            <td>{{$loop->iteration}}</td>
                            <td>{{$order->id}}</td>
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
                                <buttun wire:click="delete({{$order->id}})" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </buttun>
                            </td>
                            <td>
                                @if($order->store?->counteragent_id)
                                    <a href="{{route('admin.counteragent.show',$order->store->counteragent_id)}}">{{$order->store->counteragent->name}}</a>
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
                                <a href="{{route('admin.user.show',$order->driver_id)}}">{{$order->driver->name}}</a>
                            </td>
                            <td class="price">{{$order->purchase_price}}</td>
                            <td class="price">{{$order->return_price}}</td>
                            <td>{{$order->created_at}}</td>
                            <td>{{$order->delivery_date}}</td>
                            <td>{{$order->delivered_date}}</td>
                        </tr>
                        @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
