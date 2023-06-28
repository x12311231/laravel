<div>

    <input wire:model="search" type="text" placeholder="Search users..."/>



    <ul>

        @foreach($users as $user)

            <li>user: {{ $user->name }}</li>
            <li>email: {{ $user->email }}</li>

        @endforeach

    </ul>

</div>
