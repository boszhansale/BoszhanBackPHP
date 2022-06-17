@extends('admin.layouts.index')
@section('content')
    <form class="product-edit" action="{{route('admin.plan-group.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Команда</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="form-group">
                    <label for="">Общи план</label>
                    <input type="number" class="form-control" name="plan" required>
                </div>
            </div>
{{--            <div class="col-md-3">--}}
{{--                <h6 class="">Торговые</h6>--}}
{{--                <div>--}}
{{--                    @foreach($salesreps as $salesrep)--}}
{{--                        <div class="form-check">--}}
{{--                            <input type="checkbox" class="form-check-input"   name="salesreps[]" value="{{$salesrep->id}}" id="salesrep_{{$salesrep->id}}">--}}
{{--                            <label class="form-check-label" for="salesrep_{{$salesrep->id}}">{{$salesrep->name}}</label>--}}
{{--                        </div>--}}
{{--                    @endforeach--}}
{{--                </div>--}}
{{--            </div>--}}


            <div class="col-md-6">
                @foreach($brands as $k => $brand)

                    <div class="form-group">
                        <label for="">план {{$brand->name}}</label>
                        <input type="hidden" name="plan_group_brands[{{$k}}][brand_id]" value="{{$brand->id}}" required>
                        <input type="number" class="form-control" name="plan_group_brands[{{$k}}][plan]" value="0" required>
                    </div>
                @endforeach
            </div>
        </div>
        <button type="submit" class="mt-5 mb-10 btn btn-primary col-3 ">Сохранить</button>
    </form>
@endsection
