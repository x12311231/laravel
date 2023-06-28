<x-layout>
<form wire:submit.prevent="save">

    <label>
        title
        <input type="text" wire:model.defer="post.title">
        <span class="error">

            @error('post.title') {{ $message }} @enderror

        </span>
    </label>


    <label>
        content
        <textarea wire:model.defer="post.content"></textarea>
        <span class="error">

            @error('post.content') {{ $message }} @enderror

        </span>
    </label>


    <button type="submit">Save</button>

</form>
</x-layout>
