<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Этикетки</title>
</head>
<body>
<div class="container">
    @if($label->labelProduct->align == 'right')
        <div class="up">
            <h1 style="text-align: right;font-size: 10px">{{$label->getName()}}</h1>
            <h4 style="text-align: right">{{$label->getComposition()}}</h4>

            <h1 style="text-align: left">{{$label->labelProduct->name_en}}</h1>
            <h4 style="text-align: left">{{$label->labelProduct->composition_en}}</h4>
        </div>

        <div class="down">
            {{--            <div class="kvd">--}}
            {{--                <div>--}}
            {{--                    <span>{{$label->getCreateAtNumber()}}</span>--}}
            {{--                    --}}{{--                <span>{{$label->id}}</span>--}}
            {{--                </div>--}}
            {{--            </div>--}}

            <h2 style="text-align: right">{{$label->getCert()}}</h2>
            @if($label->date)
                <h5 style="text-align: right">Date of manufacture/تاريخ الأنتاج: {{$label->date}}</h5>
            @endif
            @if($label->labelProduct->measure == 2)
                @if($label->weight)
                    <p style="text-align: right">Net weight, kg/الوزن الصافي،كيلوغرام{{$label->weight}}</p>
                @endif
                {{--            <p>{{$label->getMass()}}: {{$label->weight}} {{$label->getMeasure()}} +/-3%</p>--}}
            @endif
            <div class="dng">
                @if($label->labelProduct->barcode)
                    {!!DNS1D::getBarcodeSVG($label->labelProduct->barcode, 'EAN13',1,40) !!}
                @endif

                <div class="emb">
                    <img
                        src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/f7/EAC_b-on-w.svg/1200px-EAC_b-on-w.svg.png"
                        alt="">
                    <img src="https://k2v.ru/wp-content/uploads/2020/04/stakan-i-vilka-oboznachenie.jpg " alt="">
                    <img src="https://cdn-icons-png.flaticon.com/512/91/91356.png" alt="">
                </div>
            </div>
            <p>{!! $label->getAddress()!!}</p>
        </div>
    @else
        <div class="up">
            <h1 style="text-align: {{$label->labelProduct->align}}">{{$label->getName()}}</h1>
            <h4 style="text-align: {{$label->labelProduct->align}}">{{$label->getComposition()}}</h4>
            @if($label->labelProduct->composition_ru)
                <h4>{{$label->labelProduct->composition_ru}}</h4>
            @endif
        </div>

        <div class="down">
            <div class="kvd">
                <div>
                    <span>{{$label->getCreateAtNumber()}}</span>
                    {{--                <span>{{$label->id}}</span>--}}
                </div>
            </div>

            <h2>{{$label->getCert()}}</h2>
            @if($label->date)
                @if($label->date_type == 1)
                    <h5>{{$label->getDateCreate()}}: {{$label->date}}</h5>
                @else
                    <h5>{{$label->labelProduct->date_create_package_kz}} {{$label->date}}</h5>
                    <h5>{{$label->labelProduct->date_create_package_ru}}: {{$label->date}}</h5>
                @endif
            @endif

            {{--            @if($label->labelProduct->measure == 2)--}}
            @if($label->weight)
                <p class="weight">{{$label->getWeighName()}}: {{$label->weight}} {{$label->getMeasure()}}</p>
            @endif
            {{--            <p>{{$label->getMass()}}: {{$label->weight}} {{$label->getMeasure()}} +/-3%</p>--}}
            {{--            @endif--}}


            <div class="dng">
                @if($label->labelProduct->barcode)
                    {!!DNS1D::getBarcodeSVG($label->labelProduct->barcode, 'EAN13',1.3,44) !!}
                @endif

                <div class="emb">
                    @if($label->labelProduct->image_url_1)
                        <img
                            src="{{$label->labelProduct->image_url_1}}"
                            alt="">
                    @endif
                    @if($label->labelProduct->image_url_2)
                        <img src="{{$label->labelProduct->image_url_2}}" alt="">
                    @endif
                    @if($label->labelProduct->image_url_3)
                        <img src="{{$label->labelProduct->image_url_3}}" alt="">
                    @endif
                    @if($label->labelProduct->image_url_4)
                        <img src="{{$label->labelProduct->image_url_4}}" alt="">
                    @endif
                </div>
            </div>


            <p>{!! $label->getAddress()!!}</p>
        </div>
    @endif
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
        font-size: 11px;
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
        font-size: 6px;
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
        margin-top: 3px;
    }

    .emb {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .emb img {
        width: 19px;
        height: 19px;
    }

    .kvd {
        display: flex;
        justify-content: end;
    }

    .kvd span {
        border: 1px solid black;
        font-size: 11px;
    }

    .weight {
        font-size: 8px;
    }
</style>
</body>
</html>
