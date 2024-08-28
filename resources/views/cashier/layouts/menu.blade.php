@if(Auth::id() == 326)
    <li class="nav-item">
        <a href="{{route('cashier.label-product.index')}}" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
            <p>
                Продукты этикетки
            </p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{route('cashier.label-product.setting')}}" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
            <p>
                шаблоны этикетки
            </p>
        </a>
    </li>

@else
    <li class="nav-item">
        <a href="{{route('cashier.main')}}" class="nav-link">
            <i class="nav-icon fa fa-home"></i>
            <p>
                Контрагенты
            </p>
        </a>
        <a href="{{route('cashier.order.index')}}" class="nav-link">
            <i class="nav-icon fa fa-home"></i>
            <p>
                Заявки
            </p>
        </a>
    </li>
@endif

