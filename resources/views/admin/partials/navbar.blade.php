<nav class="navbar navbar-expand-lg navbar-dark bg-primary rounded-3 mb-4 shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-tools me-2"></i>EnM Hardware Admin
        </a>
        <button class="navbar-toggler shadow-none border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link @if(request()->routeIs('admin.dashboard')) active @endif" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-chart-line me-1"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(request()->routeIs('admin.products.*')) active @endif" href="{{ route('admin.products.index') }}">
                        <i class="fas fa-box-open me-1"></i>Products
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(request()->routeIs('admin.orders.*')) active @endif" href="{{ route('admin.orders.index') }}">
                        <i class="fas fa-clipboard-list me-1"></i>Orders
                    </a>
                </li>
                <!-- Add more menu items as needed -->
            </ul>
            <div class="d-flex">
                @if(request()->routeIs('admin.products.*'))
                    <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-light me-2 shadow-sm">
                        <i class="fas fa-plus-circle me-1"></i> Add Product
                    </a>
                    <a href="{{ route('admin.products.import') }}" class="btn btn-sm btn-success shadow-sm">
                        <i class="fas fa-file-excel me-1"></i> Import
                    </a>
                @endif
            </div>
        </div>
    </div>
</nav>