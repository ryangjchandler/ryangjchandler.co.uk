<header class="z-30 bg-white pl-4 pr-2 sm:px-4 py-4">
    <div class="container max-w-5xl mx-auto flex justify-between items-center">
        <a href="/" title="ryangjchandler.co.uk Home Page" class="flex items-center font-medium">
            Ryan Chandler
        </a>
        <div class="hidden md:inline-flex space-x-1 relative">
            <a href="#" class="btn btn-sm rounded-full btn-white">About</a>
            <a href="#" class="btn btn-sm rounded-full btn-white">Articles</a>
        </div>
        <div class="flex items-center space-x-1">
            <a href="{{ route('support') }}" class="btn btn-sm rounded-full btn-dark">Support Me</a>
            <div class="inline-flex md:hidden" x-data="{ open: true }">
                <button class="btn btn-white btn-sm px-2 flex-none" @click="open = true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        aria-hidden="true">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                    <span class="sr-only">Open Menu</span>
                </button>
                <div class="flex flex-col space-y-1 absolute m-2 top-0 left-0 right-0 rounded bg-white z-50 p-2 border border-gray-300 shadow"
                    x-show.transition="open" @click.away="open = false" x-cloak>
                    <button class="btn btn-link btn-icon px-2 flex-none self-end" @click="open = false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            aria-hidden="true">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                        <span class="sr-only">Close Menu</span>
                    </button>
                    <div class="grid grid-cols-2 gap-1">
                        <a href="#"
                            class="font-semibold rounded px-3 py-2 hover:bg-gray-200 hover:text-primary transition-colors duration-200 ease-in-out">About</a>
                        <a href="#"
                            class="font-semibold rounded px-3 py-2 hover:bg-gray-200 hover:text-primary transition-colors duration-200 ease-in-out">Articles</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
