@extends("template.main")

@section("container")
   <!-- Content Wrapper. Contains page content -->
   <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>History</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item"><a href="/attendance">Attendance</a></li>
              <li class="breadcrumb-item active">History</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12"> 

            <div class="card"> 
              <!-- /.card-header -->
              <div class="card-body">
                <table id="schedule-table" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th class="text-center">Month</th>
                    <th class="text-center">Year</th> 
                    <th class="text-center">Action(s)</th>
                  </tr>
                  </thead>
                  <tbody>
                      @foreach($attendances as $attendance)  
                        <tr>
                            <td class="text-center">{{$attendance['year']}}</td>
                            <td class="text-center">{{$attendance['month']}}</td>
                            <td class="text-center">
                              <a href="/attendance/history/{{ $attendance['year'] }}/{{$attendance['month']}}" class="btn btn-info"><i class="fas fa-search text-white"></i></a>
                            </td>
                        </tr>
                      @endforeach
                  </tbody> 
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection