@extends('cashier.layouts.index')
@section('content')
    <form class="product-edit" action="{{route('cashier.label-product.update',$labelProduct->id)}}" method="post"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="bg-red">{{$error}}</div>
            @endforeach
        @endif
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">barcode</label>
                    <input type="text" class="form-control" name="barcode" value="{{$labelProduct->barcode}}">
                </div>
            </div>


        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">вес</label>
                    <input type="number" name="weight" class="form-control" value="{{$labelProduct->weight}}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">категория</label>
                    <select name="label_category_id" class="form-control">
                        @foreach(\App\Models\LabelCategory::all() as $cat)
                            <option
                                {{$labelProduct->label_category_id == $cat->id ? 'selected':''}} value="{{$cat->id}}">{{$cat->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="align">align</label>
                    <select class="form-control" name="align" id="align">
                        <option @selected($labelProduct->align == 'left') value="left">с лево</option>
                        <option @selected($labelProduct->align == 'center') value="center">центр</option>
                        <option @selected($labelProduct->align == 'right') value="right">с право</option>
                    </select>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">единица измерения</label>
                    <select name="measure" class="form-control">
                        <option {{$labelProduct->measure == 2 ? 'selected':''}} value="2">весовой</option>
                        <option {{$labelProduct->measure == 1 ? 'selected':''}} value="1">шт</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">отступы между языками kz_ru</label>
                    <input type="number" name="kz_ru_margin" value="{{$labelProduct->kz_ru_margin}}"
                           class="form-control">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h1>kz-ru</h1>
                <div class="form-group">
                    <label for="">Название</label>
                    <input type="text" class="form-control" name="name_kz" value="{{$labelProduct->name_kz}}" required>
                </div>
                <div class="form-group">
                    <label for="">текст массы</label>
                    <input type="text" class="form-control" name="weight_text_kz"
                           value="{{$labelProduct->weight_text_kz}}">
                </div>

                <div class="form-group">
                    <label for="name">Состав KZ</label>
                    <textarea name="composition_kz" id="composition_kz" cols="30" rows="20"
                              class="form-control">{{$labelProduct->composition_kz}}</textarea>
                    <p id="charCountKz"></p>
                </div>


                <div class="form-group">
                    <label for="name">Состав RU</label>
                    <textarea name="composition_ru" id="composition_ru" cols="30" rows="20"
                              class="form-control">{{$labelProduct->composition_ru}}</textarea>
                    <p id="charCountRu"></p>
                </div>


            </div>

            <div class="col-md-6">
                <h1>en</h1>
                <div class="form-group">
                    <label for="">Название</label>
                    <input type="text" class="form-control" name="name_en" value="{{$labelProduct->name_en}}" required>
                </div>
                <div class="form-group">
                    <label for="">текст массы</label>
                    <input type="text" class="form-control" name="weight_text_en"
                           value="{{$labelProduct->weight_text_en}}">
                </div>
                <div class="form-group">
                    <label for="name">Состав</label>
                    <textarea name="composition_en" id="composition_en" cols="30" rows="20"
                              class="form-control">{{$labelProduct->composition_en}}</textarea>
                    <p id="charCountEn"></p>
                </div>


            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">адрес</label>
                    <textarea name="address_kz" id="" cols="10" rows="10"
                              class="form-control">{{$labelProduct->address_kz}}</textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">адрес</label>
                    <textarea name="address_en" id="" cols="10" rows="10"
                              class="form-control">{{$labelProduct->address_en}}</textarea>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">сертификат</label>
                    <input type="text" class="form-control" name="cert_kz" value="{{$labelProduct->cert_kz}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">сертификат</label>
                    <input type="text" class="form-control" name="cert_en" value="{{$labelProduct->cert_en}}">
                </div>
            </div>
        </div>
        <div class="card card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="date_type">тип дата текста</label>
                        <select class="form-control" name="date_type" id="date_type">
                            <option @selected($labelProduct->date_type == '1') value="1">только дата изготовления
                            </option>
                            <option @selected($labelProduct->date_type == '2') value="2">дата изготовления и
                                упаковывания
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">

                    <div class="form-group">
                        <label for="">текст даты (если тип только дата изготовления)</label>
                        <input type="text" class="form-control" name="date_create_kz"
                               value="{{$labelProduct->date_create_kz}}">
                    </div>
                    <div class="form-group">
                        <label for="">текст даты (если тип дата изготовления и упаковывания) 1</label>
                        <input type="text" class="form-control" name="date_create_package_kz"
                               value="{{$labelProduct->date_create_package_kz}}">
                    </div>
                    <div class="form-group">
                        <label for="">текст даты (если тип дата изготовления и упаковывания) 2</label>
                        <input type="text" class="form-control" name="date_create_package_ru"
                               value="{{$labelProduct->date_create_package_ru}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">текст даты (если тип только дата изготовления)</label>
                        <input type="text" class="form-control" name="date_create_en"
                               value="{{$labelProduct->date_create_en}}">
                    </div>
                    <div class="form-group">
                        <label for="">текст даты (если тип дата изготовления и упаковывания)</label>
                        <input type="text" class="form-control" name="date_create_package_en"
                               value="{{$labelProduct->date_create_package_en}}">
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">

                        <label for="date_type">image_url 1</label>
                        <br>
                        @if($labelProduct->image_url_1)
                            <img src="{{$labelProduct->image_url_1}}" width="30">
                        @endif
                        <input type="url" class="form-control" name="image_url_1"
                               value="{{$labelProduct->image_url_1}}">
                    </div>
                    <div class="form-group">
                        <label for="date_type">image_url 2</label>
                        <br>
                        @if($labelProduct->image_url_2)
                            <img src="{{$labelProduct->image_url_2}}" width="30" alt="">
                        @endif
                        <input type="url" class="form-control" name="image_url_2"
                               value="{{$labelProduct->image_url_2}}">
                    </div>
                    <div class="form-group">
                        <label for="date_type">image_url 3</label>
                        <br>
                        @if($labelProduct->image_url_3)
                            <img src="{{$labelProduct->image_url_3}}" width="30" alt="">
                        @endif
                        <input type="url" class="form-control" name="image_url_3"
                               value="{{$labelProduct->image_url_3}}">
                    </div>
                    <div class="form-group">
                        <label for="date_type">image_url 4</label>
                        <br>
                        @if($labelProduct->image_url_4)
                            <img src="{{$labelProduct->image_url_4}}" width="30" alt="">
                        @endif
                        <input type="url" class="form-control" name="image_url_4"
                               value="{{$labelProduct->image_url_4}}">
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="mt-5 mb-10 btn btn-primary col-3 ">Сохранить</button>

        <script>
            document.addEventListener('DOMContentLoaded', (event) => {
                const textarea = document.getElementById('composition_kz');
                const charCount = document.getElementById('charCountKz');
                const maxLength = 1500;

                const currentLength = textarea.value.length;
                charCount.textContent = `${currentLength}/${maxLength}`;

                if (currentLength >= maxLength) {
                    charCount.style.color = 'red';
                } else {
                    charCount.style.color = 'black';
                }
                textarea.addEventListener('input', () => {
                    const currentLength = textarea.value.length;
                    charCount.textContent = `${currentLength}/${maxLength}`;

                    if (currentLength >= maxLength) {
                        charCount.style.color = 'red';
                    } else {
                        charCount.style.color = 'black';
                    }
                });
            });
        </script>
@endsection
