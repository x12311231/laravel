<x-layout>
    <x-slot:title>
        qr code
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
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">qr code</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            @if (session('status') == 'two-factor-authentication-confirmed')
                <div class="mb-4 font-medium text-sm">
                    Two factor authentication confirmed and enabled successfully.
                </div>
            @elseif (session('status') == 'two-factor-authentication-enabled')
                <div class="mb-4 font-medium text-sm">
                    Please finish configuring two factor authentication below.
                    {!! $request->user()->twoFactorQrCodeSvg() !!}
                </div>
                <form action="{{ route('two-factor.confirm') }}" method="post">
                    @csrf
                    <label for="code">
                        code:
                        <input type="text" name="code" class="border-0 focus:ring-2 focus:ring-indigo-600 shadow-sm">
                        <button>submit</button>
                    </label>
                </form>
            @else
                <form action="{{ route('two-factor.enable') }}" method="post">
                    @csrf
                    two factor enable
                    <button>next</button>
                </form>
            @endif
                <x-input-error :messages="$errors->get('code')"></x-input-error>
        </div>
    </div>
    <script>
    </script>
</x-layout>

