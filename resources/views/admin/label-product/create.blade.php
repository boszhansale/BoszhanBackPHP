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
                <div class="form-group">
                    <label for="date_type">тип дата текста</label>
                    <select class="form-control" name="date_type" id="date_type">
                        <option value="1">Дайындалған күні/Дата
                            изготовления
                        </option>
                        <option value="2">Дайындалған және оралған күні
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

                    <div class="form-group">
                        <label for="">текст даты</label>
                        <input type="text" class="form-control" name="date_create_kz"
                               value="Дайындалған күні/Дата изготовления">
                    </div>


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
                    <input type="text" class="form-control" name="cert_kz" value="ЖШС СТ 130740008859-03-2022">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">сертификат</label>
                    <input type="text" class="form-control" name="cert_en">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">адрес</label>
                    <textarea name="address_kz" id="" cols="10" rows="10" class="form-control">Өндіруші:«Первомайские деликатесы» ЖШС, Қазақстан Республикасы, Алматы облысы, Іле ауданы, Қоянқұс ауылы, Абай көшесі, №200 </br>Изготовитель: ТОО«Первомайские Деликатесы», Республика Казахстан, Алматинская область, Илийский район, село Коянкус,улица Абай, №200. т:+7 775 256 22 55
                    </textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">адрес</label>
                    <textarea name="address_en" id="" cols="10" rows="10" class="form-control">Manufacturer: Pervomayskie Delikatesy LLP,</br>Republic of Kazakhstan, Almaty region, Ili district,Koyankus village,Abay Street, No. 200</br>tel: +7(727)260-36-48</textarea>
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
                               value="Дайындалған күні/Дата изготовления">
                    </div>
                    <div class="form-group">
                        <label for="">текст даты (если тип дата изготовления и упаковывания) 1</label>
                        <input type="text" class="form-control" name="date_create_package_kz"
                               value="Дайындалған және оралған күні">
                    </div>
                    <div class="form-group">
                        <label for="">текст даты (если тип дата изготовления и упаковывания) 2</label>
                        <input type="text" class="form-control" name="date_create_package_ru"
                               value="Дата изготовления и упаковывания">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">текст даты (если тип только дата изготовления)</label>
                        <input type="text" class="form-control" name="date_create_en"
                               value="Date of manufacture and packaging">
                    </div>
                    <div class="form-group">
                        <label for="">текст даты (если тип дата изготовления и упаковывания)</label>
                        <input type="text" class="form-control" name="date_create_package_en"
                               value="Date of manufacture and packaging">
                    </div>
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
                                       value="https://upload.wikimedia.org/wikipedia/commons/thumb/f/f7/EAC_b-on-w.svg/1200px-EAC_b-on-w.svg.png">
                            </div>
                            <div class="form-group">
                                <label for="date_type">image_url 2</label>
                                <br>
                                <input type="url" class="form-control" name="image_url_2"
                                       value="https://k2v.ru/wp-content/uploads/2020/04/stakan-i-vilka-oboznachenie.jpg">
                            </div>
                            <div class="form-group">
                                <label for="date_type">image_url 2</label>
                                <br>
                                <input type="url" class="form-control" name="image_url_3"
                                       value="https://cdn-icons-png.flaticon.com/512/91/91356.png">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <button type="submit" class="mt-5 mb-10 btn btn-primary col-3 ">Сохранить</button>
    </form>
@endsection
