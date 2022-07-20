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
    <h3>ТОО "Первомайские Деликатесы" (БИН 130740008859)</h3>
    <h1>Накладная на отпуск запасов на сторону</h1>
    <h1>№{{$order->id}} от {{\Carbon\Carbon::parse($order->created_at)->format('d.m.Y')}}</h1>
    <h3>
        Получатель: <b class="underline">
            @foreach($recipient as $r)
                {{$r}}@if(!$loop->last), @endif
            @endforeach
        </b>
    </h3>
    <h3>Склад: <b class="underline">{{$order->driver->name}}</b></h3>

    <table>
        <tr>
                <td>№</td>
                <td>Наименование</td>
                <td>Артикул</td>
                <td>Ед.</td>
                <td>Кол-во</td>
                <td>Цена</td>
                <td>Сумма <br>с НДС</td>
{{--                <td>Сумма <br>без НДС</td>--}}
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
                <td>{{$count}}</td>
                <td>{{$price}}</td>
                <td>{{$all_price}}</td>
{{--                <td>{{round(($all_price / 112) * 100,1) }}</td>--}}
            </tr>
        </tbody>
    </table>

    <div class="sign">
        <p>Всего отпущено количество запасов: {{$count}}</p>
        <p>на сумму: <span style="font-size: 28px" class="underline">{{$all_price}}</span> KZT</p>
        <p>В том числе НДС (12%): <span style="font-size: 28px" class="underline">{{round($all_price - ($all_price / 112) * 100,1) }}</span> KZT</p>
        <span>Отпустил___________________________________________</span>
        <br>
        <br>
        <span>Получил____________________________________________</span>
        <h4>
            Kaspi QR
        </h4>
        <div>
            <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(250)->generate("https://kaspi.kz/pay/pervdelic?service_id=4494&7068=$order->id&amount=$qr_price")) !!} ">
        </div>
        <p>
            Отсканируйте QR код для оплаты
        </p>
        <hr>
    </div>


    {!! QrCode::size(300)->generate("https://kaspi.kz/pay/pervdelic?service_id=4494&7068=$order->id&amount=$all_price") !!}


</body>
</html>
