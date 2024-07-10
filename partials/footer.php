<!-- Bootstrap core JS-->
<script src="assets/jquery/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"></script>
<script src="assets/jquery/jquery-ui.js"></script>
<script src="assets/bootstrap/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
<script src="assets/sweetalert/sweetalert2.all.min.js"></script>
<script src="assets/picker/picker.min.js"></script>
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });

    var Toaster = (icon, title) => {
        Toast.fire({
            icon: icon,
            title: title
        });
    }
</script>