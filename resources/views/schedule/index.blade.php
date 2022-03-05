@extends("template.main")

@section("container")
   <!-- Content Wrapper. Contains page content -->
   <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Schedules</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">Schedules</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row mb-3">
          <div class="col-12 text-right">
            <form action="/schedule/reset?_method=PUT" class="d-inline" method="POST">
              @csrf
              <button class="btn btn-warning text-light" onclick="confirm('Are you sure?')">Reset</button>
            </form>
            <form action="/schedule/reset?_method=DELETE" method="POST" class="d-inline">
              @csrf
              <button class="btn btn-danger text-light">Delete Schedule</button>
            </form>
          </div>
        </div>
        <div class="row">
          <div class="col-12"> 

            <div class="card"> 
              <!-- /.card-header -->
              <div class="card-body">
                <table id="schedule-table" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nama Cabang</th>
                    <th>Jumlah Pendaftar</th>
                    <th>Tanggal Acara</th>
                    <th>Jam</th> 
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                      @foreach($schedules as $schedule)  
                        <tr>
                            <td>{{$schedule['region']['name']}}</td>
                            <td>{{$schedule['current_people']}} / {{$schedule['max_people']}}</td>
                            <td>{{$schedule['date_event']}}</td>
                            <td>{{date("H:i",strtotime($schedule['event_begin']))}} - {{date("H:i",strtotime($schedule['event_end']))}}</td>
                            <td class="text-center"> <a href="/schedule/{{ $schedule['id'] }}/u" class="btn btn-warning"><i class="fas fa-edit text-white"></i></a>
                            <form action="/schedule/{{$schedule['id']}}/d?_method=DELETE" method="post" class="d-inline">
                              @csrf
                              <button class="btn btn-danger"><i class="fas fa-trash text-white"></i></button>
                            </form>
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