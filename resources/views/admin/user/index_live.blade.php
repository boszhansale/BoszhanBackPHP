<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <label for="">поиск</label>
                    <input wire:model="search" type="search" name="search" placeholder="поиск" class="form-control">
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">роли</label>
                        <select wire:model="roleId" name="" class="form-control">
                            <option value="">все</option>
                            @foreach(\App\Models\Role::all() as $role)
                                <option value="{{$role->id}}">{{$role->description}}</option>
                            @endforeach
                        </select>
                    </div>
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
                    <th>Роль</th>
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
                                <a class="btn btn-danger btn-sm" href="{{route('admin.user.delete',$user->id)}}"
                                   onclick="return confirm('Удалить?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            @endif
                        </td>
                        <th>{{$user->login}}</th>
                        <th>{{$user->name}}</th>
                        <th>{{$user->id_1c}}</th>
                        <th>
                            <small>{{$user->role->description}}</small>
                        </th>
                        <th>
                            @if($user->status == 1)
                                <button wire:click="statusChange({{$user->id}},2)" class="btn btn-primary">работает
                                </button>
                            @else
                                <button wire:click="statusChange({{$user->id}},1)" class="btn btn-danger">не работает
                                </button>

                            @endif
                        </th>


                    </tr>
                @endforeach
                </tbody>
            </table>
            {{$users->links()}}

        </div>
    </div>
</div>
