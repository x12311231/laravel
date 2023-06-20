<x-layout>
    <x-slot:title>
        Profile
    </x-slot:title>
    <!--
  This example requires some changes to your config:

  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/forms'),
    ],
  }
  ```
-->
    <!--
      This example requires updating your template:

      ```
      <html class="h-full bg-white">
      <body class="h-full">
      ```
    -->
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <x-sitebar></x-sitebar>
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Profile</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                @if (session('status') == 'two-factor-authentication-enabled')
            <form class="space-y-6" action="{{ route('profile.update') }}" method="POST">
                @else
            <form class="space-y-6" action="{{ url('/user/two-factor-authentication') }}" method="POST">
                @endif
                @csrf
                <div>
                    <label for="webSite" class="block text-sm font-medium leading-6 text-gray-900">webSite</label>
                    <div class="mt-2">
                        <input value="{{ $profile->webSite }}" id="webSite" name="webSite" type="text" autocomplete="" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        <x-input-error :messages="$errors->get('webSite')"></x-input-error>
                    </div>
                </div>

                <div>
                    <label for="sex" class="block text-sm font-medium leading-6 text-gray-900">sex</label>
                    <div class="mt-2">
                        <select name="sex" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 text-center bg-white">
                            <option value="male" @if( $profile->sex == 'male' ) selected="selected" @endif>male</option>
                            <option value="female" @if( $profile->sex == 'female' ) selected="selected" @endif>female</option>
                        </select>
                        <x-input-error :messages="$errors->get('sex')"></x-input-error>
                    </div>
                </div>


                <div>
                    <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">update</button>
                </div>
            </form>
        </div>
    </div>

</x-layout>

