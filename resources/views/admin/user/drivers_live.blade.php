<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <label for="">поиск</label>
                    <input wire:model="search" type="search" name="search" placeholder="поиск" class="form-control">
                </div>
                <div class="col-md-2">
                    <input wire:model="start_date"  type="date" class="form-control">
                    <input wire:model="end_date"  type="date" class="form-control">
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th></th>
                    <th>Логин</th>
                    <th>ФИО</th>
                    <th>ID_1C</th>
                    <th>Кол. заявок</th>
                    <th>Кол. закрытых заявок</th>
                    <th>Кол. не закрытых заявок</th>
                    <th>Закрыто заявок нал</th>
                    <th>Закрыто заявок без нал</th>
                    <th>Закрыто заявок каспи</th>
                    <th>Процент закрытых заявок</th>
                    <th>Статус</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <th>{{$user->id}}</th>
                        <td class="">
                            <a class="btn btn-primary btn-sm" href="{{route('admin.user.show',$user->id)}}">
                                <i class="fas fa-folder">
                                </i>
                            </a>
                            @if(Auth::user()->permissionExists('user_edit'))
                            <a class="btn btn-info btn-sm" href="{{route('admin.user.edit',$user->id)}}">
                                <i class="fas fa-pencil-alt">
                                </i>
                            </a>
                            @endif
                            @if(Auth::user()->permissionExists('user_delete'))
                                <a  class="btn btn-danger btn-sm" href="{{route('admin.user.delete',$user->id)}}" onclick="return confirm('Удалить?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            @endif

                        </td>
                        <th>{{$user->login}}</th>
                        <th>{{$user->name}}</th>
                        <th>{{$user->id_1c}}</th>
                        <th>{{$user->driverOrders()->whereBetween('delivery_date',[$start_date,$end_date])->count()}}</th>
                        <th>{{$user->driverOrders()->whereBetween('delivery_date',[$start_date,$end_date])->where('status_id',3)->count()}}</th>
                        <th>{{$user->driverOrders()->whereBetween('delivery_date',[$start_date,$end_date])->where('status_id',2)->count()}}</th>

                        <th class="price">{{$user->driverOrders()->whereBetween('delivery_date',[$start_date,$end_date])->where('status_id',3)->where('payment_type_id',1)->sum('purchase_price')}}</th>
                        <th class="price">{{$user->driverOrders()->whereBetween('delivery_date',[$start_date,$end_date])->where('status_id',3)->where('payment_type_id',2)->sum('purchase_price')}}</th>
                        <th class="price">{{$user->driverOrders()->whereBetween('delivery_date',[$start_date,$end_date])->where('status_id',3)->where('payment_type_id',4)->sum('purchase_price')}}</th>

                        @if($user->driverOrders()->whereBetween('delivery_date',[$start_date,$end_date])->where('status_id',3)->count() > 0)
                            <th>{{ round(
                                        (
                                         $user->driverOrders()->whereBetween('delivery_date',[$start_date,$end_date])->where('status_id',3)->count()

                                        /
                                          $user->driverOrders()->whereBetween('delivery_date',[$start_date,$end_date])->count()
                                        ) * 100 )
                                    }}%</th>
                        @else
                            <th>0%</th>
                        @endif


                        <th>
                            @if($user->status == 1)
                                <button wire:click="statusChange({{$user->id}},2)" class="btn btn-primary">работает</button>
                            @else
                                <button wire:click="statusChange({{$user->id}},1)" class="btn btn-danger">не работает</button>

                            @endif
                        </th>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
