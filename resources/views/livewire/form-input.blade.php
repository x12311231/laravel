<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <label for="{{ $name }}">
        <div class="text-red-600">{{ $label }}</div>
        <input name="{{ $name }}" value="{{ $value }}" wire:model.defer="value" placeholder="{{ $placeholder }}" type="text" class="shadow-sm border-0 "/>

        <div>
            input value: {{ $value }}
        </div>
    </label>
</div>
