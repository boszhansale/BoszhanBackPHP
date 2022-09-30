<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                    <input wire:model="search" type="search" name="search" placeholder="поиск" class="form-control">
                </div>
                <div class="col-md-1">
                    <select wire:model="status_id" class="form-control">
                        <option value="all">Все статусы</option>
                        @foreach($statuses as $status)
                            <option value="{{$status->id}}">{{$status->description}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <input wire:model="start_date"  type="date" class="form-control">
                    <input wire:model="end_date"  type="date" class="form-control">
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
                    <th>ТТ</th>
                    <th>Статус</th>
                    <th>статус оплаты</th>
                    <th>тип оплаты</th>
                    <th>Торговый</th>
                    <th>Водитель</th>
                    <th>сумма</th>
                    <th>возврат</th>
                    <th>Дата создание</th>
                    <th>Дата доставки</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{$order->id}}</td>
                        <td>{{$order->store->name}}</td>

                        <td>{{$order->status->description}}</td>
                        <td>{{$order->paymentStatus->name}}</td>
                        <td>{{$order->paymentType->name}}</td>
                        <td>{{$order->salesrep->name}}</td>
                        <td>{{$order->driver->name}}</td>
                        <td class="price">{{$order->purchase_price}}</td>
                        <td class="price">{{$order->return_price}}</td>
                        <td>{{$order->created_at}}</td>
                        <td>{{$order->delivery_date}}</td>

                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
    {{$orders->links()}}
</div>
