<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laravel</title>
    <style>
        body {
            width: 100%;
            height: 1200px;
            border: 2px solid grey;
            font-family: DejaVu Sans;
        }

        .nacladnoi {
            text-align: -webkit-center;
            margin: auto;
        }

        table {
            font-family: DejaVu Sans;
            text-align: center;
            border-collapse: separate;
            border-spacing: 5px;
            background: #fff;
            color: #000000;
            width: 100%;
            border-radius: 2px;
        }

        .company h3 {
            font-size: 10px;
            margin-top: 20px;
            text-align: center;
        }

        th {
            font-size: 11px;
            padding: 10px;
        }

        td {
            padding: 2px;
            font-size: 12px;
        }

        input[type=text] {
            padding: 4px 0px;
            border: 1px solid #82ab7b;
            box-sizing: border-box;
        }

        .number {
            width: 31px;
        }

        .name {
            font-family: DejaVu Sans;
            width: 300px;
            font-size: 12px;
        }

        .quantity {
            width: 90px;
            font-family: DejaVu Sans;
        }

        .number2 {
            width: 40px;
        }

        .name2 {
            font-family: DejaVu Sans;
            width: 400px;
            font-size: 12px;
        }

        .quantity2 {
            width: 120px;
        }

        .price {
            width: 110px;
        }

        .sum {
            width: 83px;
        }

        .buy {
            width: 50%;
            float: right;
        }

        .buy p {
            line-height: 0em;
            margin-top: 40px;
            text-align: center;
            font-size: 11px;
        }

        .buy input {
            text-align: center;
        }

        .company {
            width: 50%;
            float: left;
        }

        .waybill {
            width: 100%;
            padding-top: 80px;
        }

        .waybill3 {
            width: 100%;
            margin-top: -20px;
        }

        .waybill3 h5 {
            text-align: center;
        }

        .waybill h5 {
            text-align: center;
        }

        .total {
            margin-left: 30px;
        }

        .podpis {
            display: inline-block;
            margin-left: 30px;
        }

        .podpis2 {
            margin-left: 150px;
            display: inline-block;
        }
    </style>
</head>
<body class="antialiased">
<div class="container">
    <div class="nacladnoi">
        <div class="company">
            <h3>TOO "???????????????????????? ????????????????????"</h3>
            <div style="margin-left: 20px;">
                <p style="line-height: 0em;text-align: center;padding-top:23px;font-size: 11px;">??????????????????????????</p><br><br>
                <input class="name" style="text-align: center" type="text" value="{{$order->salesrep->name}}">
            </div>
        </div>
        <div class="buy" style="margin-top: 37px">
            <p>????????????????????</p><br><br><br>
            <input class="name" type="text" value="{{$order->store->name}}, {{$order->store->address}}">
        </div>
        <div style="margin-top: 150px; margin-left: 300px">
            <p style="line-height: 0em;font-size: 11px; margin-left: 20px">????????????????</p><br>
            <input class="name" style="margin-left: -100px;text-align: center" type="text" value="{{$order->driver->name}}">
        </div>
        <div class="waybill" style="margin-top: -75px;">
            <h5>?????????????? ?????????????? ??? {{$order->id}} ????????: {{\Carbon\Carbon::parse($order->created_at)->format("d-m-Y")}}</h5>
        </div>


            <div class="waybill3">
                <h5>??????????????</h5>
            </div>
            <table>
                <tbody>
                <tr>
                    <th>???</th>
                    <th>????????????????????????</th>
                    <th>??????-????</th>
                    <th>????????</th>
                    <th>??????????</th>
                </tr>
                @php
                    $returnSum = 0;
                @endphp
                @foreach($order->baskets()->where('type',1)->get() as $basket)
                    <tr>
                        <td class="number"><input class="number" type="text" value="{{$basket->product_id}}"></td>
                        <td class="name"><input class="name" type="text" value="{{$basket->product->name}}"></td>
                        <td class="quantity">
                            <input class="quantity" type="text" value="{{$basket->count}} {{$basket->product->measureDescription()}}">
                        </td>
                        <td class="price"><input class="price" type="text" value="{{$basket->price}}"></td>
                        <td class="sum"><input class="sum" type="text" value="{{$basket->all_price}}">
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <h5 class="total">?????????? ?????????? ?? ????????????????: <u>{{$order->baskets()->where('type',1)->sum('all_price')}}</u></h5>


        <br><br>
        <div class="podpis">
            <div>
                <h6>????????????????????????</h6>
                <p>__________________________</p>
            </div>
            <div>
                <h6>????????????????</h6>
                <p>__________________________</p>
            </div>
        </div>
        <div class="podpis2">
            <div>
                <h6>??????????????????</h6>
                <p>__________________________</p>
            </div>
            <div>
                <h6>??????????????</h6>
                <p>__________________________</p>
            </div>
        </div>
    </div>
</div>
</body>
</html>
