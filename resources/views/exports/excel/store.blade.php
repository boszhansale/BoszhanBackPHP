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
            <td>{{ $store->id_1c }}</td>
            <td>{{ $store->salesrep->name }}</td>
            <td>{{ $store->address }}</td>
            <td>{{ $store->phone }}</td>
            <td>{{ $store->name }} ({{$store->id}})</td>
            @if($store->counteragent)
                <td>{{ $store->counteragent->bin }}</td>
            @else
                <td>{{ $store->bin }}</td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
