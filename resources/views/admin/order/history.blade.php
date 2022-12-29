@extends('admin.layouts.index')

@section('content-header-title','История')
@section('content')
    <div class="card">
        <div class="card-header">Заявка №{{$order->id}} от {{$order->created_at}}</div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Дата изменения</th>
                    <th>Операция</th>
                    <th>Старый запись</th>
                    <th>новый запись</th>
                </tr>
                </thead>
                <tbody>
                @foreach($order->audits()->where('event','<>','created')->get() as $audit)
                    <tr>
                        <td>{{$audit->created_at}}</td>
                        <td>
                            @switch($audit->event)
                                @case('created')
                                    создание заказа
                                    @break
                                @case('updated')
                                    изменение
                                    @break
                                @case('deleted')
                                    удален
                                    @break
                            @endswitch
                        </td>
                        <td>
                            <table>
                                <tr>
                                    <th>ключ</th>
                                    <th>значение</th>
                                </tr>
                                @foreach($audit->old_values as $key => $value)
                                    <tr>
                                        <td>
                                            @switch($key)
                                                @case('purchase_price')
                                                    сумма покупки
                                                    @break
                                                @case('return_price')
                                                    сумма возврата
                                                    @break
                                                @default
                                                    {{$key}}

                                            @endswitch
                                        </td>
                                        <td>{{$value}}</td>
                                    </tr>
                                @endforeach
                            </table>

                        </td>
                        <td>
                            <table>
                                <tr>
                                    <th>ключ</th>
                                    <th>значение</th>
                                </tr>
                                @foreach($audit->new_values as $key => $value)
                                    <tr>
                                        <td>
                                            @switch($key)
                                                @case('purchase_price')
                                                    сумма покупки
                                                    @break
                                                @case('return_price')
                                                    сумма возврата
                                                    @break
                                                @default
                                                    {{$key}}

                                            @endswitch
                                        </td>
                                        <td>{{$value}}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card mt-5">
        <div class="card-header"><h2>Корзина</h2></div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Продукты</th>
                    <th>История</th>
                </tr>
                </thead>
                <tbody>
                @foreach($order->baskets()->withTrashed()->get() as $basket)
                    <tr>
                        <td>{{$basket->product->name}}</td>

                        <td>
                            <table>
                                <thead>
                                <tr>
                                    <th>Дата</th>
                                    <th>операция</th>
                                    <th>старый</th>
                                    <th>новый</th>
                                </tr>
                                </thead>
                                @foreach($basket->audits as $audit)
                                    <tr>
                                        <td> {{$audit->created_at}}</td>
                                        <td>
                                            @switch($audit->event)
                                                @case('created')
                                                    добавлен в корзину
                                                    @break
                                                @case('updated')
                                                    изменение
                                                    @break
                                                @case('deleted')
                                                    удален
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>
                                            <table>
                                                @foreach($audit->old_values as $key => $value)
                                                    <tr>
                                                        <td>
                                                            @switch($key)
                                                                @case('product_id')
                                                                    ID продукта
                                                                    @break
                                                                @case('count')
                                                                    количество
                                                                    @break
                                                                @case('type')
                                                                    тип
                                                                    @break
                                                                @case('price')
                                                                    цена продукта
                                                                    @break
                                                                @case('all_price')
                                                                    цена
                                                                    @break
                                                                @case('order_id')
                                                                    айди заказа
                                                                    @break
                                                                @default
                                                                    {{$key}}

                                                            @endswitch
                                                        </td>
                                                        <td>{{$value}}</td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </td>
                                        <td>
                                            <table>
                                                @foreach($audit->new_values as $key => $value)
                                                    <tr>
                                                        <td>
                                                            @switch($key)
                                                                @case('product_id')
                                                                    ID продукта
                                                                    @break
                                                                @case('count')
                                                                    количество
                                                                    @break
                                                                @case('type')
                                                                    тип
                                                                    @break
                                                                @case('price')
                                                                    цена продукта
                                                                    @break
                                                                @case('all_price')
                                                                    цена
                                                                    @break
                                                                @case('order_id')
                                                                    айди заказа
                                                                    @break
                                                                @default
                                                                    {{$key}}

                                                            @endswitch
                                                        </td>
                                                        <td>{{$value}}</td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
