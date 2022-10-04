@extends('admin.layouts.index')
@section('content')
    <form class="product-edit" action="{{route('admin.store.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">название</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="form-group">
                    <label for="">Телефон номер</label>
                    <input type="text" class="form-control" name="phone" >
                </div>
                <div class="form-group">
                    <label for="">id_1c</label>
                    <input type="text" class="form-control" name="id_1c" >
                </div>
                <div class="form-group">
                    <label for="">БИН</label>
                    <input type="text" class="form-control" name="bin" >
                </div>
                <div class="form-group">
                    <label for="">Адрес</label>
                    <input type="text" class="form-control" name="address" >
                </div>
                <div class="row">
                    <div class="col form-group">
                        <label for="">lat</label>
                        <input type="text" class="form-control" name="lat" >
                    </div>
                    <div class="col form-group">
                        <label for="">lng</label>
                        <input type="text" class="form-control" name="lng" >
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Скидка %</label>
                    <input type="text" class="form-control" name="discount" value="0" >
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="enabled" value="1" id="enabled" checked>
                    <label class="form-check-label" for="enabled">активный</label>
                </div>
                <br>
                <div class="form-group">
                    <label for="">Контрагент</label>
                    <select name="counteragent_id" class="form-control">
                        @foreach($counteragents as $counteragent)
                            <option value="{{$counteragent->id}}">{{$counteragent->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Торговый</label>
                    <select name="salesrep_id" class="form-control">
                        @foreach($salesreps as $salesrep)
                            <option value="{{$salesrep->id}}">{{$salesrep->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Водитель</label>
                    <select name="driver_id" class="form-control">
                    <option value="null">----</option>

                    @foreach($drivers as $driver)
                            <option value="{{$driver->id}}">{{$driver->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <button type="submit" class="mt-5 mb-10 btn btn-primary col-3 ">Сохранить</button>
    </form>
@endsection
