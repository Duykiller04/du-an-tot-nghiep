@if (Session::has('success'))
    <script>
        Swal.fire({
            icon: "success",
            title: "Thành công",
            text: "{{ session('success') }}",
            timer: 1500
        });
    </script>
@else
    <script>
        Swal.fire({
            icon: "error",
            title: "Lỗi",
            text: "{{ session('error') }}",
            timer: 1500
        });
    </script>
@endif
