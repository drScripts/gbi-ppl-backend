@extends("template.main")

@section('container')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Schedule</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item"><a href="/schedule">Schedule</a></li>
              <li class="breadcrumb-item active">Edit</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card card-default">
            <form action="/schedule/{{ $schedule['id'] }}?_method=PUT" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date">Date Event</label>
                                <input type="date" class="form-control" id="date" name="date" placeholder="Date Event" value="{{ $schedule['date'] }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">   
                            <div class="form-group">
                                <label for="max_people">Max People</label>
                                <input type="number" class="form-control" id="max_people" name="max_people" value="{{ $schedule['max_people'] }}" placeholder="Max People" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="begin">Event Begin</label>
              
                                <div class="input-group">
                                  <input type="time" id="begin" name="begin" class="form-control float-right" value="{{ $schedule['begin'] }}"  placeholder="Event End - Event Begin" required>
                                </div>
                                <!-- /.input group -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="end">Event End</label>
                                <div class="input-group">
                                  <input type="time" id="end" name="end" class="form-control float-right" value="{{ $schedule['end'] }}" required>
                                </div>
                                <!-- /.input group -->
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>  
                </div>
            </form>
        </div> 
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
  <!-- /.content-wrapper -->
@endsection