<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Función para obtener colores dinámicos según el tema del layout
        const getToastConfig = () => {
            const isDark = document.documentElement.classList.contains('dark');
            return {
                background: isDark ? '#1f2937' : '#ffffff', // gray-800 o blanco
                color: isDark ? '#f3f4f6' : '#1f2937'       // gray-100 o gray-800
            };
        };

        // 2. Definimos el Mixin base para Toasts
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: {
                container: 'z-[99999]' 
            },
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        // 3. Disparo por Sesión (PHP)
        @if(session('success'))
            Toast.fire({ ...getToastConfig(), icon: 'success', title: "{{ session('success') }}" });
        @endif

        @if(session('error'))
            Toast.fire({ ...getToastConfig(), icon: 'error', title: "{{ session('error') }}" });
        @endif

        // 4. Integración con Livewire
        document.addEventListener('livewire:init', () => {
            
            Livewire.on('swal-init', (data) => {
                Toast.fire({
                    ...getToastConfig(), 
                    icon: data[0].icon,
                    title: data[0].title,
                    text: data[0].text
                });
            });

            Livewire.on('swal-confirm', (data) => {
                const isDark = document.documentElement.classList.contains('dark');
                Swal.fire({
                    title: data[0].title,
                    text: data[0].text,
                    icon: data[0].icon,
                    background: isDark ? '#1f2937' : '#ffffff',
                    color: isDark ? '#f3f4f6' : '#1f2937',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#d33',
                    customClass: { container: 'z-[99999]' }
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch(data[0].function, { id: data[0].id });
                    }
                });
            });
        });
    });
</script>