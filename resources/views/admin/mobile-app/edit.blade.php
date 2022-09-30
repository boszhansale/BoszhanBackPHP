@extends('admin.layouts.index')
@section('content')
    <form class="product-edit" action="{{route('admin.mobile-app.update',$mobileApp->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">

                <div class="form-group">
                    <label for="">Версия</label>
                    <select name="status" class="form-control">
                        <option {{$mobileApp->status == 1 ? 'selected':''}} value="1">Новая</option>
                        <option {{$mobileApp->status == 2 ? 'selected':''}} value="2">Тестируется</option>
                        <option {{$mobileApp->status == 3 ? 'selected':''}} value="3">В продакшн</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Версия</label>
                    <input type="number" class="form-control" name="version" value="{{$mobileApp->version}}" step="0.1" required>
                </div>

                <div class="form-group">
                    <label for="">комментарии</label>
                    <textarea name="comment" class="form-control">{{$mobileApp->comment}}</textarea>
                </div>


            </div>
        </div>
        <button type="submit" class="mt-5 mb-10 btn btn-primary col-3 ">Сохранить</button>
    </form>
@endsection
