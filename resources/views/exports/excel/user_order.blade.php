<table>
    <thead>
    <tr>
        <th>ФИО</th>
        <th>заявки физ лица</th>
        <th>возвраты физ лицо</th>
        <th>заявки юр лица</th>
        <th>возвраты юр лицо</th>
        <th>торговые точки</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $ordersQuery->clone()->where('orders.salesrep_id',$user->id)->whereNull('stores.counteragent_id')->count() }}</td>
            <td>{{ $ordersQuery->clone()->where('orders.salesrep_id',$user->id)->whereNull('stores.counteragent_id')->where('return_price',0)->count() }}</td>
            <td>{{ $ordersQuery->clone()->where('orders.salesrep_id',$user->id)->whereNotNull('stores.counteragent_id')->count() }}</td>
            <td>{{ $ordersQuery->clone()->where('orders.salesrep_id',$user->id)->whereNotNull('stores.counteragent_id')->where('return_price',0)->count() }}</td>
            <td>{{ $user->stores()->count() }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
