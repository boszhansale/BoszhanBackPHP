@extends('admin.layouts.index')

@section('content-header-title',$store->name)

@section('content')
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <table class="table  table-bordered">
                            <tr>
                                <td>ID</td>
                                <td>{{$store->id}}</td>
                            </tr>
                            <tr>
                                <td>ORDER COUNT</td>
                                <td>{{$store->orders()->count()}}</td>
                            </tr>
                            <tr>
                                <td>addres</td>
                                <td>{{$store->address}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
@endsection
