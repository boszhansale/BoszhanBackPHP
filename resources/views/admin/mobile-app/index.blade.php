@extends('admin.layouts.index')

@section('content-header-title','Мобильный версии')
@section('content-header-right')
    <a href="{{route('admin.mobile-app.create',1)}}" class="btn btn-info btn-sm  ">создать торговый apk</a>
    <a href="{{route('admin.mobile-app.create',2)}}" class="btn btn-info btn-sm  ">создать водительский apk</a>
@endsection
@section('content')

    <div class="row">
        <div class="col-md-12">
           <div class="card">
               <div class="card-header">Торговый</div>
               <div class="card-body">
                   <table class="table">
                       <thead>
                       <tr>
                           <th>Версия</th>
                           <th>Статус</th>
                           <th>загружено</th>
                           <th>Дата</th>
                           <th>Коммент</th>
                           <th></th>
                       </tr>
                       </thead>
                       <tbody>
                       @foreach($salesrepApps as $mobileApp)
                           <tr>
                               <th>
                                   {{$mobileApp->version}}
                               </th>
                               <th>
                                   {{$mobileApp->statusDescription()}}
                               </th>
                               <th>
                                   {{$mobileApp->downloads()->count()}}
                               </th>
                               <th>
                                   {{\Carbon\Carbon::parse($mobileApp->created_at)->format('d.m.Y')}}
                               </th>
                               <th>
                                   {{$mobileApp->comment}}
                               </th>

                               <td class="project-actions text-right">
                                   <a class="btn btn-primary btn-sm" href="{{route('admin.mobile-app.edit',$mobileApp->id)}}">
                                       <i class="fas fa-edit"> </i>
                                   </a>
                                   <a class="btn btn-link btn-sm" target="_blank" href="{{route('admin.mobile-app.download',$mobileApp->id)}}">
                                       <i class="fas fa-download"></i>
                                   </a>
                                   <a  class="btn btn-danger btn-sm" href="{{route('admin.mobile-app.delete',$mobileApp->id)}}" onclick="return confirm('Удалить?')">
                                       <i class="fas fa-trash"></i>
                                   </a>
                               </td>
                           </tr>
                       @endforeach
                       </tbody>
                   </table>
               </div>
           </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Водительский</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Версия</th>
                            <th>Статус</th>
                            <th>загружено</th>
                            <th>Дата</th>
                            <th>Коммент</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($driverApps as $mobileApp)
                            <tr>
                                <th>
                                    {{$mobileApp->version}}
                                </th>
                                <th>
                                    {{$mobileApp->statusDescription()}}
                                </th>
                                <th>
                                    {{$mobileApp->downloads()->count()}}
                                </th>
                                <th>
                                    {{\Carbon\Carbon::parse($mobileApp->created_at)->format('d.m.Y')}}
                                </th>
                                <th>
                                    {{$mobileApp->comment}}
                                </th>

                                <td class="project-actions text-right">
                                    <a class="btn btn-primary btn-sm" href="{{route('admin.mobile-app.edit',$mobileApp->id)}}">
                                        <i class="fas fa-edit"> </i>
                                    </a>
                                    <a class="btn btn-link btn-sm" taget="_blank" href="{{route('admin.mobile-app.download',$mobileApp->id)}}">
                                        <i class="fas fa-download"></i>
                                    </a>

                                    <a  class="btn btn-danger btn-sm" href="{{route('admin.mobile-app.delete',$mobileApp->id)}}" onclick="return confirm('Удалить?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
