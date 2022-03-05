@extends("template.main")

@section("container")
   <!-- Content Wrapper. Contains page content -->
   <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>History {{$date}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item"><a href="/attendance">Attendance</a></li>
              <li class="breadcrumb-item"><a href="/attendance/history">History</a></li>
              <li class="breadcrumb-item active">{{$date}}</li>
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
                    <th>User Name</th>
                    <th>Region Name</th>
                    <th>Date Event</th>
                    <th>Status Attendance</th>
                    <th>Data Status</th>
                  </tr>
                  </thead>
                  <tbody>
                      @foreach($attendances as $attendance)  
                        <tr>
                            <td>{{$attendance['user']['full_name']}}</td>
                            <td>{{$attendance['schedule_all']['region']['name']}}</td>
                            <td>{{$attendance['schedule_all']['date_event']}} 
                                {{date("H:i", strtotime($attendance['schedule_all']['event_begin']))}} - {{date("H:i", strtotime($attendance['schedule_all']['event_end']))}} 
                            </td> 
                            <td class="text-center">
                                @if($attendance['isAttendance'] == 1)
                                    <span class="badge badge-success">Attend</span>
                                @else
                                    <span class="badge badge-warning">Not Attend</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($attendance['deleted_at'])
                                    <span class="badge badge-success">Not Deleted</span>
                                @else
                                    <span class="badge badge-danger">Deleted</span>
                                @endif
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