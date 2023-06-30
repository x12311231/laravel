<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <form wire:submit.prevent="submit">
        <label>
            name
            <input type="text" wire:model="name">
            <span class="error">
                @error('name') {{ $message }} @enderror
            </span>
        </label>
        <div>
            name output:
            <span>{{ $name }}</span>
        </div>

        <label>
            article title
            <input type="text" wire:model.defer="article.title">
            <span class="error">
                @error('article.title') {{ $message }} @enderror
            </span>
        </label>
        <label>
            article content
            <input type="text" wire:model.defer="article.content">
            <span class="error">
                @error('article.content') {{ $message }} @enderror
            </span>
        </label>
        <button type="submit">Submit</button>
    </form>
</div>
