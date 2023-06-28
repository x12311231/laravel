<x-layout>
    <livewire:form-search label="search"/>
    <div class="ml-1 mr-1">
        @foreach($posts as $post)
            <div class="shadow-sm border border-gray-200 bg-black">
                <h4>title: {{ $post->title }}</h4>
                <p>content: {{ $post->content }}</p>
            </div>
        @endforeach
    </div>
    {{ $posts->links() }}
</x-layout>
