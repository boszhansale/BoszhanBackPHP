<div>
    <form action="{{route('admin.store.salesrep-moving')}}" method="post">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Выберите торгового "C"</div>
                    <div class="card-body">
                        <div class="form-group">
                            <select name="from_salesrep_id" wire:model="from_salesrep_id" class="form-control" required>
                                <option value="">Выберите</option>
                                @foreach($from_salesreps as $salesrep)
                                    <option value="{{$salesrep->id}}">{{$salesrep->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            количество ТТ: <b>{{$from_salesrep_stores_count}}</b>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Выберите торгового "На"</div>
                    <div class="card-body">
                        <div class="form-group">
                            <select name="to_salesrep_id" required wire:model="to_salesrep_id" class="form-control">
                                <option value="">Выберите</option>

                                @foreach($to_salesreps as $salesrep)
                                    <option value="{{$salesrep->id}}">{{$salesrep->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            количество ТТ: <b>{{$to_salesrep_stores_count}}</b>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Переместит</button>
            </div>
        </div>
    </form>
</div>
