
<ul>
    @foreach($items as $menu_item)
        <li>
            <a href="{{ $menu_item->link() }}">
                @if(strTolower($menu_item->title) == 'cart')
                    {{ $menu_item->title }}
                    @if(Cart::instance('default')->count() > 0)
                        <span class="cart-count"><span>{{ Cart::instance('default')->count() }}</span></span>
                    @endif
                @else
                    {{ $menu_item->title }}
                @endif
            </a>
        </li>
    @endforeach
</ul>

{{--<ul>--}}
{{--    <li><a href="{{ route('shop.index') }}">Shop</a>--}}
{{--    <li><a href="#">About</a></li>--}}
{{--    <li><a href="#">Blog</a></li>--}}
{{--    <li>--}}
{{--        <a href="{{ route('cart.index') }}">--}}
{{--            Cart @if(Cart::instance('default')->count() > 0)--}}
{{--                <span class="cart-count">{{ Cart::instance('default')->count() }}</span>--}}
{{--            @endif--}}
{{--        </a>--}}
{{--    </li>--}}
{{--</ul>--}}
