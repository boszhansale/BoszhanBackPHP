@extends('admin.layouts.index')
@section('content')
    <form class="product-edit" action="{{route('admin.plan-group.update',$planGroup->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">команда</label>
                    <input type="text" class="form-control" name="name" required value="{{$planGroup->name}}">
                </div>
                <div class="form-group">
                    <label for="">план</label>
                    <input type="number" class="form-control" name="plan" required value="{{$planGroup->plan}}">
                </div>
            </div>
            <div class="col-md-6">
                @foreach($planGroup->planGroupBrands as $k => $planGroupBrand)

                    <div class="form-group">
                        <label for="">план {{$planGroupBrand->brand->name}}</label>
                        <input type="hidden"  name="plan_group_brands[{{$k}}][plan_group_brand_id]" value="{{$planGroupBrand->id}}" required>
                        <input type="number"  class="form-control" name="plan_group_brands[{{$k}}][plan]" value="{{$planGroupBrand->plan}}" required>
                    </div>
                @endforeach
            </div>
{{--            <div class="col-md-3">--}}
{{--                <h6 class="">Торговые</h6>--}}
{{--                <div>--}}
{{--                    @foreach($salesreps as $salesrep)--}}
{{--                        <div class="form-check">--}}
{{--                            <input type="checkbox" class="form-check-input"   {{$user->salesreps()->where('users.id',$salesrep->id)->exists() ? 'checked' : ''}} name="salesreps[]" value="{{$salesrep->id}}" id="salesrep_{{$salesrep->id}}">--}}
{{--                            <label class="form-check-label" for="salesrep_{{$salesrep->id}}">{{$salesrep->name}}</label>--}}
{{--                        </div>--}}
{{--                    @endforeach--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
        <button type="submit" class="mt-5 mb-10 btn btn-primary col-3 ">Сохранить</button>
    </form>
@endsection
