<section>
    <header>
        <h2 class="text-lg font-medium text-gray-700 dark:text-gray-400">
            {{ __('Información del Perfil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-800 dark:text-gray-500">
            {{ __("Actualice la información del perfil y la dirección de correo electrónico de su cuenta.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-form.input-label for="name" 
                :value="__('Nombre:')" 
                />
            <x-form.text-input
                type="text"
                name="name"
                placeholder="Escribe el nombre"
                :value="$user->name " 
                :messages="$errors->get('name')"
            />    
            <x-form.input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <div>
                <x-form.input-label for="email" 
                    :value="__('Email:')" 
                    />
                <x-form.text-input
                    type="text"
                    name="email"
                    placeholder="Escribe el email"
                    :value="$user->email " 
                    :messages="$errors->get('email')"
                />    
                <x-form.input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
                
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-form.button-primary>
                {{ __('Guardar') }}
            </x-form.button-primary>
        </div>
    </form>
</section>
