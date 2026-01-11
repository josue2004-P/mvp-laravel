<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            Swal.fire({ icon: 'success', title: 'Éxito', text: "{{ session('success') }}" });
        @endif

        @if(session('error'))
            Swal.fire({ icon: 'error', title: 'Error', text: "{{ session('error') }}" });
        @endif
    });

    document.addEventListener('livewire:init', () => {
        // Alerta de confirmación
        Livewire.on('swal-confirm', (data) => {
            Swal.fire({
                title: data[0].title,
                text: data[0].text,
                icon: data[0].icon,
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#d33',
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch(data[0].function, { id: data[0].id });
                }
            });
        });
        // Alerta simple
        Livewire.on('swal-init', (data) => {
            Swal.fire({
                icon: data[0].icon,
                title: data[0].title,
                text: data[0].text,
                confirmButtonText: 'Aceptar'
            });
        });
    });
</script>