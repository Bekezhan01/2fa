<x-action-section>
    <x-slot name="title">
        {{ __('Есептік жазбаны жою') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Есептік жазбаңызды біржола жойыңыз.') }}
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600">
            {{ __('Есептік жазбаңыз жойылғаннан кейін оның барлық ресурстары мен деректері біржола жойылады. Есептік жазбаңызды жоймас бұрын сақтағыңыз келетін кез келген деректерді немесе ақпаратты жүктеп алыңыз.') }}
        </div>

        <div class="mt-5">
            <x-danger-button wire:click="confirmUserDeletion" wire:loading.attr="disabled">
                {{ __('Есептік жазбаны жою') }}
            </x-danger-button>
        </div>

        <!-- Delete User Confirmation Modal -->
        <x-dialog-modal wire:model.live="confirmingUserDeletion">
            <x-slot name="title">
                {{ __('Есептік жазбаны жою') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Сіз өзіңіздің есептік жазбаңызды жойғыңыз келетініне сенімдісіз бе? Есептік жазбаңыз жойылғаннан кейін оның барлық ресурстары мен деректері біржола жойылады. Есептік жазбаңызды біржола жойғыңыз келетінін растау үшін құпия сөзді енгізіңіз.') }}

                <div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                    <x-input type="password" class="mt-1 block w-3/4"
                                autocomplete="current-password"
                                placeholder="{{ __('Құпия сөз') }}"
                                x-ref="password"
                                wire:model="password"
                                wire:keydown.enter="deleteUser" />

                    <x-input-error for="password" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled">
                    {{ __('Бас тарту') }}
                </x-secondary-button>

                <x-danger-button class="ms-3" wire:click="deleteUser" wire:loading.attr="disabled">
                    {{ __('Есептік жазбаны жою') }}
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
    </x-slot>
</x-action-section>
