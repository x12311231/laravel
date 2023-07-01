<x-layout>
<form wire:submit.prevent="save">
{{--    <input type="hidden" wire:key="post.id">--}}
{{--    <input type="text" wire:model="post.id">--}}
    <label>
        title
        <input type="text" wire:model="post.title">
        <span class="error">

            @error('post.title') {{ $message }} @enderror

        </span>
    </label>


    <label>
        content
        <textarea wire:model="post.content"></textarea>
        <span class="error">

            @error('post.content') {{ $message }} @enderror

        </span>
    </label>


    <button type="submit">Save</button>

</form>
</x-layout>

<script>

    // document.addEventListener("DOMContentLoaded", () => {
    //
    //     Livewire.hook('component.initialized', (component) => {console.log(component)})
    //
    //     Livewire.hook('element.initialized', (el, component) => {console.log(component)})
    //
    //     Livewire.hook('element.updating', (fromEl, toEl, component) => {console.log(component)})
    //
    //     Livewire.hook('element.updated', (el, component) => {console.log(component)})
    //
    //     Livewire.hook('element.removed', (el, component) => {console.log(component)})
    //
    //     Livewire.hook('message.sent', (message, component) => {console.log(component)})
    //
    //     Livewire.hook('message.failed', (message, component) => {console.log(component)})
    //
    //     Livewire.hook('message.received', (message, component) => {console.log(component)})
    //
    //     Livewire.hook('message.processed', (message, component) => {console.log(component)})
    //
    // });

</script>
