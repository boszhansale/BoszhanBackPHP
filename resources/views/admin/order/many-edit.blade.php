@extends('admin.layouts.index')
@section('content')
    <form class="product-edit" action="{{route('admin.order.many-update')}}" method="post"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @foreach($orders  as $order_id)
            <input type="hidden" name="orders[]" value="{{$order_id}}">
        @endforeach

        <div class="row">
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div>{{$error}}</div>
                @endforeach
            @endif
            <div class="col-md-6">

                <div class="form-group">
                    <label for="">Торговый представитель</label>
                    <select name="salesrep_id" class="form-control" >
                        <option value=""></option>
                        @foreach($salesreps as $salesrep)
                            <option value="{{$salesrep->id}}">{{$salesrep->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Водитель</label>
                    <select name="driver_id" class="form-control" >
                        <option value=""></option>
                        @foreach($drivers as $driver)
                            <option value="{{$driver->id}}">{{$driver->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Статус</label>
                    <select name="status_id" class="form-control" >
                        <option value=""></option>
                        @foreach($statuses as $status)
                            <option value="{{$status->id}}">{{$status->description}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Тип оплаты</label>
                    <select name="payment_type_id" class="form-control" >
                        <option value=""></option>
                        @foreach($paymentTypes as $paymentType)
                            <option value="{{$paymentType->id}}">{{$paymentType->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Статус оплаты</label>
                    <select name="payment_status_id" class="form-control" >
                        <option value=""></option>
                        @foreach($paymentStatuses as $paymentStatus)
                            <option value="{{$paymentStatus->id}}">{{$paymentStatus->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Дата доставки</label>
                    <input type="date" name="delivery_date" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Дата доставлено</label>
                    <input type="datetime-local" name="delivered_date" class="form-control">
                </div>


            </div>

        </div>
        <button type="submit" class="mt-5 mb-10 btn btn-primary col-3 ">Сохранить</button>
    </form>
@endsection
