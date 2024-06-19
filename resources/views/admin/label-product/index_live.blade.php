<div>
    <div class="card card-body">
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label for="">поиск</label>
                    <input type="text" class="form-control" wire:model="search">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="">категория</label>
                    <select wire:model="label_category_id" class="form-control">
                        <option value="">все</option>
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
                    <th>id</th>
                    <th>категория</th>
                    <th>Название kz</th>
                    <th>barcode</th>
                    <th></th>

                </tr>
                </thead>
                <tbody>
                @foreach($labelProducts as $product)
                    <tr {!! mb_strlen($product->composition_kz) > 1500 ? 'class="bg-red"':'' !!}>
                        <th>{{$product->id}}</th>
                        <th><i>{{$product->category->name}}</i></th>
                        <th>{{$product->name_kz}}</th>
                        <th>{{$product->barcode}}</th>
                        <td class="project-actions text-right">
                            <a class="btn btn-info btn-sm" href="{{route('cashier.label-product.edit',$product->id)}}">
                                <i class="fas fa-pencil-alt">
                                </i>
                            </a>
                            <a class="btn btn-danger btn-sm"
                               href="{{route('cashier.label-product.delete',$product->id)}}">
                                <i class="fas fa-trash">
                                </i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{$labelProducts->links()}}
    </div>
</div>
