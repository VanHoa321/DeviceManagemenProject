
@php
    $topLevelMenus = $menuItems->where('item_level', 1)->sortBy('item_order');
@endphp

<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        @foreach ($topLevelMenus as $item)
            @php
                $Pid = $item->menu_id;
                $subMenus = $menuItems->where('parent_level', $Pid)->sortBy('item_order')->all();
                $countSubMenus = count($subMenus);
            @endphp

            @if ($countSubMenus > 0)
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="{{ $item->icon }} nav-icon"></i>
                        <p>
                            {{ $item ->menu_name }}
                            <i class="fas fa-angle-left right"></i>
                            <span class="badge badge-info right">{{ $countSubMenus }}</span>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @foreach ($subMenus as $smn)
                            <li class="nav-item">
                                <a href="{{route($smn->route)}}" class="nav-link">
                                    <i class="{{ $smn->icon }} nav-icon"></i>
                                    <p>{{ $smn->menu_name }}</p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @else
                <li class="nav-item">
                    <a href="{{ route($item->route) }}" class="nav-link">
                        <i class="{{ $item->icon }} nav-icon"></i>
                        <p>{{ $item->menu_name }}</p>
                    </a>
                </li>
            @endif
        @endforeach
    </ul>
</nav>
<!-- End Sidebar Menu -->

