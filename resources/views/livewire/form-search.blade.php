<form wire:submit.prevent="submit">
    <label>
        {{ $label }}
        <input type="text" name="query" wire:model="query">
    </label>
    <div>{{ $query }}</div>
    <button type="submit">Search</button>
</form>

