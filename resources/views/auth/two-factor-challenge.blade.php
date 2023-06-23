<x-layout>
    <x-slot:title>
        two factor challenge
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
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">two factor challenge</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form action="{{ url('two-factor-challenge') }}" method="post">
                @csrf
                <div>
                    <div class="flex items-center justify-between">
                        <label for="recovery_code" class="block text-sm font-medium leading-6 text-gray-900">Recovery code</label>
                    </div>
                    <div class="mt-2">
                        <input id="recovery_code" name="recovery_code" type="text" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        <x-input-error :messages="$errors->get('recovery_code')"></x-input-error>
                    </div>
                </div>
                <div class="pt-4">
                    <button type="submit" class="pt-4 flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <script>
    </script>
</x-layout>

