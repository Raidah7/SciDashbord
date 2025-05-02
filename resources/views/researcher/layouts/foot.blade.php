<script src="{{asset('admin/libs/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('admin/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('admin/js/sidebarmenu.js')}}"></script>
<script src="{{asset('admin/js/app.min.js')}}"></script>
{{--<script src="{{asset('admin/libs/apexcharts/dist/apexcharts.min.js')}}"></script>--}}
<script src="{{asset('admin/libs/simplebar/dist/simplebar.js')}}"></script>
{{--<script src="{{asset('admin/js/dashboard.js')}}"></script>--}}
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function () {
        $('#datatable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "lengthChange": false,
        });
    });
    function confirmDelete(formId) {
        if (confirm("Are you sure want to delete؟")) {
            document.getElementById(formId).submit();
        }
    }
</script>

@stack('js')
