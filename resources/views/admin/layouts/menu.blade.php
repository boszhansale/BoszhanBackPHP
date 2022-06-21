<li class="nav-item">
    <a href="{{route('admin.main')}}" class="nav-link">
        <i class="nav-icon fa fa-home" ></i>

        <p>
            Главная
        </p>
    </a>
</li>
@if(Auth::user()->permissionExists('product_index'))
    <li class="nav-item">
        <a href="{{route('admin.product.index')}}" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
            <p>
                Продукты
            </p>
        </a>
    </li>
@endif
@if(Auth::user()->permissionExists('user_index'))
<li class="nav-item">
    <a href="{{route('admin.user.index')}}" class="nav-link">
        <i class="nav-icon fas fa-user"></i>
        <p>
            Пользователи
        </p>
    </a>
</li>
@endif
@if(Auth::user()->permissionExists('counteragent_index'))
<li class="nav-item">
    <a href="{{route('admin.counteragent.index')}}" class="nav-link">
        <i class="nav-icon fas fa-shopping-bag"></i>
        <p>
            Контрагенты
        </p>
    </a>
</li>
@endif
@if(Auth::user()->permissionExists('store_index'))
<li class="nav-item">
    <a href="{{route('admin.store.index')}}" class="nav-link">
        <i class="nav-icon fas fa-shopping-basket"></i>
        <p>
            ТТ
        </p>
    </a>
</li>
@endif
@if(Auth::user()->permissionExists('brand_index'))
<li class="nav-item">
    <a href="{{route('admin.brand.index')}}" class="nav-link">
        <i class="nav-icon fas fa-building"></i>
        <p>
            Бренды
        </p>
    </a>
</li>
@endif
@if(Auth::user()->permissionExists('order_index'))
<li class="nav-item">
    <a href="{{route('admin.order.index')}}" class="nav-link">
        <i class="nav-icon fas fa-tasks"></i>
        <p>
            Заявки
        </p>
    </a>
</li>
@endif
@if(Auth::user()->permissionExists('plan_group'))
<li class="nav-item">
    <a href="{{route('admin.plan-group.index')}}" class="nav-link">
        <i class="nav-icon fas fa-users"></i>
        <p>
            План группа
        </p>
    </a>
</li>
@endif

@if(Auth::id() == 1)
<li class="nav-item">
    <a href="{{route('admin.mobile-app.index')}}" class="nav-link">
        <i class="nav-icon fas fa-mobile"></i>
        <p>
             Версия Моб. прил.
        </p>
    </a>
</li>

<li class="nav-item">
    <a href="{{route('admin.store.move')}}" class="nav-link">
        <i class="nav-icon fas fa-align-justify"></i>
        <p>
             Перенос ТТ
        </p>
    </a>
</li>


<li class="nav-item">
    <a href="{{route('admin.role.index')}}" class="nav-link">
        <i class="nav-icon fas fa-align-justify"></i>
        <p>
             Роли и права доступа
        </p>
    </a>
</li>
@endif
