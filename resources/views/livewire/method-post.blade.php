<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <form wire:submit.prevent="submit">
        <label>
            str
            <input type="text" wire:model="str">
            <span class="error">
                @error('str') {{ $message }} @enderror
            </span>
        </label>
        <div>
            str output:
            <span>{{ $str }}</span>
        </div>
        <button type="submit">Submit</button>
    </form>
</div>
