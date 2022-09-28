<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item @if ($current_page == 'Dashboard') active @endif">
            <a class="nav-link" href="{{ url('home') }}">
                <i class="ti-home menu-icon"><i class="fa-solid fa-house"></i></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item @if ($current_page == 'Product') active @endif">
            <a class="nav-link" data-bs-toggle="collapse" href="#user1" aria-expanded="false"
                aria-controls="form-elements">
                <i class="ti-clipboard menu-icon"><i class="fa-brands fa-product-hunt"></i></i>
                <span class="menu-title">Product</span>
                <i class="menu-arrow"><i class="fa-solid fa-chevron-down"></i></i>
            </a>
            <div class="collapse" id="user1">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('Addcategory') }}">Add category</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('Categorylist') }}">View Category</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('Addproduct') }}">Add Product</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('Productlist') }}">View Products</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item @if ($current_page == 'Purchase') active @endif">
            <a class="nav-link" data-bs-toggle="collapse" href="#user2" aria-expanded="false"
                aria-controls="form-elements">
                <i class="ti-clipboard menu-icon"><i class="fas fa-shopping-cart"></i></i></i>
                <span class="menu-title">Purchase</span>
                <i class="menu-arrow"><i class="fa-solid fa-chevron-down"></i></i>
            </a>
            <div class="collapse" id="user2">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('addPurchase') }}">Add </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('purchaselist') }}">Purchase List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('purchasereport') }}">Purchase Reports</a>
                    </li>
                    
                </ul>
            </div>
        </li>

        <li class="nav-item @if ($current_page == 'Sale') active @endif">
            <a class="nav-link" data-bs-toggle="collapse" href="#user3" aria-expanded="false"
                aria-controls="form-elements">
                <i class="ti-clipboard menu-icon"><i class="fas fa-shopping-bag"></i></i>
                <span class="menu-title">Sales</span>
                <i class="menu-arrow"><i class="fa-solid fa-chevron-down"></i></i>
            </a>
            <div class="collapse" id="user3">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('addsale') }}">Add </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('salelist') }}">Sales List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('salereport') }}">Sales Reports</a>
                    </li>

                </ul>
            </div>
        </li>
        <li class="nav-item @if ($current_page == 'Stock') active @endif">
            <a class="nav-link" data-bs-toggle="collapse" href="#Service-elements" aria-expanded="false"
                aria-controls="form-elements">
                <i class="ti-clipboard menu-icon"><i class="fas fa-cubes"></i></i>
                <span class="menu-title">Stock</span>
                <i class="menu-arrow"><i class="fa-solid fa-chevron-down"></i></i>
            </a>
            <div class="collapse" id="Service-elements">
                <ul class="nav flex-column sub-menu">

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('stocklist') }}">Stock list</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('stockreport') }}">Stock Reports</a>
                    </li>

                </ul>
            </div>
        </li>

        <li class="nav-item @if ($current_page == 'Item') active @endif">
            <a class="nav-link" data-bs-toggle="collapse" href="#Item-elements" aria-expanded="false"
                aria-controls="form-elements">
                <i class="ti-clipboard menu-icon"><i class="fas fa-cubes"></i></i>
                <span class="menu-title">Item</span>
                <i class="menu-arrow"><i class="fa-solid fa-chevron-down"></i></i>
            </a>
            <div class="collapse" id="Item-elements">
                <ul class="nav flex-column sub-menu">

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('Additem') }}">Additem</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('Itemlist') }}">Item list</a>
                    </li>

                </ul>
            </div>
        </li>
        <li class="nav-item @if ($current_page == 'Quantity') active @endif">
            <a class="nav-link" data-bs-toggle="collapse" href="#Quantity-elements" aria-expanded="false"
                aria-controls="form-elements">
                <i class="ti-clipboard menu-icon"><i class="fas fa-cubes"></i></i>
                <span class="menu-title">Quantity Type</span>
                <i class="menu-arrow"><i class="fa-solid fa-chevron-down"></i></i>
            </a>
            <div class="collapse" id="Quantity-elements">
                <ul class="nav flex-column sub-menu">

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('Addquantitytype') }}">Add Quantity Type</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('Quantitytypelist') }}">Quantity Type List</a>
                    </li>

                </ul>
            </div>
        </li>

    </ul>
</nav>
