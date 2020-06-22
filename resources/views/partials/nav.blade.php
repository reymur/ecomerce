<header>
    <div class="top-nav container">
        <div class="logo"><a href="/">Ecommerce</a></div>
{{--        @if(! $request->is('checkout'))--}}
        <ul>
            <li><a href="{{ route('shop.index') }}">Shop</a>
            <li><a href="#">About</a></li>
            <li><a href="#">Blog</a></li>
            <li>
                <a href="{{ route('cart.index') }}">
                    Cart @if(Cart::instance('default')->count() > 0)
                        <span class="cart-count">{{ Cart::instance('default')->count() }}</span>
                    @endif
                </a>
            </li>
        </ul>
{{--        @endif--}}

    </div> <!-- end top-nav -->

</header>
