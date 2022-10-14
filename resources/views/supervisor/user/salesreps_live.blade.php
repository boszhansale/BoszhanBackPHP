<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <label for="">поиск</label>
                    <input wire:model="search" type="search" name="search" placeholder="поиск" class="form-control">
                </div>
                <div class="col-md-2">
                    <input wire:model="start_date" type="date" class="form-control">
                    <input wire:model="end_date" type="date" class="form-control">
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
                    <th>Водитель</th>
                    <th>кол. заказов</th>
                    <th>кол. ТТ</th>
                    <th>Личный план</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <th>{{$user->id}}</th>
                        <td class="">
                            <a class="btn btn-primary btn-sm" href="{{route('supervisor.user.show',$user->id)}}">
                                <i class="fas fa-folder">
                                </i>
                            </a>
                        </td>
                        <th>{{$user->login}}</th>
                        <th><a href="{{route('supervisor.user.show',$user->id)}}">{{$user->name}}</a></th>
                        <th>{{$user->id_1c}}</th>
                        <th>
                            @if($user->driver)
                                <a href="{{route('supervisor.user.show',$user->driver->id)}}">{{$user->driver->name}}</a>
                            @endif
                        </th>

                        <th>{{$user->salesrepOrders()->whereBetween('created_at',[$start_date,$end_date])->count()}}</th>

                        <th>{{$user->stores->count()}}</th>
                        <th>
                            @if($user->planGroupUser)
                                <small class="price">{{$user->planGroupUser->plan}}</small>
                                <p class="price">{{$user->planGroupUser->completed}}</p>
                            @endif
                        </th>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
