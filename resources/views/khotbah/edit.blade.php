@extends("template.main")

@section('container')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Khotbah</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item"><a href="/khotbah">Khotbah</a></li>
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
            <form action="/khotbah/{{ $khotbah['id'] }}?_method=PUT" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Khotbah Title" value="{{ $khotbah['title'] }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">   
                            <div class="form-group">
                                <label for="pembawa">Pembawa Khotbah</label>
                                <input type="text" class="form-control" id="pembawa" name="pembawa" value="{{ $khotbah['pembawa'] }}" placeholder="Pembawa Khotbah" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                              <label for="date">Khotbah Date</label>
                              <div class="input-group">
                                <input type="date" id="date" name="date" class="form-control float-right" value="{{ $khotbah['khotbah_date'] }}" required>
                              </div>
                              <!-- /.input group -->
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                              <label for="bahan">Bahan Khotbah</label>
                              <div class="input-group">
                                <input type="text" id="bahan" name="bahan" class="form-control float-right" value="{{ $khotbah['bahan'] }}" required>
                              </div>
                              <!-- /.input group -->
                          </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="khotbah">Isi Khotbah</label>
              
                                <div class="input-group">
                                  <textarea type="time" id="khotbah" name="khotbah" class="form-control float-right" placeholder="Isi Khotbah" rows="15" required>{{ $khotbah['khotbah'] }}</textarea>
                                </div>
                                <!-- /.input group -->
                            </div>
                        </div>
                        <div class="col-12">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="banner">Banner</label>
                                <label for='banner' id="card-banner-upload" class="card bg-secondary p-5 d-flex justify-content-center align-items-center" style="background-image: url('{{ $khotbah['image_path'] }}');background-size:cover;background-repeat:no-repeat;">
                                  <input type="file" accept="image/*" hidden id="banner" name="banner">
                                  <i class="fas fa-cloud-upload-alt fa-10x mx-5"></i>
                                </label>
                              </div>
                            </div>
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