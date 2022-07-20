<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>ПКО</title>
    <style>
        body {
            width: 100%;
            font-family: DejaVu Sans;
        }
        .underline{
            text-decoration: underline;
        }
        table td{
            padding: 1px;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            font-size: 20px;
        }
        .sign{
            margin: 30px 0;
            font-size: 25px;
        }
    </style>
</head>
<body>
    <h3 style="text-align: center">ТОО "Первомайские Деликатесы" (БИН 130740008859)</h3>
    <h1 style="text-align: center">КВИТАНЦИЯ</h1>
    <h2 style="text-align: center">к приходному кассовому ордеру</h2>
    <h1 style="text-align: center">№{{$order->id}}</h1>
    <h3>
        Принято от: <b class="underline">
            @foreach($recipient as $r)
                {{$r}}@if(!$loop->last), @endif
            @endforeach
        </b>
    </h3>
    <br>
    <h3>
        Основание: оплата за мясную продукцию
    </h3>
    <br>

    <h4 style="font-size: 28px">Сумма: <span  class="underline">{{$all_price}}</span> KZT В т.ч. НДС {{round($all_price - ($all_price / 112) * 100,1) }} </h4>
    <h1 style="text-align: center">{{\Carbon\Carbon::now()->format('d.m.Y')}}</h1>

    <h2>Кассир: {{$order->driver->name}}</h2>
    <br>
    <h1>Подпись: _________________________</h1>
</body>
</html>
