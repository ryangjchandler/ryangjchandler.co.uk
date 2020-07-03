<footer class="border-t border-gray-200 py-2">
    <div class="max-w-4xl container px-4 mx-auto">
        <div class="flex items-center justify-between">
            <div>
                <small class="text-gray-600">&copy; {{ date('Y') }} All rights reserved.</small>
            </div>
            <div>
                <small class="text-blue-400 mr-4">
                    <a href="https://twitter.com/ryangjchandler" target="_blank" rel="noopener noreferrer" class="text-sm text-blue-400 hover:underline">
                        Twitter
                    </a>
                </small>
                <small class="text-blue-400 mr-4">
                    <a href="https://github.com/ryangjchandler" target="_blank" rel="noopener noreferrer" class="text-sm text-blue-400 hover:underline">
                        GitHub
                    </a>
                </small>
                <small class="text-blue-400">
                    <a href="{{ route('feeds.main') }}" target="_blank" rel="noopener noreferrer" class="text-sm text-blue-400 hover:underline">
                        RSS
                    </a>
                </small>
            </div>
        </div>
    </div>
</footer>
