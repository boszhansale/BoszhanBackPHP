<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>торговый</th>
                <th>торговая точка</th>
                <th>выигрыш</th>
                <th>количество игр</th>
                <th>дата</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($games as $game)
                <tr>
                    <th>{{$game->id}}</th>
                    <th>
                        <a href="{{route('admin.user.show',$game->salesrep_id)}}"> {{$game->salesrep->name}}</a>
                    </th>
                    <th>
                        <a href="{{route('admin.store.show',$game->store_id)}}">    {{$game->store->name}}</a>
                    </th>
                    <th>
                        {{$game->total_win}}
                    </th>
                    <th>
                        {{$game->loops()->count()}}
                    </th>
                    <th>
                        {{$game->created_at->format('d.m.Y')}}
                    </th>

                    <td class="project-actions text-right">
                        {{--                        <a class="btn btn-info btn-sm" href="{{route('admin.category.edit',$category->id)}}">--}}
                        {{--                            <i class="fas fa-pencil-alt">--}}
                        {{--                            </i>--}}
                        {{--                            изменить--}}
                        {{--                        </a>--}}
                        <a class="btn btn-danger btn-sm" href="{{route('admin.game.delete',$game->id)}}"
                           onclick="return confirm('Удалить?')">
                            <i class="fas fa-trash"></i>
                            удалить
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

</div>
