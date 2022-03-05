<!-- jQuery -->
<script src="/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>

<!-- Bootstrap 4 -->
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="/plugins/sparklines/sparkline.js"></script>
<!-- jQuery Knob Chart -->
<script src="/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="/plugins/moment/moment.min.js"></script>
<script src="/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="/dist/js/adminlte.js"></script>
<!-- DataTables  & Plugins -->
<script src="/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="/plugins/jszip/jszip.min.js"></script>
<script src="/plugins/pdfmake/pdfmake.min.js"></script>
<script src="/plugins/pdfmake/vfs_fonts.js"></script>
<script src="/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- Toastr -->
<script src="/plugins/toastr/toastr.min.js"></script>

<!-- costume js -->
<script src="/project/js/schedule.js"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="/dist/js/pages/dashboard.js"></script>
@if (session('success_form'))  
    <script>
        var message = {!! json_encode(session('success_form')) !!}
        toastr.success(message,'Success!');
    </script>
@endif
@if (session('warning_form'))  
    <script>
        var message = {!! json_encode(session('warning_form')) !!}
        toastr.warning(message,'Warning!');
    </script>
@endif

@if( $_SERVER['REQUEST_URI'] == "/")

<script>
     
    // Sales chart
    var salesChartCanvas = document
        .getElementById("revenue-chart-canvas")
        .getContext("2d");
        

        var salesGraphChartData = {
            labels: {!! json_encode($month) !!},
            datasets: [
            {
                label: 'Total Attendance', 
                borderWidth: 2,
                lineTension: 0,
                spanGaps: true, 
                pointRadius: 3,
                pointHoverRadius: 7, 
                pointBackgroundColor: '#efefef',
                backgroundColor: "rgba(60,141,188,0.9)",
                borderColor: "rgba(60,141,188,0.8)", 
                pointColor: "#3b8bba",
                pointStrokeColor: "rgba(60,141,188,1)",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(60,141,188,1)",
                data: {!! json_encode($data) !!}
            }
            ]
        }

        var salesGraphChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
            display: false
            },
            scales: {
            xAxes: [{
                ticks: {
                fontColor: '#efefef'
                },
                gridLines: {
                display: false,
                color: '#efefef',
                drawBorder: false
                }
            }],
            yAxes: [{
                ticks: {
                stepSize: 5000,
                fontColor: '#efefef'
                },
                gridLines: {
                display: true,
                color: '#efefef',
                drawBorder: false
                }
            }]
            }
        }

  // This will get the first returned node in the jQuery collection.
  // eslint-disable-next-line no-unused-vars
  var salesGraphChart = new Chart(salesChartCanvas, { // lgtm[js/unused-local-variable]
    type: 'line',
    data: salesGraphChartData,
    options: salesGraphChartOptions
  });
 </script>
@endif

</body>

</html>