<x-layouts.main title="Bytes">
    <section>
        @foreach($bytes as $byte)
            <div class="space-y-4 {{ $loop->last ? 'mb-16' : null }}">
                <div class="space-y-4">
                    <p class="block text-2xl font-bold">
                        {{ $byte->title }}
                    </p>

                    <div class="prose">
                        @markdown($byte->content, 'byte-content-' . $byte->getKey())
                    </div>
                </div>
            </div>

            @if(! $loop->last)
                <hr class="my-8">
            @endif
        @endforeach
    </section>

    <section>
        {{ $bytes->links() }}
    </section>
</x-layouts.main>
