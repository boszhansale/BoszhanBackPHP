@extends('admin.layouts.index')
@section('content')
    <form class="product-edit" action="{{route('admin.role.update',$role->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Роль EN</label>
                    <input type="text" class="form-control" name="name" required  value="{{$role->name}}">
                </div>
                <div class="form-group">
                    <label for="">Описание RU</label>
                    <input type="text" class="form-control" name="description" required value="{{$role->description}}">
                </div>

                @foreach($permissions as $permission)

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input"  name="permissions[]" id="per_{{$permission->id}}"  value="{{$permission->id}}" {{$role->rolePermissions()->where('permission_id',$permission->id)->exists() ? 'checked':''}} >
                        <label class="form-check-label" for="per_{{$permission->id}}">{{$permission->description ?? $permission->name}}</label>
                    </div>
                @endforeach
            </div>
        </div>
        <button type="submit" class="mt-5 mb-10 btn btn-primary col-3 ">Сохранить</button>
    </form>
@endsection
