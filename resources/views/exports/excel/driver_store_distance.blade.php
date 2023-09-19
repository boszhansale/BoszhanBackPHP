@foreach(\App\Models\User::where('role_id',2)->whereStatus(1)->orderBy('name')->get() as $driver)
    <table>
        <tr>
            <th>водитель</th>
            <th>{{$driver->name}}</th>
        </tr>
        <tr>
            <th>дистанция</th>
            <th>{{$driver->getStoreDistance()}}</th>
        </tr>
    </table>
    <table>
        <tr>
            <th>торговый точка</th>
            <th>адрес</th>
            <th>сумма заказа</th>
            <th>сумма возврата</th>
        </tr>
        <tbody>
        @foreach($driver->orders()->whereDate('delivery_date',now()->addDay())->get() as $order)
            <tr>
                <td>{{$order->store->name}}</td>
                <td>{{$order->store->address}}</td>
                <td>{{$order->purchase_price}}</td>
                <td>{{$order->return_price}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endforeach
