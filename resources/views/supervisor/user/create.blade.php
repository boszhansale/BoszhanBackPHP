@extends('supervisor.layouts.index')
@section('content')
    <form class="product-edit" action="{{route('admin.user.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="role_id" value="{{$roleId}}">
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div>{{$error}}</div>
            @endforeach
        @endif
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">ФИО</label>
                    <input type="text" class="form-control" name="name" required>
                </div>

                <div class="form-group">
                    <label for="">Логин</label>
                    <input type="text" class="form-control" name="login" required>
                </div>

                <div class="form-group">
                    <label for="">Телефон номер</label>
                    <input type="text" class="form-control" name="phone">
                </div>

                <div class="form-group">
                    <label for="">Пароль</label>
                    <input type="text" class="form-control" name="password" value="123456">
                </div>

                <div class="form-group">
                    <label for="">id_1c</label>
                    <input type="text" class="form-control" name="id_1c" value="{{$id_1c}}">
                </div>
                @if($roleId == 1)
                    <div class="form-group">
                        <label for="">население</label>
                        <input type="text" class="form-control" name="counterparty" value="население ">
                    </div>
                @endif
                @if($roleId == 1 OR $roleId == 2)

                    <div class="form-group">
                        <label for="">Инвентарный номер планшета</label>
                        <input type="text" class="form-control" name="inventory_number">
                    </div>
                    <div class="form-group">
                        <label for="">Номер сим карты</label>
                        <input type="text" class="form-control" name="sim_number">
                    </div>


                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="case" value="1" id="case">
                        <label class="form-check-label" for="case">Чехол планшета</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="screen_security" value="1"
                               id="screen_security">
                        <label class="form-check-label" for="screen_security">Пленка защиты</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="winning_access" value="1"
                               id="winning_access">
                        <label class="form-check-label" for="winning_access">winning_access</label>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="payout_access" value="1"
                               id="payout_access">
                        <label class="form-check-label" for="payout_access">payout_access</label>
                    </div>

                @endif

                <div class="row">
                    @if($roleId == 1)

                        <div class="form-group col-md-8">
                            <label for="">группа</label>
                            <select name="plan_group_id" class="form-control" required>
                                @foreach($planGroups as $planGroup)
                                    <option value="{{$planGroup->id}}">{{$planGroup->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-8">
                            <label for="">личный план</label>
                            <input type="number" class="form-control" name="plan" required>
                        </div>
                        @foreach($brands as $k => $brand)

                            <div class="form-group col-md-6">
                                <label for="">план {{$brand->name}}</label>
                                <input type="hidden" name="brand_plans[{{$k}}][brand_id]" value="{{$brand->id}}"
                                       required>
                                <input type="number" class="form-control" name="brand_plans[{{$k}}][plan]" value="0"
                                       required>
                            </div>
                        @endforeach
                    @endif
                </div>


            </div>
            @if($roleId == 2)
                <div class="col-md-3">
                    <h6 class="">Торговые</h6>
                    <div>
                        @foreach($salesreps as $salesrep)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="salesreps[]"
                                       value="{{$salesrep->id}}" id="salesrep_{{$salesrep->id}}">
                                <label class="form-check-label"
                                       for="salesrep_{{$salesrep->id}}">{{$salesrep->name}}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            @if($roleId == 1)
                <div class="col-md-3">
                    <h6 class="">Водитель</h6>
                    <div>
                        @foreach($drivers as $driver)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="drivers[]" value="{{$driver->id}}"
                                       id="driver_{{$driver->id}}">
                                <label class="form-check-label" for="driver_{{$driver->id}}">{{$driver->name}}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        <button type="submit" class="mt-5 mb-10 btn btn-primary col-3 ">Сохранить</button>
    </form>
@endsection
