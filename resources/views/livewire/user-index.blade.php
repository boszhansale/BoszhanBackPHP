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
                    <th>ФИО</th>
                    <th>Логин</th>
                    <th>Роль</th>
                    <th>Личный план</th>
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
                            <a class="btn btn-info btn-sm" href="{{route('admin.user.edit',$user->id)}}">
                                <i class="fas fa-pencil-alt">
                                </i>
                            </a>
                            <a  class="btn btn-danger btn-sm" href="{{route('admin.user.delete',$user->id)}}" onclick="return confirm('Удалить?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                        <th>
                            {{$user->name}}
                        </th>
                        <th>
                            {{$user->login}}
                        </th>
                        <th>
                            @foreach($user->roles as $role)
                                <small>{{$role->description}}</small>
                            @endforeach
                        </th>
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
