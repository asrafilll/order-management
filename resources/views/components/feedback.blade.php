@props(['type' => 'success', 'message' => ''])

<script>
    $(function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 5000
        });

        Toast.fire({
            icon: '{{ $type }}',
            title: '{{ $message }}',
        })
    });
</script>
