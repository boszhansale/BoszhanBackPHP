<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>РНК</title>
    <style>
        body {
            width: 100%;
            font-family: DejaVu Sans;
        }
        .underline{
            text-decoration: underline;
        }
        table td{
            padding: 2px;
            font-size: 20px;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        .sign{
            margin: 30px 0;
            font-size: 25px;
        }
    </style>
</head>
<body>
    <h1>№{{$order->id}} от {{\Carbon\Carbon::parse($order->created_at)->format('d.m.Y')}}</h1>
    <table>
        <tr>
                <td>№</td>
                <td>Наименование</td>
                <td>Артикул</td>
                <td>Ед.</td>
                <td>Кол-во</td>
                <td>Цена</td>
                <td>Сумма <br>с НДС</td>
        </tr>
        <tbody>
            <?php $i = 1?>
            @foreach($order->baskets as $basket)
                @if($basket->type == 0)
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$basket->product->name}}</td>
                        <td>{{$basket->product->article}}</td>
                        <td>{{$basket->product->measure == 1 ? 'шт.' : 'кг.'}}</td>
                        <td>{{$basket->count}}</td>
                        <td>{{$basket->price}}</td>
                        <td>{{$basket->all_price}}</td>
                    </tr>
                    <?php $i++?>
                @endif
            @endforeach
            <tr>
                <td colspan="4">Итог</td>
                <td>{{$count}}</td>
                <td>{{$price}}</td>
                <td>{{$all_price}}</td>
                <td>{{$all_price > 0 ? round(($all_price / 112) * 100,1) : 0 }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <h2>Возвраты</h2>
    <br>
    <table>
        <tr>
                <td>№</td>
                <td>Наименование</td>
                <td>Артикул</td>
                <td>Ед.</td>
                <td>Кол-во</td>
                <td>Цена</td>
                <td>Сумма <br>с НДС</td>
        </tr>
        <tbody>

            @foreach($order->baskets()->where('type',0)->get() as $basket)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$basket->product->name}}</td>
                    <td>{{$basket->product->article}}</td>
                    <td>{{$basket->product->measureDescription()}}</td>
                    <td>{{$basket->count}}</td>
                    <td>{{$basket->price}}</td>
                    <td>{{$basket->all_price}}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4">Итог</td>
                <td>{{$return_count}}</td>
                <td>{{$return_price}}</td>
                <td>{{$return_all_price}}</td>
            </tr>
        </tbody>
    </table>

    <div class="sign">
        <p>Всего отпущено количество запасов: {{$count}}</p>
        <p>на сумму: <span style="font-size: 28px" class="underline">{{$all_price - $return_all_price}}</span> KZT</p>
    </div>
    <br>
    <br>
{{--    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(600)->generate("https://kaspi.kz/pay/pervdelic?service_id=4494&7068=$order->id&amount=$all_price")) !!} ">--}}
{{--    <br>--}}
{{--    <br>--}}
{{--    <br>--}}
{{--    <br>--}}
{{--    <h1>--}}
{{--        Kaspi QR--}}
{{--    </h1>--}}
    {{--    <img src="{!! QrCode::format('png')->generate("https://kaspi.kz/pay/pervdelic?service_id=4494&7068=$order->id&amount=$all_price") !!}" alt="">--}}
{{--    {!! QrCode::size(300)->generate("https://kaspi.kz/pay/pervdelic?service_id=4494&7068=$order->id&amount=$all_price") !!}--}}

</body>
</html>
