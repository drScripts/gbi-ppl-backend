@extends("template.main")

@section('container')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Region</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item"><a href="/region">Region</a></li>
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
            <form action="/region/{{ $region['id'] }}?_method=PUT" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Region Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Region Name" value="{{ $region['name'] }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">   
                            <div class="form-group">
                                <label for="link">Maps Link</label>
                                <input type="text" class="form-control" id="link" name="maps_link" value="{{ $region['maps_link'] }}" placeholder="Region Maps Link" required>
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