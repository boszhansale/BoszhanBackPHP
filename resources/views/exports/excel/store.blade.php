<table>
    <thead>
    <tr>
        <th>id</th>
        <th>Представитель</th>
        <th>Адрес</th>
        <th>Номер телефона</th>
        <th>Название</th>
        <th>БИН</th>
    </tr>
    </thead>
    <tbody>
    @foreach($stores as $store)
        <tr>
            <td>{{ (int)$store->id_1c }}</td>
            <td>{{ $store->salesrep->name }}</td>
            <td>{{ $store->address }}</td>
            <td>{{ $store->phone }}</td>
            <td>{{ $store->name }} ({{$store->id}})</td>
            <td>{{ $store->bin }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
