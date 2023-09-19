@extends('admin.layouts.index')

@section('content-header-title','Статистика')
@section('content')
    {{--    @livewire('order-statistic')--}}


    <div class="card-header">
        <div class="row justify-content-between">
            <div class="col">
                <h5>Общая:</h5>
                <ul>
                    <li>кол. заявок : {{$count}}</li>
                    <li>кол. закрытых : {{$closed_count}}</li>
                    <li>сумма заявок: <span class="price">{{$order_purchase_price}}</span></li>
                    <li>кол. возврат: {{$order_return_count}}</li>
                    <li>сумма. возврат: <span class="price">{{ $order_return_price }}</span>
                    </li>
                </ul>
            </div>
            <div class="col">
                <h5>Юр лицо</h5>
                <ul>
                    <li>кол. заявок: {{$query->clone()->whereNotNull('stores.counteragent_id')->count()}}</li>
                    <li>кол. закрытых
                        : {{$query->clone()->whereNotNull('stores.counteragent_id')->whereNotNull('delivered_date')->count()}}</li>
                    <li>сумма заявок: <span
                            class="price">{{$query->clone()->whereNotNull('stores.counteragent_id')->sum('orders.purchase_price')}}</span>
                    </li>
                    <li>кол.
                        возврат: {{$query->clone()->whereNotNull('stores.counteragent_id')->where('orders.return_price', '>', 0)->count()}}</li>
                    <li>сумма. возврат: <span
                            class="price">{{$query->clone()->whereNotNull('stores.counteragent_id')->sum('orders.return_price')}}</span>
                    </li>
                </ul>
            </div>
            <div class="col">
                <h5>Физ лицо</h5>
                <ul>
                    <li>кол. заявок: {{$query->clone()->whereNull('stores.counteragent_id')->count()}}</li>
                    <li>кол. закрытых
                        : {{$query->clone()->whereNull('stores.counteragent_id')->whereNotNull('delivered_date')->count()}}</li>
                    <li>сумма заявок: <span
                            class="price">{{$query->clone()->whereNull('stores.counteragent_id')->sum('orders.purchase_price')}}</span>
                    </li>
                    <li>кол.
                        возврат: {{$query->clone()->whereNull('stores.counteragent_id')->where('orders.return_price', '>', 0)->count()}}</li>
                    <li>сумма. возврат: <span
                            class="price">{{$query->clone()->whereNull('stores.counteragent_id')->sum('orders.return_price')}}</span>
                    </li>
                </ul>
            </div>
            <div class="col">
                <ul>
                    @if($order_return_price > 0)
                        @if(($order_return_price / $order_purchase_price)*100 >= 60 )
                            <li style="color: red">процент
                                возврата: {{ round(($order_return_price / $order_purchase_price)*100)  }} %
                            </li>
                        @else
                            <li>процент возврата: {{ round(($order_return_price / $order_purchase_price)*100)  }}%
                            </li>
                        @endif

                    @else
                        <li>процент возврата: 0%</li>
                    @endif
                </ul>

            </div>

        </div>
    </div>
@endsection
