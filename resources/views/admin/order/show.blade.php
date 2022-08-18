@extends('admin.layouts.index')

@section('content-header-title','Заявка №'.$order->id)

@section('content')
    <div class="row">
        <div class="col">
            <a class="btn btn-info btn-sm" href="{{route('admin.order.export-excel',$order->id)}}">
                <i class="fas fa-download">
                </i>
                скачать excel
            </a>
            <a class="btn btn-info btn-sm" href="{{route('admin.order.waybill',$order->id)}}">
                <i class="fas fa-download">
                </i>
                скачать waybill
            </a>
            <a class="btn btn-info btn-sm" href="{{route('admin.order.edit',$order->id)}}">
                <i class="fas fa-pencil-alt">
                </i>
                изменить
            </a>
            <a  class="btn btn-danger btn-sm" href="{{route('admin.order.delete',$order->id)}}" onclick="return confirm('Удалить?')">
                <i class="fas fa-trash"></i>
                удалить
            </a>
        </div>
    </div>

    <br>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Обшая информация</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>ID</th>
                            <td>{{$order->id}}</td>
                        </tr>
                        <tr>
                            <th>Торговый представитель</th>
                            <td><a href="{{route('admin.user.show',$order->salesrep_id)}}">{{$order->salesrep->name}}</a></td>
                        </tr>
                        <tr>
                            <th>Водитель</th>
                            <td><a href="{{route('admin.user.show',$order->driver_id)}}">{{$order->driver->name}}</a></td>
                        </tr>
                        @if($order->store->counteragent)
                            <tr>
                                <th>Контрагент</th>
                                <td><a href="{{route('admin.counteragent.show',$order->store->counteragent_id)}}">{{$order->store->counteragent->name}}</a></td>
                            </tr>
                        @endif
                        <tr>
                            <th>Торговый точка</th>
                            <td><a href="{{route('admin.store.show',$order->store_id)}}">{{$order->store->name}}</a></td>
                        </tr>
                        <tr>
                            <th>MOBILE ID</th>
                            <td>{{$order->mobile_id}}</td>
                        </tr>
                        <tr>
                            <th>Тип оплаты</th>
                            <td>{{$order->paymentType->name}}</td>
                        </tr>
                        <tr>
                            <th>Статус оплаты</th>
                            <td>{{$order->paymentStatus->name}}</td>
                        </tr>
                        <tr>
                            <th>Дата доставки</th>
                            <td>{{$order->delivery_date}}</td>
                        </tr>
                        <tr>
                            <th>Дата доставлено</th>
                            <td>{{$order->delivered_date}}</td>
                        </tr>
                        <tr>
                            <th>Дата создании</th>
                            <td>{{$order->created_at}}</td>
                        </tr>
                        <tr>
                            <th>Сумма</th>
                            <td>{{$order->purchase_price}}</td>
                        </tr>

                        <tr>
                            <th>Возврат</th>
                            <td>{{$order->return_price}}</td>
                        </tr>
                        <tr>
                            <th>процент Возврат</th>
                            @if($order->return_price > 0)
                                <td>{{ round(($order->return_price / $order->purchase_price)*100)  }}%</td>
                            @else
                                <th>0%</th>
                            @endif
                        </tr>
                        <tr>
                            <th>Версия приложения</th>
                            <td>{{$order->salesrep_mobile_app_version}}</td>
                        </tr>

                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
           <div class="card">
               <div class="card-header">Покупки на сумму {{$order->baskets()->whereType(0)->sum('all_price')}}</div>
               <div class="card-body">
                   <table class="table table-bordered">
                       <thead>
                       <tr>
                           <th>ID</th>
                           <th>Продукт</th>
                           <th>артикул</th>
                           <th>шт/кг</th>
                           <th>Цена</th>
                           <th>Количество</th>
                           <th>итог</th>
                           <th>
                               <a class="btn btn-info btn-sm" href="{{route('admin.basket.create',[$order->id,0])}}">
                                   <i class="fas fa-pencil-alt">
                                   </i>
                                   создать
                               </a>
                           </th>
                       </tr>
                       </thead>
                       <tbody>
                       @foreach($order->baskets()->whereType(0)->get() as $basket)
                           <tr>
                               <td>{{$basket->product->id}}</td>
                               <td>{{$basket->product->name}}</td>
                               <td>{{$basket->product->article}}</td>
                               <td>{{$basket->product->measureDescription()}}</td>
                               <td>{{$basket->price}}</td>
                               <td>{{$basket->count}}</td>
                               <td>{{$basket->all_price}}</td>
                               <td class="project-actions text-right">
                                   <a class="btn btn-info btn-sm" href="{{route('admin.basket.edit',$basket->id)}}">
                                       <i class="fas fa-pencil-alt">
                                       </i>
                                       изменить
                                   </a>
                                   <a  class="btn btn-danger btn-sm" href="{{route('admin.basket.delete',$basket->id)}}" onclick="return confirm('Удалить?')">
                                       <i class="fas fa-trash"></i>
                                       удалить
                                   </a>
                               </td>
                           </tr>
                       @endforeach
                       </tbody>
                   </table>
               </div>
           </div>
        </div>
        <div class="col-md-12">
           <div class="card">
               <div class="card-header">Возврат на сумму {{$order->baskets()->whereType(1)->sum('all_price')}}</div>
               <div class="card-body">
                   <table class="table table-bordered">
                       <thead>
                       <tr>
                           <th>ID</th>
                           <th>Продукт</th>
                           <th>артикул</th>
                           <th>шт/кг</th>
                           <th>Цена</th>
                           <th>Количество</th>
                           <th>итог</th>
                           <th>
                               <a class="btn btn-info btn-sm" href="{{route('admin.basket.create',[$order->id,1])}}">
                                   <i class="fas fa-pencil-alt">
                                   </i>
                                   создать
                               </a>
                           </th>
                       </tr>
                       </thead>
                       <tbody>
                       @foreach($order->baskets()->whereType(1)->get() as $basket)
                           <tr>
                               <td>{{$basket->product->id}}</td>
                               <td>{{$basket->product->name}}</td>
                               <td>{{$basket->product->article}}</td>
                               <td>{{$basket->product->measureDescription()}}</td>
                               <td>{{$basket->price}}</td>
                               <td>{{$basket->count}}</td>
                               <td>{{$basket->all_price}}</td>
                               <td class="project-actions text-right">
                                   <a class="btn btn-info btn-sm" href="{{route('admin.basket.edit',$basket->id)}}">
                                       <i class="fas fa-pencil-alt">
                                       </i>
                                       изменить
                                   </a>
                                   <a  class="btn btn-danger btn-sm" href="{{route('admin.basket.delete',$basket->id)}}" onclick="return confirm('Удалить?')">
                                       <i class="fas fa-trash"></i>
                                       удалить
                                   </a>
                               </td>
                           </tr>
                       @endforeach
                       </tbody>
                   </table>
               </div>
           </div>
        </div>
    </div>
@endsection
