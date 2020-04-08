<div class="timeline-entry">
    <h3 class="mb-4 underline dark:text-gray-300">{{ $timeline->title }} - {{ date('d, F Y', $timeline->date) }}</h3>
    <div class="text-gray-400">
        {!! $timeline->getContent() !!}
    </div>
</div>