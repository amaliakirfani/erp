
<script src="/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="/assets/js/bootstrap.bundle.min.js"></script>


{{--<script src="/assets/vendors/apexcharts/apexcharts.js"></script>--}}
<script src="/assets/js/pages/dashboard.js"></script>

<script src="/assets/js/main.js"></script>

{{--Plugins--}}
<script src="/assets/plugins/jquery/jquery.min.js"></script>
<script src="/assets/plugins/jquery/jquery.validate.min.js"></script>
<script src="/assets/plugins/sweetalert2/sweetalert2.all.min.js"></script>


<script>
    function InternalServerEror() {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Silahkan Coba Beberapa Saat Lagi',
        })
    }


    function SuccessResponse(message, callback = null) {
        Swal.fire({
            icon: 'success',
            title: 'success',
            text: message,
        }).then((ok) => {
            if (callback != null) {
                return location.href = callback
            }
        })
    }


    function BadResponse(message) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: message,
        })
    }

    function ajaxSetup() {
        return $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    }

    function LoaderSubmit(className = "btn-submit") {
        var html = `<i class='fas fa-spinner fa-pulse'></i> Process`
        $('.' + className).attr('disabled', true)
        $('.' + className).html(html)
        return
    }

    function UnloaderSubmit(className = "btn-submit", text = `Simpan`) {
        $('.' + className).attr('disabled', false)
        var html = text
        $('.' + className).html(html)
    }
</script>
