@extends('admin.layouts.index')

@section('content-header-title','Главная')


@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{$orderCount}}</h3>

                    <p>Заявки</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{route('admin.order.index')}}" class="small-box-footer">инфо <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{$storeCount}}</h3>

                    <p>Торговый точки</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{route('admin.store.index')}}" class="small-box-footer">инфо <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{$salesrepCount}}</h3>

                    <p>Торговые</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{route('admin.user.index')}}" class="small-box-footer">инфо <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{$driverCount}}</h3>
                    <p>Водители</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{route('admin.user.index')}}" class="small-box-footer">инфо <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>


    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    Топ 10 торговые
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <td>#</td>
                            <td>Торговый</td>
                            <td>Заявки</td>
                            <td>Сумма</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($topSalesrepsByOrder as $o)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td><a href="{{route('admin.user.show',$o->id)}}">{{$o->name}}</a></td>
                                <td>{{$o->order_count}}</td>
                                <td class="price">{{$o->order_price}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    Топ 10 продукт
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <td>#</td>
                            <td>Номенклатура</td>
                            <td>бренд</td>
                            <td>категория</td>
                            <td>количество</td>
                            <td>Заявки</td>
                            <td>Сумма</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($topProducts as $o)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td><a href="{{route('admin.product.show',$o->id)}}">{{$o->name}}</a></td>
                                <td>{{$o->brand_name}}</td>
                                <td>{{$o->category_name}}</td>
                                <td>{{$o->count}} {{$o->measureDescription()}}</td>
                                <td>{{$o->basket_count}}</td>
                                <td class="price">{{$o->all_price}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
