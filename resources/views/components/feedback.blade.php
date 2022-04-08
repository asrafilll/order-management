@props(['type' => 'success', 'message' => ''])

<script>
    $(function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        Toast.fire({
            icon: '{{ $type }}',
            title: '{{ $message }}',
        })
    });
</script>
