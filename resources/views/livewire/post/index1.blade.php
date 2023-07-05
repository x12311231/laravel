<div>
    <label for="">
        <input wire:offline.attr="disabled" type="text" wire:model="query">
    </label>
    <div class="ml-1 mr-1">
        @foreach($posts as $post)
            <div class="shadow-sm border border-gray-200 bg-black">
                <h4>title: {{ $post->title }}</h4>
                @if ($contentIsVisible)<p>content: {{ $post->content }}</p>@endif
            </div>
        @endforeach
    </div>
    {{ $posts->links() }}

    <div wire:poll.keep-alive>
        Current time: {{ now() }}
    </div>
    <button wire:click.prefetch="toggleContent">@if ($contentIsVisible)Hide Content @else Show Content @endif</button>

    @if ($contentIsVisible)

        <span>Some Content...</span>

    @endif

    <livewire:utils.offline />
</div>
