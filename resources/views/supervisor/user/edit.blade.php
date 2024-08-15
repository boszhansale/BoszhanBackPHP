@extends('supervisor.layouts.index')
@section('content')
    <form class="product-edit" action="{{route('admin.user.update',$user->id)}}" method="post"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6">
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div>{{$error}}</div>
                    @endforeach
                @endif
                <div class="form-group">
                    <label for="">ФИО</label>
                    <input type="text" class="form-control" name="name" required value="{{$user->name}}">
                </div>

                <div class="form-group">
                    <label for="">Логин</label>
                    <input type="text" class="form-control" name="login" required value="{{$user->login}}">
                </div>

                <div class="form-group">
                    <label for="">Телефон номер</label>
                    <input type="text" class="form-control" name="phone" value="{{$user->phone}}">
                </div>

                <div class="form-group">
                    <label for="">Новый Пароль</label>
                    <input type="text" class="form-control" name="phone">
                </div>

                <div class="form-group">
                    <label for="">id_1c</label>
                    <input type="text" class="form-control" name="id_1c" value="{{$user->id_1c}}">
                </div>

                <div class="form-group">
                    <label for="">Инвентарный номер планшета</label>
                    <input type="text" class="form-control" name="inventory_number" value="{{$user->inventory_number}}">
                </div>
                <div class="form-group">
                    <label for="">Номер сим карты</label>
                    <input type="text" class="form-control" name="sim_number" value="{{$user->sim_number}}">
                </div>

                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="case"
                           {{$user->case ? 'checked' : ''}} value="1" id="case">
                    <label class="form-check-label" for="case">Чехол планшета</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="screen_security"
                           {{$user->screen_security ? 'checked' : ''}} value="1" id="screen_security">
                    <label class="form-check-label" for="screen_security">Пленка защиты</label>
                </div>


                <div class="row">
                    @if($user->role_id == 1)
                        <div class="form-group col-md-8">
                            <label for="">группа</label>
                            <select name="plan_group_id" class="form-control" required>
                                @foreach($planGroups as $planGroup)
                                    <option
                                        {{$user->planGroupUser->plan_group_id == $planGroup->id ? 'selected':''}} value="{{$planGroup->id}}">{{$planGroup->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-8">
                            <label for="">личный план</label>
                            <input type="number" value="{{$user->planGroupUser ? $user->planGroupUser->plan :''}}"
                                   class="form-control" name="plan" required>
                        </div>

                        @foreach($user->brandPlans as $k => $brandPlan)

                            <div class="form-group col-md-6">
                                <label for="">план {{$brandPlan->brand->name}}</label>
                                <input type="hidden" name="brand_plans[{{$k}}][brand_plan_id]"
                                       value="{{$brandPlan->id}}" required>
                                <input type="number" class="form-control" name="brand_plans[{{$k}}][plan]"
                                       value="{{$brandPlan->plan}}" required>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input"
                           {{$user->winning_access ? 'checked' : ''}} name="winning_access" value="1"
                           id="winning_access">
                    <label class="form-check-label" for="winning_access">winning_access</label>
                </div>

                <div class="form-check">
                    <input type="checkbox" class="form-check-input {{$user->payout_access ? 'checked' : ''}}"
                           name="payout_access" value="1" id="payout_access">
                    <label class="form-check-label" for="payout_access">payout_access</label>
                </div>

            </div>
            @if($user->role_id == 1)
                <div class="col-md-3">
                    <h6 class="">Водитель</h6>
                    <div>
                        @foreach($drivers as $driver)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input"
                                       {{$user->drivers()->where('driver_id',$driver->id)->exists() ? 'checked' : ''}} name="drivers[]"
                                       value="{{$driver->id}}" id="driver_{{$driver->id}}">
                                <label class="form-check-label" for="driver_{{$driver->id}}">{{$driver->name}}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-3">
                    <h6 class="">ТТ</h6>
                    <div>
                        @foreach($counteragents as $counteragent)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input"
                                       {{$user->counteragents()->where('counteragent_id',$counteragent->id)->exists() ? 'checked' : ''}} name="counteragents[]"
                                       value="{{$counteragent->id}}" id="counteragent_{{$counteragent->id}}">
                                <label class="form-check-label"
                                       for="counteragent_{{$counteragent->id}}">{{$counteragent->name}}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($user->role_id == 2)
                <div class="col-md-3">
                    <h6 class="">Торговые</h6>
                    <div>
                        @foreach($salesreps as $salesrep)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input"
                                       {{$user->salesreps()->where('users.id',$salesrep->id)->exists() ? 'checked' : ''}} name="salesreps[]"
                                       value="{{$salesrep->id}}" id="salesrep_{{$salesrep->id}}">
                                <label class="form-check-label"
                                       for="salesrep_{{$salesrep->id}}">{{$salesrep->name}}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            @if($user->role_id == 8)
                <div class="col-md-3">
                    <h6 class="">Торговые</h6>
                    <div>
                        @foreach($salesreps as $salesrep)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input"
                                       {{$user->supervisorsSalesreps()->where('users.id',$salesrep->id)->exists() ? 'checked' : ''}} name="supervisor_salesreps[]"
                                       value="{{$salesrep->id}}" id="supervisor_salesrep_{{$salesrep->id}}">
                                <label class="form-check-label"
                                       for="supervisor_salesrep_{{$salesrep->id}}">{{$salesrep->name}}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif


        </div>
        <button type="submit" class="mt-5 mb-10 btn btn-primary col-3 ">Сохранить</button>
    </form>
@endsection
