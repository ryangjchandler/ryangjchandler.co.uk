<div class="timeline-entry">
    <h3 class="mb-4 underline">{{ $timeline->title }} - {{ date('d, F Y', $timeline->date) }}</h3>
    {!! $timeline->getContent() !!}
</div>