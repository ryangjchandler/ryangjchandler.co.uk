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
                <ul class="flex flex-col md:flex-row items-center justify-start md:justify-between font-semibold text-sm">
                    <li class="nav-link">
                        <a href="{{ route('articles.index') }}" class="@active('articles.index', ['active'])" title="Articles">
                            Articles
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="{{ route('talks') }}" class="@active('support', ['active'])" title="Supporting">
                            Talks
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="{{ route('support') }}" class="@active('support', ['active'])" title="Supporting">
                            Supporting
                        </a>
                    </li>
                    @guest
                        <li class="auth-nav-link">
                            <a href="{{ route('login') }}">Login</a>
                        </li>
                    @endguest
                    <li class="text-primary-300 px-1 py-1 hover:text-primary-500 hover:bg-primary-100 focus:text-primary-500 focus:bg-primary-100 rounded">
                        <a href="{{ route('feeds.main') }}" title="RSS Feed">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-rss"><path d="M4 11a9 9 0 0 1 9 9"></path><path d="M4 4a16 16 0 0 1 16 16"></path><circle cx="5" cy="19" r="1"></circle></svg>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>
