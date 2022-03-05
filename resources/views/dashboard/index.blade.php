 @extends("template.main")

 @section("container")
 <div class="content-wrapper">
     <!-- Content Header (Page header) -->
     <div class="content-header">
         <div class="container-fluid">
             <div class="row mb-2">
                 <div class="col-sm-6">
                     <h1 class="m-0">Dashboard</h1>
                 </div>
                 <!-- /.col -->
                 <div class="col-sm-6">
                     <ol class="breadcrumb float-sm-right">
                         <li class="breadcrumb-item"> Home </li>
                     </ol>
                 </div>
                 <!-- /.col -->
             </div>
             <!-- /.row -->
         </div>
         <!-- /.container-fluid -->
     </div>
     <!-- /.content-header -->

     <!-- Main content -->
     <section class="content">
         <div class="container-fluid">
             <!-- Small boxes (Stat box) -->
             <div class="row">
                 <div class="col-lg-3 col-6">
                     <!-- small box -->
                     <div class="small-box bg-info">
                         <div class="inner">
                             <h3>{{ $schedules }}</h3>

                             <p>Schedules</p>
                         </div>
                         <div class="icon">
                             <i class="ion ion-android-calendar"></i>
                         </div>
                         <a href="/schedule" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                     </div>
                 </div>
                 <!-- ./col -->
                 <div class="col-lg-3 col-6">
                     <!-- small box -->
                     <div class="small-box bg-warning">
                         <div class="inner">
                             <h3>{{ $users }}</h3>

                             <p>User Registrations</p>
                         </div>
                         <div class="icon">
                             <i class="ion ion-person"></i>
                         </div>
                         <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                     </div>
                 </div>
                 <!-- ./col -->
                 <div class="col-lg-3 col-6">
                     <!-- small box -->
                     <div class="small-box bg-success">
                         <div class="inner">
                             <h3>{{$region}}</h3>

                             <p>Region Count</p>
                         </div>
                         <div class="icon">
                             <i class="ion ion-stats-bars"></i>
                         </div>
                         <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                     </div>
                 </div>
                 <!-- ./col -->
                 <div class="col-lg-3 col-6">
                     <!-- small box -->
                     <div class="small-box bg-danger">
                         <div class="inner"> 
                             <h3>22</h3>
                             <p>Unique Visitors</p>
                         </div>
                         <div class="icon">
                             <i class="ion ion-pie-graph"></i>
                         </div>
                         <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                     </div>
                 </div>
                 <!-- ./col -->
             </div>
             <!-- /.row -->
             <!-- Main row -->
             <div class="row">
                 <!-- Left col -->
                 <section class="col-lg-12 connectedSortable">
                     <!-- Custom tabs (Charts with tabs)-->
                     <div class="card">
                         <div class="card-header">
                             <h3 class="card-title">
                                 <i class="fas fa-chart-pie mr-1"></i>
                                 Attendance
                             </h3> 
                         </div>
                         <!-- /.card-header -->
                         <div class="card-body">
                             <div class="tab-content p-0">
                                 <!-- Morris chart - Sales -->
                                 <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px">
                                     <canvas id="revenue-chart-canvas" height="300" style="height: 300px"></canvas>
                                 </div> 
                             </div>
                         </div>
                         <!-- /.card-body -->
                     </div>
                     <!-- /.card -->
                 </section>
                 <!-- /.Left col -->
             </div>
             <!-- /.row (main row) -->
         </div>
         <!-- /.container-fluid -->
     </section>
     <!-- /.content -->
 </div>

 @endsection