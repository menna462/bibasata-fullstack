<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Bibasat</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">


    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-home"></i>
            <span>صفحه الرئيسيه</span>
        </a>
    </li>

    @auth
        @if (auth()->user()->role === 'admin')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('users') }}">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Users</span>
                </a>
            </li>
        @endif
    @endauth

    <li class="nav-item">
        <a class="nav-link" href="{{ route('slider') }}">
            <i class="fas fa-fw fa-images"></i>
            <span>السلايدر</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('cover') }}">
            <i class="fas fa-fw fa-images"></i>
            <span>خلفية</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('category') }}">
            <i class="fas fa-fw fa-tags"></i>
            <span>التصنيفات</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('product') }}">
            <i class="fas fa-fw fa-box"></i>
            <span>المنتجات</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('bundel') }}">
            <i class="fas fa-fw fa-gift"></i>
            <span>العروض</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('durationprice') }}">
            <i class="fas fa-fw fa-clock"></i>
            <span>سعر ومده المنتجات والعروض</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('account') }}">
            <i class="fas fa-fw fa-plus-circle"></i>
            <span>اضافة الحسابات</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('order') }}">
            <i class="fas fa-fw fa-shopping-cart"></i>
            <span>الاوردارات التى تم ارسالها</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('coupons') }}">
            <i class="fas fa-fw fa-ticket-alt"></i>
            <span>الكوبونات</span>
        </a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
</ul>
