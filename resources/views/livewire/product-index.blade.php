<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                    <input wire:model="search" type="search" name="search" placeholder="поиск" class="form-control">
                </div>
                <div class="col-md-2">
                    <select wire:model="brand_id" class="form-control">
                        <option value="all">Все бренды</option>
                        @foreach($brands as $brand)
                            <option value="{{$brand->id}}">{{$brand->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select wire:model="category_id" class="form-control">
                        <option value="all">все категории</option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                <tr>
                    <th></th>
                    <th>#</th>
                    <th>артикул</th>
                    <th>name</th>
                    <th>cat</th>
                    @foreach(\App\Models\PriceType::all() as $priceType)
                        <th>{{$priceType->name}}</th>
                    @endforeach

                    <th>шт/кг</th>
                    <th>продано</th>
                    <th>кол. заявок</th>
                    <th>остаток</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td class="project-actions text-right">
                            @if(Auth::user()->permissionExists('product_edit'))
                                <a class="btn btn-info btn-sm" href="{{route('admin.product.edit',$product->id)}}">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                </a>
                            @endif
                            @if(Auth::user()->permissionExists('product_delete'))
                                <a class="btn btn-danger btn-sm"
                                   href="{{route('admin.product.delete',$product->id)}}">
                                    <i class="fas fa-trash">
                                    </i>
                                </a>
                            @endif
                        </td>
                        <th>{{$product->id}}</th>
                        <th>{{$product->article}}</th>
                        <td>
                            @if($product->images()->exists())
                                <img src="{{$product->images[0]->path}}" width="100">
                            @else
                                <img src="https://dummyimage.com/600x400/000/fff" width="100">
                            @endif
                        </td>
                        <th>
                            <small>{{$product->category->name}}</small>
                            <br>
                            <a>{{$product->name}}</a>
                        </th>

                        @foreach($priceTypes as $priceType)
                            <th>{{$product->prices()->where('price_type_id',$priceType->id)->first()?->price}}</th>
                        @endforeach
                        <th>
                            @if($product->measure == 1)
                                штука
                            @else
                                кг
                            @endif
                        </th>
                        <th>
                            {{$product->baskets()->sum('count')}}
                        </th>
                        <th>
                            {{$product->baskets()->count()}}
                        </th>
                        <th>
                            {{$product->remainder}}
                        </th>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{$products->links()}}
        </div>
    </div>

</div>
