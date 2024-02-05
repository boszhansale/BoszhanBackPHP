<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Этикетки</title>
</head>
<body>
<div class="container">
    <div class="up">
        <h1>{{$label->getName()}}</h1>
        <h4>{{$label->getComposition()}}</h4>
    </div>

    <div class="down">
        <div class="kvd">
            <div>
                <span>{{$label->getCreateAtNumber()}}</span>
                <span>{{$label->id}}</span>
            </div>
        </div>

        <h2>{{$label->getCert()}}</h2>
        <h5>{{$label->getDateCreate()}}: {{$label->date}}</h5>
        @if($label->weight)
            <p>{{$label->getWeighName()}}: {{$label->weight}} {{$label->getMeasure()}} +/-3%</p>
        @endif


        <div class="dng">
            {!!DNS1D::getBarcodeSVG($label->labelProduct->barcode, 'EAN13',1,40) !!}

            <div class="emb">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/f7/EAC_b-on-w.svg/1200px-EAC_b-on-w.svg.png"
                     alt="">
                <img src="https://k2v.ru/wp-content/uploads/2020/04/stakan-i-vilka-oboznachenie.jpg " alt="">
                <img src="https://cdn-icons-png.flaticon.com/512/91/91356.png" alt="">
            </div>
        </div>


        <p>{!! $label->getAddress()!!}</p>
    </div>
</div>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, Helvetica, sans-serif;
        font-weight: bold;
    }

    h1 {
        font-size: 10px;
    }

    h4 {
        font-size: 8px;
        font-weight: normal;
    }

    h2 {
        font-size: 8px;
    }

    h5 {
        font-size: 8px;
    }

    p {
        font-size: 8px;
    }

    .container {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 90mm;
    }

    html, body {
        margin: 0 8px;
    }

    .dng {
        display: flex;
        justify-content: space-between;
    }

    .emb {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .emb img {
        width: 15px;
        height: 15px;
    }

    .kvd {
        display: flex;
        justify-content: end;
    }

    .kvd span {
        border: 1px solid black;
        font-size: 11px;
    }
</style>
</body>
</html>
