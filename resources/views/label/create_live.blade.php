<div class="container">
    <form action="{{ route('label.store') }}" method="post">
        @csrf
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as  $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="form-group">
            <label for="name">язык</label>
            <select name="lang" wire:model="lang" class="form-control">
                <option value="kz">kz</option>
                <option value="ru">ru</option>
                <option value="en">en</option>
            </select>
        </div>
        <div class="form-group">
            <label for="name">Продукция</label>
            <select name="label_product_id" required class="form-control">
                <option value="">Выберите продукт</option>
                @foreach($labelProducts as $product)
                    <option value="{{$product->id}}">
                        @if($lang == 'ru')
                            {{$product->name_ru}}
                        @elseif($lang == 'en')
                            {{$product->name_en}}
                        @else
                            {{$product->name_kz}}
                        @endif
                    </option>
                @endforeach
            </select>
        </div>

        {{--        <div class="form-group">--}}
        {{--            <label for="name">размер</label>--}}
        {{--            <select name="" id="" class="form-control" required>--}}
        {{--                <option value="">Выберите размер</option>--}}
        {{--                <option value="58_90">58*90</option>--}}
        {{--                <option value="110_140">110*140</option>--}}
        {{--            </select>--}}
        {{--        </div>--}}
        {{--        <div class="form-group">--}}
        {{--            <label for="name">вес</label>--}}
        {{--            <input type="number" name="weight" required class="form-control">--}}
        {{--        </div>--}}

        <div class="form-group">
            <label for="name">Дата</label>
            <input type="date" name="date" required class="form-control" value="{{now()->format('Y-m-d') }}">
        </div>
        <div class="form-group">
            <button class="btn btn-success">Создать</button>
        </div>
    </form>
</div>
