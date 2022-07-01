<script src="{{ asset('support_files/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('support_files/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('support_files/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('support_files/plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('support_files/plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('support_files/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('support_files/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('support_files/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('support_files/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('support_files/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('support_files/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('support_files/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('support_files/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('support_files/js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('support_files/js/demo.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('support_files/js/pages/dashboard.js') }}"></script>


{{-- function for screening --}}
<script>
    
    /* function showSanctionResult(input_name) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });
        var parcentage = '0';
        if(input_name.trim() != ''){
            $.ajax({
                type:'POST',
                url:"{{ route('sanctionScreeCheck') }}",
                data:{
                    input_name:input_name,
                },
                success:function(data){
                    if(data.parcentage > 0){
                        parcentage = data.parcentage;
                    }else{
                        parcentage=0;
                    }

                    console.log("ajaz response =",data)
                    
                    
                }
            });
            return parcentage;

        }else{

            return parcentage;
        }
    
       
    } */


</script>
{{-- function for screening --}}



@stack('scripts')
