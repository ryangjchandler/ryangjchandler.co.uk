<footer class="container max-w-5xl mx-auto py-12 px-4">
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-12 gap-10 lg:gap-20 mb-3">
        <div class="col-span-3">
            <p class="text-xs text-gray-600">
                A web development blog by a 20-something year old from the United Kingdom.
                Covers a range of topics, including Laravel and JavaScript development.
            </p>
        </div>
        <nav class="col-span-1 md:col-span-1 lg:col-span-2">
            <p class="uppercase text-gray-600 text-xs tracking-wider font-medium mb-3">Menu</p>
            <a href="#"
                class="flex mb-3 md:mb-2 text-sm font-medium text-gray-800 hover:text-primary transition-colors duration-100 ease-in">About</a>
            <a href="#"
                class="flex mb-3 md:mb-2 text-sm font-medium text-gray-800 hover:text-primary transition-colors duration-100 ease-in">Articles</a>
            <a href="#"
                class="flex mb-3 md:mb-2 text-sm font-medium text-gray-800 hover:text-primary transition-colors duration-100 ease-in">Support Me</a>
        </nav>
        <nav class="col-span-2 md:col-span-1 lg:col-span-2">
            <p class="uppercase text-gray-600 text-xs tracking-wider font-medium mb-3">Contact</p>
            <a href="https://twitter.com/ryangjchandler"
                class="flex mb-3 md:mb-2 text-sm font-medium text-gray-800 hover:text-primary transition-colors duration-100 ease-in">Twitter</a>
            <a href="contact@ryangjchandler.co.uk"
                class="flex mb-3 md:mb-2 text-sm font-medium text-gray-800 hover:text-primary transition-colors duration-100 ease-in">Email</a>
            <a href="ads@ryangjchandler.co.uk"
                class="flex mb-3 md:mb-2 text-sm font-medium text-gray-800 hover:text-primary transition-colors duration-100 ease-in">Advertising</a>
        </nav>
        <div class="col-span-4">
            <p class="uppercase text-gray-600 text-xs tracking-wider font-medium mb-3">SUBSCRIBE TO MY NEWSLETTER</p>
            <form action="https://buttondown.email/api/emails/embed-subscribe/ryangjchandler" method="POST"
                target="popupwindow" onsubmit="window.open('https://buttondown.email/ryangjchandler', 'popupwindow')"
                class="mb-2">
                <input type="hidden" value="1" name="embed"></input>
                <div class="form-append">
                    <input class="form-input form-input-sm" type="email" placeholder="Enter your email" />
                    <button class="btn btn-light-primary btn-sm" type="submit">Subscribe</button>
                </div>
            </form>
            <p class="text-xs text-gray-600">
                A fortnightly newsletter for Laravel and JavaScript developers. No spam, don't worry!
            </p>
        </div>
    </div>
    <div
        class="flex flex-col md:flex-row justify-between items-start md:items-center border-t border-gray-200 pt-10 mt-10">
        <p class="text-gray-700 font-medium text-sm text-left mb-6 md:mb-0">© Copyright {{ date('Y') }} Ryan Chandler. All Rights
            Reserved.</p>
    </div>
</footer>
