<x-form-section submit="updatePassword">
    <x-slot name="title">
        {{ __('Құпия сөзді жаңарту') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Қауіпсіздікті қамтамасыз ету үшін есептік жазбаңызда ұзақ, кездейсоқ құпия сөз қолданылғанына көз жеткізіңіз.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-label for="current_password" value="{{ __('Ағымдағы құпия сөз') }}" />
            <x-input id="current_password" type="password" class="mt-1 block w-full" wire:model="state.current_password" autocomplete="current-password" />
            <x-input-error for="current_password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="password" value="{{ __('Жаңа құпия сөз') }}" />
            <x-input id="password" type="password" class="mt-1 block w-full" wire:model="state.password" autocomplete="new-password" />
            <x-input-error for="password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="password_confirmation" value="{{ __('Құпия сөзді растаңыз') }}" />
            <x-input id="password_confirmation" type="password" class="mt-1 block w-full" wire:model="state.password_confirmation" autocomplete="new-password" />
            <x-input-error for="password_confirmation" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            {{ __('Сақталды.') }}
        </x-action-message>

        <x-button>
            {{ __('Сақтау') }}
        </x-button>
    </x-slot>
</x-form-section>
