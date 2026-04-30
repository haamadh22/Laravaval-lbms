@php
    $currentRoute = Route::currentRouteName();
    $user = Auth::user();
    $role = $user->role ?? 'user';
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    {{-- Brand --}}
    <div class="app-brand demo">
        <a href="{{ $role === 'admin' ? route('admin.dashboard') : route('dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo me-1">
                <span class="text-primary">
                    <svg width="30" height="24" viewBox="0 0 250 196" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M12.3002 1.25469L56.655 28.6432C59.0349 30.1128 60.4839 32.711 60.4839 35.5089V160.63C60.4839 163.468 58.9941 166.097 56.5603 167.553L12.2055 194.107C8.3836 196.395 3.43136 195.15 1.14435 191.327C0.395485 190.075 0 188.643 0 187.184V8.12039C0 3.66447 3.61061 0.0522461 8.06452 0.0522461C9.56056 0.0522461 11.0271 0.468577 12.3002 1.25469Z"
                            fill="currentColor" />
                        <path opacity="0.077704" fill-rule="evenodd" clip-rule="evenodd"
                            d="M0 65.2656L60.4839 99.9629V133.979L0 65.2656Z" fill="black" />
                        <path opacity="0.077704" fill-rule="evenodd" clip-rule="evenodd"
                            d="M0 65.2656L60.4839 99.0795V119.859L0 65.2656Z" fill="black" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M237.71 1.22393L193.355 28.5207C190.97 29.9889 189.516 32.5905 189.516 35.3927V160.631C189.516 163.469 191.006 166.098 193.44 167.555L237.794 194.108C241.616 196.396 246.569 195.151 248.856 191.328C249.605 190.076 250 188.644 250 187.185V8.09597C250 3.64006 246.389 0.027832 241.935 0.027832C240.444 0.027832 238.981 0.441882 237.71 1.22393Z"
                            fill="currentColor" />
                        <path opacity="0.077704" fill-rule="evenodd" clip-rule="evenodd"
                            d="M250 65.2656L189.516 99.8897V135.006L250 65.2656Z" fill="black" />
                        <path opacity="0.077704" fill-rule="evenodd" clip-rule="evenodd"
                            d="M250 65.2656L189.516 99.0497V120.886L250 65.2656Z" fill="black" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M12.2787 1.18923L125 70.3075V136.87L0 65.2465V8.06814C0 3.61223 3.61061 0 8.06452 0C9.552 0 11.0105 0.411583 12.2787 1.18923Z"
                            fill="currentColor" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M12.2787 1.18923L125 70.3075V136.87L0 65.2465V8.06814C0 3.61223 3.61061 0 8.06452 0C9.552 0 11.0105 0.411583 12.2787 1.18923Z"
                            fill="white" fill-opacity="0.15" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M237.721 1.18923L125 70.3075V136.87L250 65.2465V8.06814C250 3.61223 246.389 0 241.935 0C240.448 0 238.99 0.411583 237.721 1.18923Z"
                            fill="currentColor" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M237.721 1.18923L125 70.3075V136.87L250 65.2465V8.06814C250 3.61223 246.389 0 241.935 0C240.448 0 238.99 0.411583 237.721 1.18923Z"
                            fill="white" fill-opacity="0.3" />
                    </svg>
                </span>
            </span>
            <span class="app-brand-text demo menu-text fw-semibold ms-2">Imara</span>
        </a>
 
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        {{-- ===== DASHBOARD ===== --}}


        {{-- ===== ADMIN MENU ===== --}}
        @if ($role === 'admin')

                <li class="menu-item {{ in_array($currentRoute, ['dashboard', 'admin.dashboard']) ? 'active' : '' }}">
            <a href="{{ $role === 'admin' ? route('admin.dashboard') : route('dashboard') }}" class="menu-link">
                <i class="menu-icon ri ri-dashboard-line"></i>
                <div>Dashboard</div>
            </a>
        </li>
{{-- Members --}}
<li class="menu-item {{ in_array($currentRoute, ['members.index','members.create']) ? 'active open' : '' }}">
    
    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon ri ri-group-line"></i>
        <div>Members</div>
    </a>

    <ul class="menu-sub">

        {{-- All Members --}}
        <li class="menu-item {{ $currentRoute === 'members.index' ? 'active' : '' }}">
            <a href="{{ route('members.index') }}" class="menu-link">
                <div>All Members</div>
            </a>
        </li>

      
        <li class="menu-item {{ $currentRoute === 'members.create' ? 'active' : '' }}">
            <a href="{{ route('members.create') }}" class="menu-link">
    <div>Register Member</div>
                </a>
                        </li>

                    </ul>
                </li>
                            
            {{-- Books --}}
           <li class="menu-item {{ request()->routeIs([
                    'books.*',
                    'admin.categories',
                    'admin.authors'
                ]) ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon ri ri-book-open-line"></i>
                    <div>Books</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ $currentRoute === 'books.index' ? 'active' : '' }}">
                        <a href="{{ route('books.index') }}" class="menu-link">
                            <div>All Books</div>
                        </a>
                    </li>
                    
                    
                    <li class="menu-item {{ $currentRoute === 'admin.categories' ? 'active' : '' }}">
                        <a href="{{ route('admin.categories') }}" class="menu-link">
                            <div>Categories</div>
                        </a>
                    </li>

                    {{-- Authors --}}
                    <li class="menu-item {{ $currentRoute === 'admin.authors' ? 'active' : '' }}">
                        <a href="{{ route('admin.authors') }}" class="menu-link">
                            <div>Authors</div>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Issue / Return --}}
            <li class="menu-item {{ in_array($currentRoute, ['issue.book', 'return.book', 'issued.books', 'borrow.history']) ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon ri ri-exchange-line"></i>
                    <div>Issue / Return</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ $currentRoute === 'issue.book' ? 'active' : '' }}">
                        <a href="{{ route('issue.book') }}" class="menu-link">
                            <div>Issue Book</div>
                        </a>
                    </li>
                    <li class="menu-item {{ $currentRoute === 'return.book' ? 'active' : '' }}">
                        <a href="{{ route('return.book') }}" class="menu-link">
                            <div>Return Book</div>
                        </a>
                    </li>
                    <li class="menu-item {{ $currentRoute === 'issued.books' ? 'active' : '' }}">
                        <a href="{{ route('issued.books') }}" class="menu-link">
                            <div>Issued Books</div>
                        </a>
                    </li>
                    <li class="menu-item {{ $currentRoute === 'borrow.history' ? 'active' : '' }}">
                        <a href="{{ route('borrow.history') }}" class="menu-link">
                            <div>Borrow History</div>
                        </a>
                    </li>
                </ul>
            </li>

        @endif
        {{-- ===== / ADMIN MENU ===== --}}

        {{-- ===== USER/MEMBER MENU ===== --}}
        {{-- @dd($role) --}}
      @if ($role === 'member')

<li class="menu-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
    <a href="{{ route('user.dashboard') }}" class="menu-link">
        <i class="menu-icon ri ri-dashboard-line"></i>
        <div>Dashboard</div>
    </a>
</li>

<li class="menu-item {{ request()->routeIs('user.mybooks') ? 'active' : '' }}">
    <a href="{{ route('user.mybooks') }}" class="menu-link">
        <i class="menu-icon ri ri-book-2-line"></i>
        <div>My Borrowed Books</div>
    </a>
</li>

<li class="menu-item {{ request()->routeIs('user.profile') ? 'active' : '' }}">
    <a href="{{ route('user.profile') }}" class="menu-link">
        <i class="menu-icon ri ri-user-line"></i>
        <div>My Profile</div>
    </a>
</li>

@endif
        {{-- ===== / USER MENU ===== --}}

    </ul>
</aside>
