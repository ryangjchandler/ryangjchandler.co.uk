@extends('_layouts.master')

@section('title', 'Timeline - Ryan Chandler')

@section('body')
    <main class="markup">
        <h1>Timeline</h1>
        <p>
            This page provides a sweet little timeline of the different iterations this site has taken.
            I'll like to <em>try</em> and keep this updated with new images each time I make a change to the site
            but there is definitely no promises being made. It's more for my personal benefit of seeing how good
            or bad my design skills get as time goes on.
        </p>
        @foreach($timeline as $timelineEntry)
            @include('_partials._timeline-entry', ['timeline' => $timelineEntry])
        @endforeach
    </main>
@endsection