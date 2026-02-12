<section class="space-y-6 ">
    <header>
        <h2 class="text-lg font-medium text-gray-700 dark:text-gray-400">
            {{ __('Eliminar Cuenta') }}
        </h2>

        <p class="mt-1 text-sm text-gray-800 dark:text-gray-500">
            {{ __('Una vez eliminada su cuenta, todos sus recursos y datos se eliminarán permanentemente. Antes de eliminar su cuenta, descargue cualquier dato o información que desee conservar.') }}
        </p>
    </header>

    <x-form.danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Eliminar Cuenta') }}</x-form.danger-button> 

    <x-form.modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-700 dark:text-gray-400">
                {{ __('¿Estás segura de que quieres eliminar tu cuenta?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-800 dark:text-gray-500">
                {{ __('Una vez eliminada su cuenta, todos sus recursos y datos se eliminarán permanentemente. Ingrese su contraseña para confirmar que desea eliminar su cuenta permanentemente.') }}
            </p>

            <div class="mt-6">
                <x-form.input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <div x-data="{ showPassword: false }" class="relative">
                    <x-form.text-input
                        name="password"
                        id="update_password_password"
                        placeholder="Ingresa la contraseña actual"
                        :value="old('password')"
                        :messages="$errors->updatePassword->get('password')"
                        required 
                        show-password
                    />
                </div>

                <x-form.input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-form.secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancelar') }}
                </x-form.secondary-button>

                <x-form.danger-button class="ms-3">
                    {{ __('Eliminar Cuenta') }}
                </x-form.danger-button>
            </div>
        </form>
    </x-modal>
</section>
