<table>
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
