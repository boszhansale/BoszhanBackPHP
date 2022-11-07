@extends('cashier.layouts.index')

@section('content-header-title',$counteragent->name)

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body ">
                    <table class="table table-bordered">
                        <tr>
                            <td>id_1c</td>
                            <td>{{$counteragent->id_1c}}</td>
                        </tr>
                        <tr>
                            <td>bin</td>
                            <td>{{$counteragent->bin}}</td>
                        </tr>
                        <tr>
                            <td>тип оплаты</td>
                            <td>{{$counteragent->paymentType->name}}</td>
                        </tr>
                        <tr>
                            <td>категория цен</td>
                            <td>{{$counteragent->pricetype->name}}</td>
                        </tr>
                        <tr>
                            <td>скидка</td>
                            <td>{{$counteragent->discount}}</td>
                        </tr>
                        <tr>
                            <td>активность</td>
                            <td>{{$counteragent->enabled}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body ">
                    <table class="table table-bordered">
                        <tr>
                            <td>долг</td>
                            <td class="price">{{$counteragent->debt()}}</td>
                        </tr>
                        <tr>
                            <td>количество ТТ</td>
                            <td>{{$counteragent->stores()->count()}}</td>
                        </tr>
                        <tr>
                            <td>количество заявок</td>
                            <td>
                                <a href="{{route('cashier.order.counteragent',$counteragent->id)}}">{{$counteragent->orders()->count()}}</a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="row justify-content-between">
                <h4>История баланса</h4>

                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-lg">
                    добавить
                </button>
            </div>

        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>долг</th>
                    <th>оплата</th>
                    <th>разница</th>
                    <th>коммент</th>
                    <th>дата</th>
                </tr>
                </thead>
                <tbody>
                @foreach($operations as $operation)
                    <tr>
                        <td>{{$operation->debt}}</td>
                        <td>{{$operation->balance}}</td>
                        <td>{{$operation->balance}}</td>
                        <td>{{$operation->comment}}</td>
                        <td>{{$operation->created_at}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modal-lg" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{route('cashier.add-balance')}}" method="post">
                    @csrf
                    <input type="hidden" name="counteragent_id" value="{{$counteragent->id}}">
                    <div class="modal-header">
                        {{$counteragent->name}}
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Долг : <span class="price">{{$counteragent->debt()}}</span> </label>
                            <input type="hidden" name="debt" value="{{$counteragent->debt()}}">
                        </div>
                        <div class="form-group">
                            <label for="">Сумма *</label>
                            <input type="number" class="form-control" name="balance" required>
                        </div>


                        <div class="form-group">
                            <textarea name="comment" class="form-control" cols="20" rows="5"
                                      placeholder="комментария"></textarea>
                        </div>
                        <h6>ответственный лицо: {{Auth::user()->name}}</h6>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">отмена</button>
                        <button type="submit" class="btn btn-primary">добавить</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection
