<header class="border-b border-gray-200 py-2">
    <div class="max-w-4xl container px-4 mx-auto">
        <nav x-data="{ show: false }" class="py-1 flex flex-col md:flex-row md:items-center justify-between">
            <div class="flex items-center justify-between">
                <h1 class="font-bold">
                    <a href="{{ route('home') }}" class="text-lg">Ryan Chandler</a>
                </h1>
                <button type="button" @click="show = !show"
                    class="menu-button"
                    :class="{ 'border-blue-400 bg-primary-200': show }"
                >
                    Menu
                </button>
            </div>
            <div class="pt-4 md:pt-0 md:block" :class="{ 'block': show, 'hidden': ! show }">
                <ul class="flex flex-col md:flex-row items-center justify-start justify-between font-semibold text-sm">
                    <li class="nav-link">
                        <a href="{{ route('articles.index') }}" class="@active('articles.index', ['active'])">Articles</a>
                    </li>
                    <li class="nav-link">
                        <a href="{{ route('support') }}" class="@active('support', ['active'])">Supporting</a>
                    </li>
                    @guest
                        <li class="auth-nav-link">
                            <a href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="auth-nav-link">
                            <a href="{{ route('register') }}">Register</a>
                        </li>
                    @else
                        <li class="auth-nav-link opacity-25">
                            <a title="Coming soon">Account</a>
                        </li>
                        <li class="auth-nav-link">
                            <x-form-button action="{{ route('logout.submit') }}" buttonClasses="font-bold" style="padding-left: 1.25rem; padding-right: 1.25rem;">
                                Log out
                            </x-form-button>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>
    </div>
</header>
