@extends("template.main")

@section("container")
   <!-- Content Wrapper. Contains page content -->
   <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Regions</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">Regions</li>
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
                    <th>Name</th>
                    <th>Unique Code</th>
                    <th>Maps Link</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                      @foreach($regions as $region)  
                        <tr>
                            <td>{{$region['name']}}</td>
                            <td>{{$region['unique_code']}}</td>
                            <td>
                              <div >
                                <a href="{{$region['maps_link']}}">{{$region['name']}}</a>
                              </div>
                            </td> 
                            <td class="text-center"> <a href="/region/{{ $region['id'] }}/u" class="btn btn-warning"><i class="fas fa-edit text-white"></i></a>
                            <form action="/region/{{$region['id']}}/d?_method=DELETE" method="post" class="d-inline">
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