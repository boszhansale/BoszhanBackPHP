@extends('cashier.layouts.index')

@section('content-header-title','Продукты')
@section('content-header-right')
    <a href="{{route('cashier.label-product.create')}}" class="btn btn-info btn-sm  ">создать</a>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                <tr>
                    <th>id</th>
                    <th>Название kz</th>
                    <th>barcode</th>
                    <th></th>

                </tr>
                </thead>
                <tbody>
                @foreach($labelProducts as $product)
                    <tr>

                        <th>{{$product->id}}</th>
                        <th>{{$product->name_kz}}</th>
                        <th>{{$product->barcode}}</th>
                        <td class="project-actions text-right">
                            <a class="btn btn-info btn-sm" href="{{route('cashier.label-product.edit',$product->id)}}">
                                <i class="fas fa-pencil-alt">
                                </i>
                            </a>
                            <a class="btn btn-danger btn-sm"
                               href="{{route('cashier.label-product.delete',$product->id)}}">
                                <i class="fas fa-trash">
                                </i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
