@extends("template.main")

@section("container")
   <!-- Content Wrapper. Contains page content -->
   <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Khotbah</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">Khotbah</li>
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
                    <th>Image</th>
                    <th>title</th>
                    <th>Pembawa</th>
                    <th>Isi Khotbah</th>
                    <th>Tanggal</th> 
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                      @foreach($khotbahs as $khotbah)  
                        <tr><td><img class="rounded mid-thumbnails-image" src="{{$khotbah['image_path']}}" alt="{{$khotbah['title']}}"></td>
                            <td>{{$khotbah['title']}}</td>
                            <td>{{$khotbah['pembawa']}}</td>
                            <td>
                              <div class="mid-height">
                                {{$khotbah['khotbah']}}
                              </div>
                            </td>
                            <td>{{$khotbah['khotbah_date']}}</td>
                            <td class="text-center"> <a href="/khotbah/{{ $khotbah['id'] }}/u" class="btn btn-warning"><i class="fas fa-edit text-white"></i></a>
                            <form action="/khotbah/{{$khotbah['id']}}/d?_method=DELETE" method="post" class="d-inline">
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