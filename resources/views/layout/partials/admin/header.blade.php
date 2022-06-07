<nav class="navbar navbar-expand-md navbar-pink mb-5">
    <a class="navbar-brand" href="/products">Admin page</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
  
    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="navbar" href="/">Page</a>
            </li>
            <li class="nav-item">
                <a class="navbar" href="/products/create">Add product</a>
            </li>
            <li class="nav-item">
                <a class="navbar" href="/coupons/create">Add coupon</a>
            </li>
            <li class="nav-item">
                <a class="navbar" href="/products">View products</a>
            </li>
            <li class="nav-item">
                <a class="navbar" href="/coupons">View coupons</a>
            </li>
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a class="navbar" href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log out') }}
                    </a>
                </form>
            </li>
        </ul>
    </div>
</nav>