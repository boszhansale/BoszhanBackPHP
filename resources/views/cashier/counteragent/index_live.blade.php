<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                    <input wire:model="search" type="search" name="search" placeholder="поиск" class="form-control">
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
                    <th>название</th>
                    <th>БИН</th>
                    <th>тип оплаты</th>
                    <th>цена</th>
                    <th>скидка</th>
                    <th>активность</th>
                    <th>долг</th>
                    <th>кол. ТТ</th>
                    <th>кол. заявок</th>
                </tr>
                </thead>
                <tbody>
                @foreach($counteragents as $counteragent)
                    <tr>
                        <th>{{$counteragent->id}}</th>
                        <th>
                            <a href="{{route('cashier.show',$counteragent->id)}}">
                                {{$counteragent->name}}
                            </a>
                        </th>
                        <th>{{$counteragent->bin}}</th>
                        <th>{{$counteragent->paymentType->name}}</th>
                        <th>{{$counteragent->priceType->name}}</th>
                        <th>{{$counteragent->discount}}</th>
                        <th>{{$counteragent->enabled}}</th>
                        <th class="price">{{$counteragent->debt()}}</th>
                        <th>{{$counteragent->stores()->count()}}</th>
                        <th>{{$counteragent->orders()->count()}}</th>

                        <td class="project-actions text-right">
                            <a class="btn btn-primary btn-sm" href="{{route('cashier.show',$counteragent->id)}}">
                                <i class="fas fa-folder">
                                </i>
                            </a>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
    {{$counteragents->links()}}
</div>
