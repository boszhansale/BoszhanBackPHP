@extends('admin.layouts.index')

@section('content-header-title','Торговые')
@section('content-header-right')
    @if(Auth::user()->permissionExists('user_create'))
        <a href="{{route('admin.user.create',1)}}" class="btn btn-info btn-sm  ">создать торговый</a>

    @endif

    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModal">
        скачать статистику
    </button>

    <form action="{{route('admin.user.statisticByOrderExcel')}}" method="post">
        @csrf
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Выберите дату</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col">
                                <label for="">от</label>
                                <input type="date" name="from" class="form-control"
                                       value="{{now()->startOfMonth()->format('Y-m-d')}}">
                            </div>
                            <div class="form-group col">
                                <label for="">до</label>
                                <input type="date" name="to" class="form-control"
                                       value="{{now()->format('Y-m-d')}}">
                            </div>
                        </div>
                        @foreach($salesreps as $user)
                            <div>
                                <input type="checkbox" name="users[]" id="user_label_{{$user->id}}"
                                       value="{{$user->id}}" checked>
                                <label for="user_label_{{$user->id}}">{{$user->name}}</label>
                            </div>
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-primary">Скачать</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('content')
    <livewire:salesrep-index/>
@endsection
