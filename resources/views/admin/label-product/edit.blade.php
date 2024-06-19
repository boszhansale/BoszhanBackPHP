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
                <div class="form-group">
                    <label for="date_type">тип дата текста</label>
                    <select class="form-control" name="date_type" id="date_type">
                        <option @selected($labelProduct->date_type == '1') value="1">Дайындалған күні/Дата
                            изготовления
                        </option>
                        <option @selected($labelProduct->date_type == '2') value="2">Дайындалған және оралған күні
                            Дата изготовления и упаковывания
                        </option>
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
        </div>
        <div class="row">
            <div class="col-md-4">
                <h1>kz-ru</h1>
                <div class="form-group">
                    <label for="">Название</label>
                    <input type="text" class="form-control" name="name_kz" value="{{$labelProduct->name_kz}}" required>
                </div>
                <div class="form-group">
                    <label for="name">Состав</label>
                    <textarea name="composition_kz" id="composition_kz" cols="30" rows="20" maxlength="1500"
                              class="form-control">{{$labelProduct->composition_kz}}</textarea>
                    <p id="charCountKz"></p>
                </div>
                <div class="form-group">
                    <label for="">сертификат</label>
                    <input type="text" class="form-control" name="cert_kz" value="{{$labelProduct->cert_kz}}">
                </div>
                <div class="form-group">
                    <label for="">текст даты</label>
                    <input type="text" class="form-control" name="date_create_kz"
                           value="{{$labelProduct->date_create_kz}}">
                </div>
                <div class="form-group">
                    <label for="name">адрес</label>
                    <textarea name="address_kz" id="" cols="10" rows="10"
                              class="form-control">{{$labelProduct->address_kz}}</textarea>
                </div>

            </div>
            {{--            <div class="col-md-4">--}}
            {{--                <h1>ru</h1>--}}
            {{--                <div class="form-group">--}}
            {{--                    <label for="">Название</label>--}}
            {{--                    <input type="text" class="form-control" name="name_ru" value="{{$labelProduct->name_ru}}" required>--}}
            {{--                </div>--}}
            {{--                <div class="form-group">--}}
            {{--                    <label for="name">Состав</label>--}}
            {{--                    <textarea name="composition_ru" id="" cols="30" rows="10"--}}
            {{--                              class="form-control">{{$labelProduct->composition_ru}}</textarea>--}}
            {{--                </div>--}}
            {{--                <div class="form-group">--}}
            {{--                    <label for="">сертификат</label>--}}
            {{--                    <input type="text" class="form-control" name="cert_ru" value="{{$labelProduct->cert_ru}}">--}}
            {{--                </div>--}}
            {{--                <div class="form-group">--}}
            {{--                    <label for="">текст даты</label>--}}
            {{--                    <input type="text" class="form-control" name="date_create_ru" value="{{$labelProduct->date_create_ru}}">--}}
            {{--                </div>--}}
            {{--                <div class="form-group">--}}
            {{--                    <label for="name">адрес</label>--}}
            {{--                    <textarea name="address_ru" id="" cols="10" rows="10"--}}
            {{--                              class="form-control">{{$labelProduct->address_ru}}</textarea>--}}
            {{--                </div>--}}

            {{--            </div>--}}
            <div class="col-md-4">
                <h1>en</h1>
                <div class="form-group">
                    <label for="">Название</label>
                    <input type="text" class="form-control" name="name_en" value="{{$labelProduct->name_en}}" required>
                </div>
                <div class="form-group">
                    <label for="name">Состав</label>
                    <textarea name="composition_en" id="composition_en" cols="30" rows="20" maxlength="1500"
                              class="form-control">{{$labelProduct->composition_en}}</textarea>
                    <p id="charCountEn"></p>
                </div>
                <div class="form-group">
                    <label for="">сертификат</label>
                    <input type="text" class="form-control" name="cert_en" value="{{$labelProduct->cert_en}}">
                </div>
                <div class="form-group">
                    <label for="">текст даты</label>
                    <input type="text" class="form-control" name="date_create_en"
                           value="{{$labelProduct->date_create_en}}">
                </div>
                <div class="form-group">
                    <label for="name">адрес</label>
                    <textarea name="address_en" id="" cols="10" rows="10"
                              class="form-control">{{$labelProduct->address_en}}</textarea>
                </div>

            </div>
        </div>
        <button type="submit" class="mt-5 mb-10 btn btn-primary col-3 ">Сохранить</button>

        <script>
            document.addEventListener('DOMContentLoaded', (event) => {
                const textarea = document.getElementById('composition_kz');
                const charCount = document.getElementById('charCountKz');
                const maxLength = textarea.getAttribute('maxlength');

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
