<{{\App\Models\OrderReport::REPORTS_TYPES[$type]}}>
<DOCUMENTNAME>{{\App\Models\OrderReport::DOCUMENT_NAMES_1C[$type]}}</DOCUMENTNAME>
<NUMBER>{{$order->id}}-0{{$type+1}}00-{{substr($order->salesrep->id_1c,-4)}}-{{$order->payment_type}}</NUMBER>
<DATE>@if($type == 1){{$date}}@else{{\Carbon\Carbon::parse($order->created_at)->format('Y-m-d')}}@endif</DATE>
<DELIVERYDATE>{{$date}}</DELIVERYDATE>
<MANAGER>{{$order->salesrep->driver->id_1c}}</MANAGER>
<DRIVER>{{$order->salesrep->id_1c}}</DRIVER>
<CURRENCY>KZT</CURRENCY>`
<HEAD>
    <SUPPLIER>9864232489962</SUPPLIER>
    <BUYER>{{$counteragent_id_1c}}</BUYER>
    <DELIVERYPLACE>{{$order->store->id_1c}}</DELIVERYPLACE>
    <INVOICEPARTNER>{{$counteragent_id_1c}}</INVOICEPARTNER>
    <SENDER>{{$order->store->id_1c}}</SENDER>
    <RECIPIENT>9864232489962</RECIPIENT>
    <EDIINTERCHANGEID>0</EDIINTERCHANGEID>
    <FINALRECIPIENT>{{$order->store->id_1c}}</FINALRECIPIENT>
    @foreach($order->baskets as $key => $basket)
        @if($basket->type === 0 && $type !== \App\Models\OrderReport::REPORT_TYPE_RETURN)
            <POSITION>
                <POSITIONNUMBER>{{$key + 1}}</POSITIONNUMBER>
                <PRODUCT>{{$basket->product_id+5000000000000}}</PRODUCT>
                <PRODUCTIDSUPPLIER/>
                <PRODUCTIDBUYER>{{$order->store->id_1c}}</PRODUCTIDBUYER>
                <ORDEREDQUANTITY>{{number_format((float)$basket->count, 3, '.', '')}}</ORDEREDQUANTITY>
                @if($basket->product->measure == 1)
                    <ORDERUNIT>PCE</ORDERUNIT>
                @else
                    <ORDERUNIT>KGM</ORDERUNIT>
                @endif
                <ORDERPRICE>{{ round($order->purchase_price - ($order->purchase_price / 100 * 12))}}.00</ORDERPRICE>
                <PRICEWITHVAT>{{$order->purchase_price}}.00</PRICEWITHVAT>
                <VAT>12</VAT>
                <CHARACTERISTIC>
                    <DESCRIPTION>{{$basket->product->name}}</DESCRIPTION>
                </CHARACTERISTIC>
            </POSITION>
        @endif
        @if($basket->type === 1 && $type == \App\Models\OrderReport::REPORT_TYPE_RETURN)
            <POSITION>
                <POSITIONNUMBER>{{$key + 1}}</POSITIONNUMBER>
                <PRODUCT>{{$basket->product_id+5000000000000}}</PRODUCT>
                <PRODUCTIDSUPPLIER/>
                <PRODUCTIDBUYER>{{$order->store->id_1c}}</PRODUCTIDBUYER>
                <ORDEREDQUANTITY>{{number_format((float)$basket->count, 3, '.', '')}}</ORDEREDQUANTITY>
                @if($basket->product->measure == 1)
                    <ORDERUNIT>PCE</ORDERUNIT>
                @else
                    <ORDERUNIT>KGM</ORDERUNIT>
                @endif
                <ORDERPRICE>{{ round($order->purchase_price - ($order->purchase_price / 100 * 12))}}.00</ORDERPRICE>
                <PRICEWITHVAT>{{$order->purchase_price}}.00</PRICEWITHVAT>
                <VAT>12</VAT>
                <CHARACTERISTIC>
                    <DESCRIPTION>{{$basket->product->name}}</DESCRIPTION>
                </CHARACTERISTIC>
            </POSITION>
        @endif
    @endforeach</HEAD>
</{{\App\Models\OrderReport::REPORTS_TYPES[$type]}}>


