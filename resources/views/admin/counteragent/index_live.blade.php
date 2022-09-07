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
                    <th>id_1c</th>
                    <th>БИН</th>
                    <th>тип оплаты</th>
                    <th>цена</th>
                    <th>скидка</th>
                    <th>активность</th>
                    <th>долг</th>
                    <th>кол. ТТ</th>
                    <th>доставить до</th>
                </tr>
                </thead>
                <tbody>
                @foreach($counteragents as $counteragent)
                    <tr>
                        <th>{{$counteragent->id}}</th>
                        <th>
                            <a href="{{route('admin.counteragent.show',$counteragent->id)}}">
                                {{$counteragent->name}}
                            </a>
                        </th>
                        <th>{{$counteragent->id_1c}}</th>
                        <th>{{$counteragent->bin}}</th>
                        <th>{{$counteragent->paymentType->name}}</th>
                        <th>{{$counteragent->priceType->name}}</th>
                        <th>{{$counteragent->discount}}</th>
                        <th>{{$counteragent->enabled}}</th>
                        <th class="price">{{$counteragent->debt()}}</th>
                        <th>{{$counteragent->stores()->count()}}</th>
                        <th>{{$counteragent->delivery_time}}</th>

                        <td class="project-actions text-right">
                            <a class="btn btn-primary btn-sm" href="{{route('admin.counteragent.show',$counteragent->id)}}">
                                <i class="fas fa-folder">
                                </i>
                            </a>
                            <a class="btn btn-info btn-sm" href="{{route('admin.counteragent.edit',$counteragent->id)}}">
                                <i class="fas fa-pencil-alt">
                                </i>
                            </a>
                            <a  class="btn btn-danger btn-sm" href="{{route('admin.counteragent.delete',$counteragent->id)}}" onclick="return confirm('Are you sure?')">
                                <i class="fas fa-trash"></i>
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
