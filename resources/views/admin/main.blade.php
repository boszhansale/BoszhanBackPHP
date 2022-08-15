@extends('admin.layouts.index')

@section('content-header-title','Главная')


@section('content')
    <div class="row">
        <div class="col-lg-2 col-6">
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
        <div class="col-lg-2 col-6">
            <!-- small box -->
            <div class="small-box bg-orange">
                <div class="inner">
                    <h3>{{$counteragentCount}}</h3>

                    <p>Контрагенты</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{route('admin.counteragent.index')}}" class="small-box-footer">инфо <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-2 col-6">
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
        <div class="col-lg-2 col-6">
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
        <div class="col-lg-2 col-6">
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
        <div class="col-lg-2 col-6">
            <!-- small box -->
            <div class="small-box bg-indigo">
                <div class="inner">
                    <h3>{{$productCount}}</h3>
                    <p>Продукты</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{route('admin.product.index')}}" class="small-box-footer">инфо <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>


    <div class="row">
        <div class="col-lg-12">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Статистика по дням</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="stackedBarWeek" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Статистика за последний 6 месяц</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="stackedBarChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card card-primary collapsed-card">
                <div class="card-header" data-card-widget="collapse">
                    <h3 class="card-title">Топ 10 торговые за {{$monthName}}</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body" style="display: none">
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
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>


        <div class="col-lg-12">
            <div class="card card-primary collapsed-card">
                <div class="card-header" data-card-widget="collapse">
                    Топ 10 продукт за {{$monthName}}
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
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


@section('js')

    <script>




            ///Month
            var areaChartData = {
                labels  : JSON.parse('{!! json_encode($months) !!}'),
                datasets: [
                    {
                        label               : 'Продажа',
                        backgroundColor     : 'rgba(60,141,188,0.9)',
                        borderColor         : 'rgba(60,141,188,0.8)',
                        pointRadius          : true,
                        pointColor          : '#3b8bba',
                        pointStrokeColor    : 'rgba(60,141,188,1)',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data                : JSON.parse(' {!! json_encode($monthPurchasePrices) !!} ')
                    },
                    {
                        label               : 'Возврат',
                        backgroundColor     : 'rgba(210, 214, 222, 1)',
                        borderColor         : 'rgba(210, 214, 222, 1)',
                        pointRadius         : false,
                        pointColor          : 'rgba(210, 214, 222, 1)',
                        pointStrokeColor    : '#c1c7d1',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data                : JSON.parse(' {!! json_encode($monthReturnPrices) !!} ')
                    },
                ]
            }

            var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')

            var stackedBarChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                scales: {
                    xAxes: [{
                        stacked: true,
                    }],
                    yAxes: [{
                        stacked: true
                    }]
                }
            }

            new Chart(stackedBarChartCanvas, {
                type: 'bar',
                data: areaChartData,
                options: stackedBarChartOptions
            })




            var areaChartData = {
                labels  : JSON.parse('{!! json_encode($weeks) !!}'),
                datasets: [
                    {
                        label               : 'Продажа',
                        backgroundColor     : 'rgba(60,141,188,0.9)',
                        borderColor         : 'rgba(60,141,188,0.8)',
                        pointRadius          : true,
                        pointColor          : '#3b8bba',
                        pointStrokeColor    : 'rgba(60,141,188,1)',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data                : JSON.parse(' {!! json_encode($weekPurchasePrices) !!} ')
                    },
                    {
                        label               : 'Возврат',
                        backgroundColor     : 'rgba(210, 214, 222, 1)',
                        borderColor         : 'rgba(210, 214, 222, 1)',
                        pointRadius         : false,
                        pointColor          : 'rgba(210, 214, 222, 1)',
                        pointStrokeColor    : '#c1c7d1',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data                : JSON.parse(' {!! json_encode($weekReturnPrices) !!} ')
                    },
                ]
            }

            var stackedBarChartCanvas = $('#stackedBarWeek').get(0).getContext('2d')

            var stackedBarChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                scales: {
                    xAxes: [{
                        stacked: true,
                    }],
                    yAxes: [{
                        stacked: true
                    }]
                }
            }

            new Chart(stackedBarChartCanvas, {
                type: 'bar',
                data: areaChartData,
                options: stackedBarChartOptions
            })


    </script>
@endsection
