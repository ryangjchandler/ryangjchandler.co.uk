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
            <h3 class="mb-4 underline">Goodbye, Highlight.js - 30, March 2020</h3>
            <p class="mb-4">
                So, I removed Highlight.js. This is in an effort to remove any unnecessary JavaScript and other
                assets. Instead, I've chosen to go with <a href="https://twitter.com/calebporzio">Caleb Porzio's</a>
                <a href="https://github.com/calebporzio/gitdown">GitDown</a> package which uses the open GitHub API
                to parse the Markdown instead. It returns the syntax-marked HTML too, as well as the styles for the 
                code blocks. It looks and works great, and it also saves me some JavaScript stuffs. 
            </p>
            <strong class="inline-block mb-2">Before:</strong>
            <div class="border shadow-lg mb-4">
                <img src="/assets/images/timeline/2020-03-30-code-before.png" alt="30, March 2020 Screenshot of Code Blocks Before">
            </div>
            <strong class="inline-block mb-2">After:</strong>
            <div class="border shadow-lg mb-4">
                <img src="/assets/images/timeline/2020-03-30-code-after.png" alt="30, March 2020 Screenshot of Code Blocks After">
            </div>
            <p>
                I'm not sure what sort of performance gain I've achieved, but there's no JavaScript at all on the site now which I'm
                pleased about. If there is any in the future, it will just be <a href="https://github.com/alpinejs/alpine">Alpine</a>.
            </p>
            <p class="mb-4">
                I wasn't much of a fan of that orange colour either so win win I guess.
            </p>
            <div class="border shadow-lg mb-4">
                <div style="width:100%;height:0;padding-bottom:100%;position:relative;"><iframe src="https://giphy.com/embed/h5cZakvQ2hq0Vw4G22" width="100%" height="100%" style="position:absolute" frameBorder="0" class="giphy-embed" allowFullScreen></iframe></div></p>
            </div>
        </div>
        <div>
            <h3 class="mb-4 underline">Timeline & Footer - 30, March 2020</h3>
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
            <h3 class="mb-4 underline">Initial Release - 28, March 2020</h3>
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