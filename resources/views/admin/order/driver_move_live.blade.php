<div>
    <form action="{{route('admin.order.driver-moving')}}" method="post">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Выберите водителя "C"</div>
                    <div class="card-body">
                        <select wire:model="from_driver_id" name="from_driver_id" required class="form-control">
                            <option value="*">выберите</option>
                            @foreach($fromDrivers  as $driver)
                                <option value="{{$driver->id}}">{{$driver->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Выберите водителя "На"</div>
                    <div class="card-body">
                        <select wire:model="to_driver_id" name="to_driver_id" required class="form-control">
                            <option>выберите</option>
                            @foreach($toDrivers  as $driver)
                                <option value="{{$driver->id}}">{{$driver->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                @if($to_driver_id)
                    <button type="submit" class="btn btn-primary">Перенести</button>
                @endif
                <br>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Выберите заявки</div>
                    <div class="card-body">
                        <table class="table table-hover text-nowrap table-responsive">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>
                                    <input type="checkbox" onchange="checkAll(this.checked)">
                                </th>
                                <th></th>
                                <th>Контрагент</th>
                                <th>ТТ</th>
                                <th>Статус</th>
                                <th>Торговый</th>
                                <th>сумма</th>
                                <th>возврат</th>
                                <th>процент Возврат</th>
                                <th>Дата создание</th>
                                <th>Дата доставки</th>
                                <th>тип оплаты</th>
                                <th>статус оплаты</th>
                                <th>версия</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr class="{{$order->deleted_at != null ?'bg-red':''}}">
                                    <td>{{$order->id}}</td>
                                    <td>
                                        <input class="order_checkbox" type="checkbox" name="orders[]"
                                               value="{{$order->id}}">
                                    </td>
                                    <td class="project-actions text-right">
                                        <a class="btn btn-primary btn-sm"
                                           href="{{route('admin.order.show',$order->id)}}">
                                            <i class="fas fa-folder">
                                            </i>

                                        </a>
                                        <a class="btn btn-info btn-sm" href="{{route('admin.order.edit',$order->id)}}">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                        </a>

                                    </td>
                                    <td>
                                        @if($order->store?->counteragent_id)
                                            <a href="{{route('admin.counteragent.show',$order->store->counteragent_id)}}">{{$order->store->counteragent->name}}</a>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{route('admin.store.show',$order->store_id)}}">{{$order->store?->name}}</a>
                                    </td>
                                    <td>{{$order->status->description}}</td>
                                    <td>
                                        <a href="{{route('admin.user.show',$order->salesrep_id)}}">{{$order->salesrep->name}}</a>
                                    </td>
                                    <td class="price">{{$order->purchase_price}}</td>
                                    <td class="price">{{$order->return_price}}</td>
                                    @if($order->return_price > 0)
                                        @if(($order->return_price / $order->purchase_price)*100 >= 60 )
                                            <th style="color: red">{{ round(($order->return_price / $order->purchase_price)*100)  }}
                                                %
                                            </th>
                                        @else
                                            <th>{{ round(($order->return_price / $order->purchase_price)*100)  }}%</th>
                                        @endif

                                    @else
                                        <td>0%</td>
                                    @endif
                                    <td>{{$order->created_at}}</td>
                                    <td>{{$order->delivery_date}}</td>
                                    <td>{{$order->paymentType->name}}</td>
                                    <td>{{$order->paymentStatus->name}}</td>
                                    <td>{{$order->salesrep_mobile_app_version}}</td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($to_driver_id)
                    <button type="submit" class="btn btn-primary">Перенести</button>
                @endif
            </div>

        </div>
    </form>
    <script>
        function checkAll(bool) {
            let inputs = document.getElementsByClassName('order_checkbox')
            for (let input of inputs) {
                input.checked = bool
            }
        }
    </script>
</div>
