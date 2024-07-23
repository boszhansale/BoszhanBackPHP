<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                    <small>поиск</small>
                    <input wire:model="search" type="search" name="search" placeholder="поиск" class="form-control">
                </div>

                <div class="col-md-2">
                    <small>торговый</small>

                    <select wire:model="salesrepId" class="form-control">
                        <option value="">все торговые</option>
                        @foreach($salesreps as $salesrep)
                            <option value="{{$salesrep->id}}">{{$salesrep->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <small>даты создания заявки</small>
                    <input wire:model="start_created_at" type="date" required
                           class="form-control">
                    <input wire:model="end_created_at" type="date" required class="form-control">
                </div>
                <div class="col-md-2">
                    <br>
                    <a href="{{route('admin.refund.excel',['search' => $search,'storeId' => $storeId,'salesrepId' => $salesrepId,'start_created_at' => $start_created_at,'end_created_at' => $end_created_at])}}"
                       class="btn btn-default">скачать excel</a>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-hover text-nowrap table-responsive">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>ТТ</th>
                    <th>Торговый</th>
                    <th>продукт</th>
                    <th>категория точки</th>
                    <th>продажа</th>
                    <th>количество</th>
                    <th>ед. изм.</th>
                    <th>сумма продаж</th>
                    <th>сумма возврата</th>
                    <th>причина возврата</th>
                    <th>Дата создание</th>
                </tr>
                </thead>
                <tbody>
                @foreach($refunds as $refund)

                    <tr>
                        <td>{{$refund->id}}</td>
                        <td>
                            <a href="{{route('admin.store.show',$refund->store_id)}}">{{$refund->store?->name}}</a>
                        </td>
                        <td>
                            <a href="{{route('admin.user.show',$refund->salesrep_id)}}">{{$refund->salesrep->name}}</a>
                        </td>
                        <td>{{$refund->name}}</td>
                        <td>{{$refund->store->counteragent?->priceType?->name ?? 'BC'}}</td>
                        <td>{{$query->clone()->where('products.id',$refund->product_id)->where('stores.id',$refund->store_id)->sum('baskets.count')}}</td>
                        <td>{{$refund->count}}</td>
                        <td>{{$refund->measure == 1 ? 'шт' : 'кг'}}</td>
                        <td class="price">{{$query->clone()->where('products.id',$refund->product_id)->where('stores.id',$refund->store_id)->sum('baskets.price')}}</td>
                        <td class="price">{{$refund->price}}</td>
                        <td>{{$refund->title}}</td>
                        <td>{{$refund->created_at}}</td>

                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
    {{$refunds->links()}}
</div>
