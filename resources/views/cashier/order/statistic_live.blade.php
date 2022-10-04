<div>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">  по торговым точкам</div>
                <div class="col">
                   <div class="row justify-content-end">
                       <div class="form-group">
                           <input wire:model="start_date_return_order_store" type="date" class="form-control">
                       </div>
                       <div class="form-group">
                           <input wire:model="end_date_return_order_store" type="date" class="form-control">
                       </div>
                   </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    Продажи
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>ТТ</th>
                            <th>сумма</th>
                            <th>количество </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orderStores as $store)
                            <tr>
                                <td>
                                    <a href="{{route('admin.store.show',$store->id)}}">{{$store->name}}</a>
                                </td>
                                <td class="price">{{$store->sum}}</td>
                                <td>{{$store->orders_count}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    Возвраты
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>ТТ</th>
                            <th>сумма</th>
                            <th>количество </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($returnOrderStores as $store)
                            <tr>
                                <td>
                                    <a href="{{route('admin.store.show',$store->id)}}">{{$store->name}}</a>
                                </td>
                                <td class="price">{{$store->sum}}</td>
                                <td>{{$store->orders_count}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">  по торговым представителям</div>
                <div class="col">
                   <div class="row justify-content-end">
                       <div class="form-group">
                           <input wire:model="start_date_return_order_salesrep" type="date" class="form-control">
                       </div>
                       <div class="form-group">
                           <input wire:model="end_date_return_order_salesrep" type="date" class="form-control">
                       </div>
                   </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    Продажи
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>ТП</th>
                            <th>сумма</th>
                            <th>количество </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orderSalesreps as $salesrep)
                            <tr>
                                <td>
                                    <a href="{{route('admin.user.show',$salesrep->id)}}">{{$salesrep->name}}</a>
                                </td>
                                <td class="price">{{$salesrep->sum}}</td>
                                <td>{{$salesrep->orders_count}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    Возвраты
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>ТТ</th>
                            <th>сумма</th>
                            <th>количество </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($returnOrderSalesreps as $store)
                            <tr>
                                <td>
                                    <a href="{{route('admin.store.show',$store->id)}}">{{$store->name}}</a>
                                </td>
                                <td class="price">{{$store->sum}}</td>
                                <td>{{$store->orders_count}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">  по Продуктам</div>
                <div class="col">
                   <div class="row justify-content-end">
                       <div class="form-group">
                           <input wire:model="start_date_return_order_product" type="date" class="form-control">
                       </div>
                       <div class="form-group">
                           <input wire:model="end_date_return_order_product" type="date" class="form-control">
                       </div>
                   </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    Продажи
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>ТП</th>
                            <th>сумма</th>
                            <th>количество </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orderProducts as $product)
                            <tr>
                                <td>
                                    <a href="{{route('admin.product.show',$product->id)}}">{{$product->name}}</a>
                                </td>
                                <td class="price">{{$product->sum}}</td>
                                <td>{{$product->orders_count}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    Возвраты
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>ТТ</th>
                            <th>сумма</th>
                            <th>количество </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($returnOrderProducts as $product)
                            <tr>
                                <td>
                                    <a href="{{route('admin.product.show',$product->id)}}">{{$product->name}}</a>
                                </td>
                                <td class="price">{{$product->sum}}</td>
                                <td>{{$product->orders_count}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
