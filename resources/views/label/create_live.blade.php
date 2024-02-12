<div class="container">
    <form>
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
            <label for="name">категория</label>
            <select name="lang" wire:model="category_id" class="form-control">
                <option value="">Выберите категорию</option>
                @foreach($categories as $cat)
                    <option value="{{$cat->id}}">{{$cat->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="name">язык</label>
            <select name="lang" wire:model="lang" class="form-control">
                <option value="kz">kz-ru</option>
                <option value="en">en</option>
            </select>
        </div>
        <div class="form-group">
            <label for="name">Продукция</label>
            <select name="label_product_id" wire:model="label_product_id" required class="form-control">
                <option value="">Выберите продукт</option>
                @foreach($labelProducts as $product)
                    <option value="{{$product->id}}">
                        @if($lang == 'en')
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

        <div class="form-group">
            <label for="name">Дата</label>
            <input type="date" name="date" wire:model="date" required class="form-control"
                   value="{{now()->format('Y-m-d') }}">
        </div>
        <div class="form-group">
            <input type="checkbox" name="date_show" wire:model="dateShow" id="date_show" class="" checked value="1">
            <label for="date_show">показать дату</label>

            <div class="form-group">
                <a target="_blank" href="{{route('label.store',$params)}}" class="btn btn-success">Создать</a>
            </div>
    </form>
</div>
