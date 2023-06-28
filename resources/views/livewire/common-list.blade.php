<div>
    {{-- Stop trying to control. --}}
    <ul>
    @foreach($items as $item)
        {{ json_encode($item) }}
    @endforeach
    </ul>
</div>
