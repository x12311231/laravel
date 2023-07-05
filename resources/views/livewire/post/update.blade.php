<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <form wire:submit.prevent="update">

        <div>

            @if (session()->has('message'))

                <div class="alert alert-success">

                    {{ session('message') }}

                </div>

            @endif

        </div>
        <div>

        </div>



        Title: <input wire:model="post.title" type="text">

        <div wire:loading wire:target="update">

            Processing Payment...

        </div>

        <button>Save</button>

    </form>
</div>
