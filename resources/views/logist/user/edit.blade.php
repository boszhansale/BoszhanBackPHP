@extends('logist.layouts.index')
@section('content')
    <form class="product-edit" action="{{route('logist.user.update',$user->id)}}" method="post"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6">
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div>{{$error}}</div>
                    @endforeach
                @endif
                <div class="form-group">
                    <label for="">Водитель</label>
                    <select name="rider_id" class="form-control">
                        <option value="">Выберите водителя</option>
                        @foreach($riders as $rider)
                            <option
                                value="{{$rider->id}}" {{\App\Models\RiderDriver::where('driver_id',$user->id)->where('rider_id',$rider->id)->exists() ? 'selected' : ''}}>{{$rider->name}}</option>
                        @endforeach
                    </select>

                </div>
            </div>

        </div>
        <button type="submit" class="mt-5 mb-10 btn btn-primary col-3 ">Сохранить</button>
    </form>
@endsection
