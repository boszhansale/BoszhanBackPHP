<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <label for="">поиск</label>
                    <select class="form-control" wire:model.lazy="riderId" id="">
                        <option value="">все</option>
                        @foreach($riders as $rider)
                            <option value="{{$rider->id}}">{{$rider->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input wire:model="start_date" type="date" class="form-control">
                    <input wire:model="end_date" type="date" class="form-control">
                </div>
                <div class="col-md-2">
                    <a href="{{route('admin.user.riderExcel',['rider_id' => $riderId,'start_date' => $start_date,'end_date' => $end_date])}}"
                       class="btn btn-danger">скачать</a>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Ф.И.О. Водителя</th>
                    <th>Ф.И.О. Экспедитора</th>
                    <th>Категория точки</th>
                    <th>Наименование торговой точки</th>

                    <th>Дата</th>
                    <th>Наименование товара</th>
                    <th>Ед. изм.</th>
                    <th>Кол-во проданого товара</th>
                    <th>Кол-во возвращенной продукции</th>
                    {{--                    <th>Кол-во продаж за минусом возврата</th>--}}
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{$order->id}}</td>
                        <td>{{$order->rider->name}}</td>
                        <td>{{$order->driver->name}}</td>
                        <td>{{$order->store->counteragent?->priceType?->name ?? 'BC'}}</td>
                        <td>{{$order->store->name}}</td>
                        <td>{{$order->delivery_date}}</td>
                        <td>{{$order->name}}</td>
                        <td>{{$order->measure == 1 ? 'шт' : 'кг'}}</td>
                        <td>{{$order->type == 0 ? $order->count : 0}}</td>
                        <td>{{$order->type == 1 ? $order->count : 0}}</td>
                        {{--                        <td>{{$order->count}} </td>--}}
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{$orders->links()}}
        </div>
    </div>
</div>
