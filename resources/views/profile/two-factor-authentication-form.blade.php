<x-action-section>
    <x-slot name="title">
        {{ __('Екі факторлы аутентификация') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Екі факторлы аутентификация арқылы есептік жазбаңыздың қауіпсіздігін арттырыңыз.') }}
    </x-slot>

    <x-slot name="content">
        <h3 class="text-lg font-medium text-gray-900">
            @if ($this->enabled)
                @if ($showingConfirmation)
                    {{ __('Екі факторлы аутентификацияны қосуды аяқтаңыз.') }}
                @else
                    {{ __('Сіз екі факторлы аутентификацияны қостыңыз.') }}
                @endif
            @else
                {{ __('Сіз екі факторлы аутентификацияны қосқан жоқсыз.') }}
            @endif
        </h3>

        <div class="mt-3 max-w-xl text-sm text-gray-600">
            <p>
                {{ __('Егер екі факторлы аутентификация қосулы болса, сізден аутентификация кезінде қауіпсіз кездейсоқ таңбалауышты енгізу сұралады. Бұл таңбалауышты телефондағы Google Authenticator қолданбасынан алуға болады.') }}
            </p>
        </div>

        @if ($this->enabled)
            @if ($showingQrCode)
                <div class="mt-4 max-w-xl text-sm text-gray-600">
                    <p class="font-semibold">
                        @if ($showingConfirmation)
                            {{ __('Екі факторлы аутентификацияны қосуды аяқтау үшін телефондағы authenticator қолданбасын пайдаланып келесі QR кодын сканерлеңіз немесе орнату кілтін енгізіп, жасалған OTP кодын енгізіңіз.') }}
                        @else
                            {{ __('Енді екі факторлы аутентификация қосылды. Телефондағы аутентификация қолданбасын пайдаланып келесі QR кодын сканерлеңіз немесе орнату кілтін енгізіңіз.') }}
                        @endif
                    </p>
                </div>

                <div class="mt-4 p-2 inline-block bg-white">
                    {!! $this->user->twoFactorQrCodeSvg() !!}
                </div>

                <div class="mt-4 max-w-xl text-sm text-gray-600">
                    <p class="font-semibold">
                        {{ __('Setup Key') }}: {{ decrypt($this->user->two_factor_secret) }}
                    </p>
                </div>

                @if ($showingConfirmation)
                    <div class="mt-4">
                        <x-label for="code" value="{{ __('Код') }}" />

                        <x-input id="code" type="text" name="code" class="block mt-1 w-1/2" inputmode="numeric" autofocus autocomplete="one-time-code"
                            wire:model="code"
                            wire:keydown.enter="confirmTwoFactorAuthentication" />

                        <x-input-error for="code" class="mt-2" />
                    </div>
                @endif
            @endif

            @if ($showingRecoveryCodes)
                <div class="mt-4 max-w-xl text-sm text-gray-600">
                    <p class="font-semibold">
                        {{ __('Бұл қалпына келтіру кодтарын қауіпсіз пароль менеджерінде сақтаңыз. Олар екі факторлы аутентификация құрылғысы жоғалған жағдайда есептік жазбаңызға кіруді қалпына келтіру үшін пайдаланылуы мүмкін.') }}
                    </p>
                </div>

                <div class="grid gap-1 max-w-xl mt-4 px-4 py-4 font-mono text-sm bg-gray-100 rounded-lg">
                    @foreach (json_decode(decrypt($this->user->two_factor_recovery_codes), true) as $code)
                        <div>{{ $code }}</div>
                    @endforeach
                </div>
            @endif
        @endif

        <div class="mt-5">
            @if (! $this->enabled)
                <x-confirms-password wire:then="enableTwoFactorAuthentication">
                    <x-button type="button" wire:loading.attr="disabled">
                        {{ __('Қосу') }}
                    </x-button>
                </x-confirms-password>
            @else
                @if ($showingRecoveryCodes)
                    <x-confirms-password wire:then="regenerateRecoveryCodes">
                        <x-secondary-button class="me-3">
                            {{ __('Қалпына келтіру кодтарын қалпына келтіріңіз') }}
                        </x-secondary-button>
                    </x-confirms-password>
                @elseif ($showingConfirmation)
                    <x-confirms-password wire:then="confirmTwoFactorAuthentication">
                        <x-button type="button" class="me-3" wire:loading.attr="disabled">
                            {{ __('Растау') }}
                        </x-button>
                    </x-confirms-password>
                @else
                    <x-confirms-password wire:then="showRecoveryCodes">
                        <x-secondary-button class="me-3">
                            {{ __('Қалпына келтіру кодтарын көрсету') }}
                        </x-secondary-button>
                    </x-confirms-password>
                @endif

                @if ($showingConfirmation)
                    <x-confirms-password wire:then="disableTwoFactorAuthentication">
                        <x-secondary-button wire:loading.attr="disabled">
                            {{ __('Бас тарту') }}
                        </x-secondary-button>
                    </x-confirms-password>
                @else
                    <x-confirms-password wire:then="disableTwoFactorAuthentication">
                        <x-danger-button wire:loading.attr="disabled">
                            {{ __('Өшіру') }}
                        </x-danger-button>
                    </x-confirms-password>
                @endif

            @endif
        </div>
    </x-slot>
</x-action-section>
