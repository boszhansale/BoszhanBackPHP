@extends('admin.layouts.index')
@section('content')
    <form class="product-edit" action="{{route('admin.counteragent-group.store')}}" method="post"
          enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">название</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <button type="submit" class="mt-5 mb-10 btn btn-primary col-3 ">Сохранить</button>

            </div>
        </div>
    </form>
@endsection
