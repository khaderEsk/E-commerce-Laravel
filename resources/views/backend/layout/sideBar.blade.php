<div class="sl-logo"><a href=""><i class="icon ion-android-star-outline"></i> starlight</a></div>
<div class="sl-sideleft">
    <div class="input-group input-group-search">
        <input type="search" name="search" class="form-control" placeholder="Search">
        <span class="input-group-btn">
            <button class="btn"><i class="fa fa-search"></i></button>
        </span><!-- input-group-btn -->
    </div><!-- input-group -->

    <label class="sidebar-label">Navigation</label>
    <div class="sl-sideleft-menu">
        <a href="{{ route('dashboard') }}" class="sl-menu-link active">
            <div class="sl-menu-item">
                <i class="menu-item-icon icon ion-ios-home-outline tx-22"></i>
                <span class="menu-item-label">Dashboard</span>
            </div><!-- menu-item -->
        </a><!-- sl-menu-link -->

        <a href="{{ route('add.category') }}" class="sl-menu-link">
            <div class="sl-menu-item">
                <i class="menu-item-icon ion-ios-pie-outline tx-20"></i>
                <span class="menu-item-label">Categories</span>
                <i class="menu-item-arrow fa fa-angle-down"></i>
            </div><!-- menu-item -->
        </a><!-- sl-menu-link -->
        <ul class="sl-menu-sub nav flex-column">
            <li class="nav-item"><a href="{{ route('add.category') }}" class="nav-link">Add Category</a></li>
            <li class="nav-item"><a href="{{ route('category') }}" class="nav-link">View Categories</a></li>
        </ul>
        <a href="{{ route('add.product') }}" class="sl-menu-link">
            <div class="sl-menu-item">
                <i class="icon ion-ios-cart-outline tx-24"></i>
                <span class="menu-item-label">Products</span>
                <i class="menu-item-arrow fa fa-angle-down"></i>
            </div><!-- menu-item -->
        </a><!-- sl-menu-link -->
        <ul class="sl-menu-sub nav flex-column">
            <li class="nav-item"><a href="{{ route('add.product') }}" class="nav-link">Add</a></li>
            <li class="nav-item"><a href="{{ route('view.product') }}" class="nav-link">View</a></li>
        </ul>
        <a href="#" class="sl-menu-link">
            <div class="sl-menu-item">
                <i class="menu-item-icon icon ion-ios-star-outline tx-24"></i>
                <span class="menu-item-label">Featured Products </span>
                <i class="menu-item-arrow fa fa-angle-down"></i>
            </div><!-- menu-item -->
        </a><!-- sl-menu-link -->
        <ul class="sl-menu-sub nav flex-column">
            <li class="nav-item"><a href="{{ route('Featured.Products.add') }}" class="nav-link">Add</a></li>
            <li class="nav-item"><a href="{{ route('Featured.Products.view') }}" class="nav-link">View</a></li>
        </ul>
        <a href="#" class="sl-menu-link">
            <div class="sl-menu-item">
                <i class="menu-item-icon icon ion-ios-email-outline tx-24"></i>
                <span class="menu-item-label">Contact</span>
                <i class="menu-item-arrow fa fa-angle-down"></i>
            </div><!-- menu-item -->
        </a><!-- sl-menu-link -->
        <ul class="sl-menu-sub nav flex-column">
            <li class="nav-item"><a href="{{ route('contact.us.all') }}" class="nav-link">View</a></li>
        </ul>
        <a href="{{ route('users') }}" class="sl-menu-link">
            <div class="sl-menu-item">
                <i class="icon ion-person tx-24"></i>
                <span class="menu-item-label">Users</span>
            </div><!-- menu-item -->
        </a><!-- sl-menu-link -->
        <a href="{{ route('user.logout') }}" class="sl-menu-link">
            <div class="sl-menu-item">
                <i class="icon ion-log-out tx-22"></i>
                <span class="menu-item-label">Logout</span>
            </div><!-- menu-item -->
        </a><!-- sl-menu-link -->
    </div><!-- sl-sideleft-menu -->

    <br>
</div>
