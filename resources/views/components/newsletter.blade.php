<form action="https://buttondown.email/api/emails/embed-subscribe/ryangjchandler"
    method="POST" target="popupwindow" onsubmit="window.open('https://buttondown.email/ryangjchandler', 'popupwindow')"
    class="w-full bg-brand-primary-100 bg-opacity-50 px-8 py-6"
>
    <h4 class="text-xl font-semibold text-brand-primary-800 mb-1">Want to stay up to date with my articles, videos and other resources?</h4>
    <p class="text-normal font-medium text-brand-primary-500 mb-3 text-sm">I run a fortnightly newsletter for Laravel and JavaScript developers.</p>
    <div class="flex flex-col md:flex-row items-center justify-between mb-2">
        <x-input type="email" name="email" id="bd-email" class="w-full mb-2 md:mb-0" aria-placeholder="mail@ryangjchandler.co.uk" placeholder="mail@ryangjchandler.co.uk" />
        <input type="hidden" value="1" name="embed"></input>
        <button type="submit"
            class="w-full md:w-1/5 md:ml-2 px-4 py-2 border-b-2 rounded-t font-bold text-brand-primary-600 border-brand-primary-400 bg-brand-primary-200"
        >
            Subscribe
        </button>
    </div>
    <small class="text-brand-primary-400">
        Powered by <a href="https://buttondown.email" target="_blank" rel="noopener noreferrer" class="font-semibold underline">Buttondown</a>
    </small>
</form>
