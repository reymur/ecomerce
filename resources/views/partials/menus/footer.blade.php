<ul>
    @foreach($items as $menu_item)
        @if(strTolower($menu_item->title) === 'follow me')
            <li>
                {{ $menu_item->title }}:
            </li>
        @else
            <li>
                <a href="{{ $menu_item->link() }}">
                    <i class="fa {{ $menu_item->title }}"></i>
                </a>
            </li>
        @endif
    @endforeach
</ul>
