<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Құпия сөзіңізді ұмытып қалдыңыз ба? Ешқандай проблема жоқ. Бізге электрондық пошта мекенжайыңызды айтыңыз, біз сізге жаңасын таңдауға мүмкіндік беретін құпия сөзді қалпына келтіру сілтемесін жібереміз.') }}
        </div>

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <x-label for="email" value="{{ __('Эл.почта') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Электрондық пошта құпия сөзін қалпына келтіру') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
