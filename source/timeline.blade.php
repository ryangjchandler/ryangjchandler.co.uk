@extends('_layouts.master')

@section('body')
    <main class="markup">
        <h1>Timeline</h1>
        <p>
            This page provides a sweet little timeline of the different iterations this site has taken.
            I'll like to <em>try</em> and keep this updated with new images each time I make a change to the site
            but there is definitely no promises being made. It's more for my personal benefit of seeing how good
            or bad my design skills get as time goes on.
        </p>
        <div>
            <h3 class="mb-4">Timeline & Footer - 30, March 2020</h3>
            <p class="mb-4">
                Pretty successful change. I added a footer to the site, along with a proper sitemap and RSS feed
                so that my <strong>massive</strong> number of followers and readers can hook that up to their RSS feed apps.
            </p>
            <div class="border shadow-lg mb-4">
                <img src="/assets/images/timeline/2020-03-30-footer.png" alt="30, March 2020 Screenshot of Footer">
            </div>
            <p class="mb-4">
                Today was also the day that I deployed this new timeline thing. I think it's a pretty nifty idea. I'd love
                to come back and do some sort of timeline-ception thing, but I can't be arsed right now. This is the best I've got.
            </p>
            <div class="border shadow-lg">
                <img src="/assets/images/timeline/2020-03-30-timeline.png" alt="30, March 2020 Screenshot of Timeline Page">
            </div>
        </div>
        <div>
            <h3 class="mb-4">Initial Release - 28, March 2020</h3>
            <p class="mb-4">
                This was the initial version of my personal site. I wanted a super minimal design with barebones features.
                Looking back now, I should have added some more stuff and the launch wasn't the smoothest. I decided to change
                all of my DNS settings after announcing the first post. I disabled Cloudflare and relied 100% on Netlify's own
                DNS service. Could have been worse, to be honest.
            </p>
            <div class="border shadow-lg">
                <img src="/assets/images/timeline/2020-03-28.png" alt="28, March 2020 Screenshot">
            </div>
        </div>
    </main>
@endsection