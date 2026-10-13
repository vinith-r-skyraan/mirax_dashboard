<div id="sidebar" class="sidebar">
    <div class="menu-scroll">

        <a href="{{ route('dashboard.index') }}"
           class="{{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>
            <span class="menu-text">Dashboard</span>
        </a>

        <a href="{{ route('blogs.index') }}"
           class="{{ request()->routeIs('blogs.*') ? 'active' : '' }}">
            <i class="bi bi-journal-text"></i>
            <span class="menu-text">Blogs</span>
        </a>

        {{-- <a class="sidebar-toggle {{ request()->routeIs('members.*') ? 'active' : '' }}"
           data-bs-toggle="collapse"
           href="#membersMenu">
            <i class="bi bi-people"></i>
            <span class="menu-text">Members</span>
            <span class="arrow ms-auto">
                <i class="bi bi-chevron-down"></i>
            </span>
        </a>

        <div class="collapse ps-3 {{ request()->routeIs('members.*') ? 'show' : '' }}"
             id="membersMenu">
            <a href="{{ route('members.create') }}"
               class="{{ request()->routeIs('members.create') ? 'active' : '' }}">
                <i class="bi bi-person-plus"></i> Add
            </a>
            <a href="{{ route('members.index') }}"
               class="{{ request()->routeIs('members.index') ? 'active' : '' }}">
                <i class="bi bi-card-list"></i> View Info
            </a>
            <a href="{{ route('members.trash') }}"
               class="{{ request()->routeIs('members.trash') ? 'active' : '' }}">
                <i class="bi bi-trash"></i> Deleted Info
            </a>
        </div>

        <a class="sidebar-toggle {{ request()->routeIs('subscriptions.*') ? 'active' : '' }}"
           data-bs-toggle="collapse"
           href="#subscriptionMenu">
            <i class="bi bi-journal-text"></i>
            <span class="menu-text">Subscription</span>
            <span class="arrow ms-auto">
                <i class="bi bi-chevron-down"></i>
            </span>
        </a>

        <div class="collapse ps-3 {{ request()->routeIs('subscriptions.*') ? 'show' : '' }}"
             id="subscriptionMenu">
            <a href="{{ route('subscriptions.create') }}"
               class="{{ request()->routeIs('subscriptions.create') ? 'active' : '' }}">
                <i class="bi bi-plus-circle"></i> Add
            </a>
            <a href="{{ route('subscriptions.index') }}"
               class="{{ request()->routeIs('subscriptions.index') ? 'active' : '' }}">
                <i class="bi bi-list-check"></i> View Info
            </a>
            <a href="{{ route('subscriptions.trash') }}"
               class="{{ request()->routeIs('subscriptions.trash') ? 'active' : '' }}">
                <i class="bi bi-trash"></i> Deleted Info
            </a>
        </div>

        <a class="sidebar-toggle {{ request()->routeIs('trainers.*') ? 'active' : '' }}"
           data-bs-toggle="collapse"
           href="#trainerMenu">
            <i class="bi bi-person-badge"></i>
            <span class="menu-text">Trainer</span>
            <span class="arrow ms-auto">
                <i class="bi bi-chevron-down"></i>
            </span>
        </a>

        <div class="collapse ps-3 {{ request()->routeIs('trainers.*') ? 'show' : '' }}"
             id="trainerMenu">
            <a href="{{ route('trainers.create') }}"
               class="{{ request()->routeIs('trainers.create') ? 'active' : '' }}">
                <i class="bi bi-person-plus"></i> Add
            </a>
            <a href="{{ route('trainers.index') }}"
               class="{{ request()->routeIs('trainers.index') ? 'active' : '' }}">
                <i class="bi bi-card-list"></i> View Info
            </a>
            <a href="{{ route('trainers.trash') }}"
               class="{{ request()->routeIs('trainers.trash') ? 'active' : '' }}">
                <i class="bi bi-trash"></i> Deleted Info
            </a>
        </div>

        <div class="sidebar-logout mt-auto px-2 py-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn w-100 text-start text-danger">
                    <i class="bi bi-box-arrow-right"></i>
                    <span class="menu-text">Logout</span>
                </button>
            </form>
        </div> --}}

    </div>
</div>


