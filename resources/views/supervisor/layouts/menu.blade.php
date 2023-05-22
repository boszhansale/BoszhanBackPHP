<li class="nav-item">
    <a href="{{route('supervisor.main')}}" class="nav-link">
        <i class="nav-icon fa fa-home"></i>

        <p>
            Главная
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="{{route('supervisor.user.salesreps')}}" class="nav-link">
        <i class="nav-icon fas fa-user"></i>
        <p>
            Торговые
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="{{route('supervisor.user.drivers')}}" class="nav-link">
        <i class="nav-icon fas fa-user"></i>
        <p>
            Водители
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="{{route('supervisor.store.index')}}" class="nav-link">
        <i class="nav-icon fas fa-shopping-basket"></i>
        <p>
            ТТ
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="{{route('supervisor.order.index')}}" class="nav-link">
        <i class="nav-icon fas fa-tasks"></i>
        <p>
            Заявки
        </p>
    </a>
</li>

@if(Auth::id() == 217)
    <li class="nav-item">
        <a href="{{route('supervisor.order.driver-move')}}" class="nav-link">
            <i class="nav-icon fas fa-align-justify"></i>
            <p>
                Перенос Заявок водителя
            </p>
        </a>
    </li>

@endif
