<table>
    <thead>
    <tr>
        <th>№</th>
        <th>ФИО торгового представителя</th>
        <th>Категория точки</th>
        <th>Наименование торговой точки</th>
        <th>Наименование товара</th>
        <th>Ед. изм.</th>
        <th>Кол-во продажа</th>
        <th>Кол-во вернувшегося товара</th>
        <th>Сумма продаж</th>
        <th>Сумма вернувшегося товара</th>
        <th>Причина возврата</th>
        <th>Дата</th>
    </tr>
    </thead>
    <tbody>
    @foreach($refunds as $refund)

        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$refund->salesrep->name}}</td>
            <td>{{$refund->store->counteragent?->priceType?->name ?? 'BC'}}</td>
            <td> {{$refund->store->name}}</td>
            <td> {{$refund->name}}</td>
            <td>{{$refund->measure == 1 ? 'шт' : 'кг'}}</td>
            <td>{{$query->clone()->where('products.id',$refund->product_id)->where('stores.id',$refund->store_id)->sum('baskets.count')}}</td>
            <td>{{$refund->count}}</td>
            <td>{{$query->clone()->where('products.id',$refund->product_id)->where('stores.id',$refund->store_id)->sum('baskets.all_price')}}</td>
            <td>{{$refund->all_price}}</td>
            <td>{{$refund->title}}</td>
            <td>{{$refund->created_at}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
