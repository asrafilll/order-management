<li class="nav-item {{ $tree && $isActive() ? 'menu-open' : '' }}">
    <a
        href="{!! !is_null($path) && !$tree ? $path : '#' !!}"
        class="nav-link {{ $isActive() ? 'active' : '' }}"
    >
        {!! $slot !!}
    </a>
    @if ($tree)
        <ul class="nav nav-treeview">
            {!! $items !!}
        </ul>
    @endif
</li>
