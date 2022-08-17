<RETURN>
<DOCUMENTNAME>320</DOCUMENTNAME>
<NUMBER>{{$order->id}}-0100-{{substr($order->salesrep->id_1c,-4)}}-{{$order->payment_type_id}}</NUMBER>
<DATE>{{\Carbon\Carbon::parse($order->created_at)->format('Y-m-d')}}</DATE>
<DELIVERYDATE>{{\Carbon\Carbon::parse($order->delivery_date)->format('Y-m-d')}}</DELIVERYDATE>
<MANAGER>{{$order->salesrep->driver->id_1c}}</MANAGER>
<DRIVER>{{$order->salesrep->id_1c}}</DRIVER>
<CURRENCY>KZT</CURRENCY>
<HEAD>
    <SUPPLIER>9864232489962</SUPPLIER>
    <BUYER>{{$counteragent_id_1c}}</BUYER>
    <DELIVERYPLACE>{{$order->store->id_1c}}</DELIVERYPLACE>
    <INVOICEPARTNER>{{$counteragent_id_1c}}</INVOICEPARTNER>
    <SENDER>{{$order->store->id_1c}}</SENDER>
    <RECIPIENT>9864232489962</RECIPIENT>
    <EDIINTERCHANGEID>0</EDIINTERCHANGEID>
    <FINALRECIPIENT>{{$order->store->id_1c}}</FINALRECIPIENT>
    @foreach($order->baskets()->where('type',1)->get() as $basket)
            <POSITION>
                <POSITIONNUMBER>{{$loop->iteration}}</POSITIONNUMBER>
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
                @if($basket->type ==  1)
                    @if($basket->reasonRefund)
                        <RETURNREASON>{{$basket->reasonRefund->code}}</RETURNREASON>
                    @endif
                @endif
        </POSITION>
    @endforeach</HEAD>
</RETURN>


