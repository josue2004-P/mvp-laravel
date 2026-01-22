<section>
    <header>
        <h2 class="text-lg font-medium text-gray-700 dark:text-gray-400">
            {{ __('Actualizar contraseña') }}
        </h2>

        <p class="mt-1 text-sm text-gray-800 dark:text-gray-500">
            {{ __('Asegúrese de que su cuenta utilice una contraseña larga y aleatoria para mantener su seguridad.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-form.input-label for="update_password_current_password" :value="__('Contraseña actual')" />
            <div x-data="{ showPassword: false }" class="relative">
                <x-form.text-input
                    name="current_password"
                    id="password"
                    placeholder="Ingresa contraseña actual"
                    :value="old('current_password')"
                    :messages="$errors->updatePassword->get('current_password')"
                    required 
                    show-password
                />
            </div>
            <x-form.input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div> 

        <div>
            <x-form.input-label for="update_password_password" :value="__('Nueva Contraseña')" />
            <div x-data="{ showPassword: false }" class="relative">
                <x-form.text-input
                    name="password"
                    id="update_password_password"
                    placeholder="Ingresa la nueva contraseña"
                    :value="old('password')"
                    :messages="$errors->updatePassword->get('password')"
                    required 
                    show-password
                />
            </div>
            <x-form.input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div> 

        <div>
            <x-form.input-label for="update_password_password_confirmation" :value="__('Confirmar Contraseña')" />
            <div x-data="{ showPassword: false }" class="relative">
                <x-form.text-input
                    name="password_confirmation"
                    id="update_password_password_confirmation"
                    placeholder="Confirma la nueva contraseña"
                    :value="old('password')"
                    :messages="$errors->updatePassword->get('password_confirmation')"
                    required 
                    show-password
                />
            </div>
            <x-form.input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div> 

        <div class="flex items-center gap-4">
            <x-form.button-primary>
                {{ __('Save') }}
            </x-form.button-primary>
        </div>
    </form>
</section>
