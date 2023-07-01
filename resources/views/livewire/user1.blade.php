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
            age
            <input type="text" wire:model.defer="age">
            <span class="error">
                @error('age') {{ $message }} @enderror
            </span>
        </label>
        <label>
            email
            <input type="text" wire:model.defer="email">
            <span class="error">
                @error('email') {{ $message }} @enderror
            </span>
        </label>
        <button type="submit">Submit</button>
    </form>
</div>
