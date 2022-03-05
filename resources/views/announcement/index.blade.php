@extends("template.main")

@section("container")
   <!-- Content Wrapper. Contains page content -->
   <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Announcement</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">Announcement</li>
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
                    <th>Nama Cabang</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Body</th>
                    <th>Banner Image</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                      @foreach($announcements as $announcement)  
                        <tr>
                            <td>{{$announcement['region']['name']}}</td>
                            <td>{{$announcement['title']}}</td>
                            <td>{{$announcement['description']}}</td>
                            <td>
                              <div class="mid-height">
                                {{$announcement['body']}}
                              </div>
                            </td>
                            <td><img class="rounded thumbnails-image" src="{{$announcement['image_path']}}" alt="{{$announcement['title']}}"></td>
                            <td class="text-center"> <a href="/announcement/{{ $announcement['id'] }}/u" class="btn btn-warning"><i class="fas fa-edit text-white"></i></a>
                            <form action="/announcement/{{$announcement['id']}}/d?_method=DELETE" method="post" class="d-inline">
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