@extends('cashier.layouts.index')
@section('content')
    <form class="product-edit" action="{{route('cashier.label-product.setting.update')}}" method="post"
          enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <h1>kz-ru</h1>
            </div>

            <div class="col-md-6">
                <h1>en</h1>
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
                    <textarea name="address_en" id="" cols="10" rows="10"
                              class="form-control">{{$setting->address_en}}</textarea>
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
        <div class="card card-body">
            <div class="row">
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
                        <label for="">текст даты (если тип только дата изготовления на арабском)</label>
                        <input type="text" class="form-control" name="date_create_ab"
                               value="{{$setting->date_create_ab}}">
                    </div>
                    <div class="form-group">
                        <label for="">текст даты (если тип дата изготовления и упаковывания)</label>
                        <input type="text" class="form-control" name="date_create_package_en"
                               value="{{$setting->date_create_package_en}}">
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
                        @if($setting->image_url_1)
                            <img src="{{$setting->image_url_1}}" width="30">
                        @endif
                        <input type="url" class="form-control" name="image_url_1"
                               value="{{$setting->image_url_1}}">
                    </div>
                    <div class="form-group">
                        <label for="date_type">image_url 2</label>
                        <br>
                        @if($setting->image_url_2)
                            <img src="{{$setting->image_url_2}}" width="30" alt="">
                        @endif
                        <input type="url" class="form-control" name="image_url_2"
                               value="{{$setting->image_url_2}}">
                    </div>
                    <div class="form-group">
                        <label for="date_type">image_url 3</label>
                        <br>
                        @if($setting->image_url_3)
                            <img src="{{$setting->image_url_3}}" width="30" alt="">
                        @endif
                        <input type="url" class="form-control" name="image_url_3"
                               value="{{$setting->image_url_3}}">
                    </div>
                    <div class="form-group">
                        <label for="date_type">image_url 4</label>
                        <br>
                        @if($setting->image_url_4)
                            <img src="{{$setting->image_url_4}}" width="30" alt="">
                        @endif
                        <input type="url" class="form-control" name="image_url_4"
                               value="{{$setting->image_url_4}}">
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
                <div class="form-group">
                    <label for="">weight_text_ab</label>
                    <input type="text" class="form-control" value="{{$setting->weight_text_ab}}" name="weight_text_ab">
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
