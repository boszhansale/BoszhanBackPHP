@extends('admin.layouts.index')
@section('content')
    <form class="product-edit" action="{{route('admin.mobile-app.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Приложения</label>
                    <select name="type" class="form-control">
                        <option {{$type == 1 ? 'selected' : ''}} value="1">Торговый</option>
                        <option {{$type == 2 ? 'selected' : ''}} value="2">Водительский</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Версия</label>
                    <input type="number" class="form-control" name="version" value="{{$version}}" step="0.1" required>
                </div>

                <div class="form-group">
                    <label for="">комментарии</label>
                    <textarea name="comment" class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <label for="">Апк</label>
                    <input type="file" class="form-control" name="app" required>
                </div>


            </div>
        </div>
        <button type="submit" class="mt-5 mb-10 btn btn-primary col-3 ">Сохранить</button>
    </form>
@endsection
