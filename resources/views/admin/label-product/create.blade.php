@extends('cashier.layouts.index')
@section('content')
    <form class="product-edit" action="{{route('cashier.label-product.store')}}" method="post"
          enctype="multipart/form-data">
        @csrf
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div>{{$error}}</div>
            @endforeach
        @endif
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">штрихкод</label>
                    <input type="text" class="form-control" name="barcode">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">вес</label>
                    <input type="number" name="weight" class="form-control">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">категория</label>
                    <select name="label_category_id" required class="form-control">
                        <option value="">Выберите категорию</option>
                        @foreach(\App\Models\LabelCategory::all() as $cat)
                            <option value="{{$cat->id}}">{{$cat->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="align">align</label>
                    <select class="form-control" name="align" id="align">
                        <option value="left">с лево</option>
                        <option value="center">центр</option>
                        <option value="right">с право</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">единица измерения</label>
                    <select name="measure" class="form-control">
                        <option value="2">весовой</option>
                        <option value="1">шт</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h1>kz-ru</h1>
                <div class="form-group">
                    <label for="">Название</label>
                    <input type="text" class="form-control" name="name_kz" required>
                </div>
                <div class="form-group">
                    <label for="name">Состав KZ</label>
                    <textarea name="composition_kz" id="" cols="30" rows="10" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="">отступы между языками kz_ru</label>
                    <input type="number" name="kz_ru_margin" value="315"
                           class="form-control">
                </div>
                <div class="form-group">
                    <label for="name">Состав RU</label>
                    <textarea name="composition_ru" id="composition_ru" cols="30" rows="20"
                              class="form-control"></textarea>
                    <p id="charCountRu"></p>


                </div>
            </div>
            <div class="col-md-6">
                <h1>en</h1>
                <div class="form-group">
                    <label for="">Название</label>
                    <input type="text" class="form-control" name="name_en" required>
                </div>
                <div class="form-group">
                    <label for="name">Состав</label>
                    <textarea name="composition_en" id="" cols="30" rows="10" class="form-control"></textarea>
                </div>


            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">сертификат</label>
                    <input type="text" class="form-control" name="cert_kz" value="{{$setting->cert_kz}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">сертификат</label>
                    <input type="text" class="form-control" name="cert_en" value="{{$setting->cert_en}}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">адрес</label>
                    <textarea name="address_kz" id="" cols="10" rows="10"
                              class="form-control">{{$setting->address_kz}}</textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">адрес</label>
                    <textarea name="address_en" id="" cols="10" rows="10" class="form-control">{{$setting->address_en}}
                    </textarea>
                </div>
            </div>
        </div>
        <div class="card card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="date_type">тип дата текста</label>
                        <select class="form-control" name="date_type" id="date_type">
                            <option value="1">только дата изготовления
                            </option>
                            <option value="2">дата изготовления и
                                упаковывания
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">

                    <div class="form-group">
                        <label for="">текст даты (если тип только дата изготовления)</label>
                        <input type="text" class="form-control" name="date_create_kz"
                               value="{{$setting->date_create_kz}}">
                    </div>
                    <div class="form-group">
                        <label for="">текст даты (если тип дата изготовления и упаковывания) 1</label>
                        <input type="text" class="form-control" name="date_create_package_kz"
                               value="{{$setting->date_create_package_kz}}">
                    </div>
                    <div class="form-group">
                        <label for="">текст даты (если тип дата изготовления и упаковывания) 2</label>
                        <input type="text" class="form-control" name="date_create_package_ru"
                               value="{{$setting->date_create_package_ru}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">текст даты (если тип только дата изготовления)</label>
                        <input type="text" class="form-control" name="date_create_en"
                               value="{{$setting->date_create_en}}">
                    </div>
                    <div class="form-group">
                        <label for="">текст даты (если тип дата изготовления и упаковывания)</label>
                        <input type="text" class="form-control" name="date_create_package_en"
                               value="{{$setting->date_create_package_en}}">
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">weight_text_kz</label>
                    <input type="text" class="form-control" value="{{$setting->weight_text_kz}}" name="weight_text_kz">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">weight_text_en</label>
                    <input type="text" class="form-control" value="{{$setting->weight_text_en}}" name="weight_text_en">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">

                                <label for="date_type">image_url 1</label>
                                <br>
                                <input type="url" class="form-control" name="image_url_1"
                                       value="{{$setting->image_url_1}}">
                            </div>
                            <div class="form-group">
                                <label for="date_type">image_url 2</label>
                                <br>
                                <input type="url" class="form-control" name="image_url_2"
                                       value="{{$setting->image_url_2}}">
                            </div>
                            <div class="form-group">
                                <label for="date_type">image_url 3</label>
                                <br>
                                <input type="url" class="form-control" name="image_url_3"
                                       value="{{$setting->image_url_3}}">
                            </div>
                            <div class="form-group">
                                <label for="date_type">image_url 4</label>
                                <br>
                                <input type="url" class="form-control" name="image_url_4"
                                       value="{{$setting->image_url_4}}">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <button type="submit" class="mt-5 mb-10 btn btn-primary col-3 ">Сохранить</button>
    </form>
@endsection
