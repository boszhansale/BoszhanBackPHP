@extends('supervisor.layouts.index')

@section('content-header-title','История')
@section('content')
    <div class="card mb-5">
        <div class="card-header"><h2>Корзина</h2></div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Продукты</th>
                    <th>оригинальные данные</th>
                    <th>изменение</th>
                </tr>
                </thead>
                <tbody>
                @foreach($order->baskets()->withTrashed()->get() as $basket)
                    <tr>
                        <td>{{$basket->product->name}}</td>

                        <td>
                            @foreach($basket->audits()->where('event','created')->get() as $audit)
                                <table style="margin-bottom: 5px">
                                    @foreach($audit->new_values as $key => $value)
                                        <tr>
                                            @switch($key)
                                                @case('count')
                                                    <td> количество</td>
                                                    <td>{{$value}}</td>
                                                    @break
                                                @case('all_price')
                                                    <td>цена</td>
                                                    <td>{{$value}}</td>
                                                    @break
                                                @default
                                                    @continue(2)
                                                    @break
                                            @endswitch
                                        </tr>
                                    @endforeach
                                </table>
                            @endforeach
                        </td>
                        <td>
                            @foreach($basket->audits()->where('event','updated')->get() as $audit)
                                <table style="margin-bottom: 5px">
                                    @foreach($audit->new_values as $key => $value)
                                        <tr>
                                            @switch($key)
                                                @case('count')
                                                    <td> количество</td>
                                                    <td>{{$value}}</td>
                                                    @break
                                                @case('all_price')
                                                    <td>цена</td>
                                                    <td>{{$value}}</td>
                                                    @break
                                                @default
                                                    @continue(2)
                                                    @break
                                            @endswitch
                                        </tr>
                                    @endforeach
                                </table>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
