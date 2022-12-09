<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                    <input wire:model="search" type="search" name="search" placeholder="поиск" class="form-control">
                </div>

                <div class="col-md-2">
                    <select wire:model="salesrepId" class="form-control">
                        <option value="">все торговые</option>
                        @foreach($salesreps as $salesrep)
                            <option value="{{$salesrep->id}}">{{$salesrep->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select wire:model="counteragentId" class="form-control">
                        <option value="">все контрагенты</option>
                        @foreach($counteragents as $counteragent)
                            <option value="{{$counteragent->id}}">{{$counteragent->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input wire:model="start_date" type="date" class="form-control">
                    <input wire:model="end_date" type="date" class="form-control">
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            Количество торговых точек: <b>{{$store_count}}</b>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Название</th>
                    <th>Контрагент</th>
                    <th>Телефон</th>
                    <th>ТП</th>
                    <th>БИН</th>
                    <th>id_1c</th>
                    <th>id_edi</th>
                    <th>скидка %</th>
                    <th>кол заявок</th>
                    <th>долг</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($stores as $store)
                    <tr>
                        <th>{{$store->id}}</th>
                        <th>
                            <b>{{$store->name}}</b><br>
                            <small>{{$store->address}}</small>
                        </th>
                        <td>
                            {{$store->counteragent?->name}}
                        </td>
                        <td>
                            {{$store->phone}}
                        </td>
                        <td>
                            {{$store->salesrep?->name}}
                        </td>


                        <td>
                            {{$store->bin}}
                        </td>
                        <td>
                            {{$store->id_1c}}
                        </td>
                        <td>
                            {{$store->id_edi}}
                        </td>

                        <td>
                            {{$store->discount}}
                        </td>
                        <td>
                            {{$store->orders()->count()}}
                        </td>
                        <td> {{$store->orders()->where('payment_status_id',2)->sum('purchase_price') - $store->orders()->where('payment_status_id',1)->sum('purchase_price')}}</td>


                        <td class="project-actions text-right">
                            <a class="btn btn-primary btn-sm" href="{{route('admin.store.show',$store->id)}}">
                                <i class="fas fa-folder">
                                </i>
                            </a>
                            <a class="btn btn-info btn-sm" href="{{route('admin.store.edit',$store->id)}}">
                                <i class="fas fa-pencil-alt">
                                </i>
                            </a>
                            {{--                            <a  class="btn btn-danger btn-sm" href="{{route('admin.store.delete',$store->id)}}" onclick="return confirm('Удалить?')">--}}
                            {{--                                <i class="fas fa-trash"></i>--}}
                            {{--                            </a>--}}

                            <button class="btn btn-danger btn-sm" wire:click="delete({{$store->id}})"
                                    onclick="return confirm('Удалить?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
    {{$stores->links()}}
</div>
