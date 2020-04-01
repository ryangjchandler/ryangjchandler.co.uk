<footer class="flex items-center justify-between flex-col-reverse md:flex-row text-sm text-gray-600 pl-0 mt-8 border-t pt-4 pb-12">
    <div>
        &copy; 2020 Ryan Chandler All rights reserved.
    </div>
    <div class="mb-4 md:mb-0">
        <nav>
            <ul class="flex items-center">
                <li class="mr-4">
                    <a href="/timeline">Timeline</a>
                </li>
                <li class="mr-4">
                    <a href="/feed.xml">RSS</a>
                </li>
                <li>
                    <a href="/sitemap.xml">Sitemap</a>
                </li>
                <li class="ml-4">
                    <a href="mailto:contact@ryangjchandler.co.uk">Email</a>
                </li>
                <li class="ml-4" x-data="{ showVersion: false }">
                    <a href="#" x-show="!showVersion" @click.prevent="showVersion = !showVersion">Version</a>
                    <a href="#" x-show="showVersion" @click.prevent="showVersion = !showVersion" class="font-mono">
                        {{ $page->getVersion() }}
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</footer>