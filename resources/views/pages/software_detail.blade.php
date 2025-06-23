 @extends('layouts.app')
 @section('content')
 <div class="container-fluid">
     <div class="row">
         <div class="col-12">
             <div class="page-title-box d-flex align-items-center justify-content-between">
                 <h4 class="mb-0 font-size-18">chi tiết phần mềm</h4>
             </div>
         </div>
     </div>

     <div class="row">
         <div class="col-lg-8">
             <div class="card">
                 <div class="card-body">
                     <div class="media">
                         <img src="images\software_default.png" alt="" class="avatar-sm mr-4">
                         <div class="media-body overflow-hidden">
                             <h5 class="text-truncate font-size-15">Software Name</h5>
                             <p class="text-muted">Version: 1.1.1</p>
                         </div>
                     </div>
                     <div>
                         <h5 class="font-size-15" style="display: inline;">Ngôn ngữ: </h5> JavaScript
                     </div>
                     <h5 class="font-size-15 mt-2">Mô tả phần mềm :</h5>
                     <p class="text-muted ">To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is. The European languages are members of the same family. Their separate existence is a myth. For science, music, sport, etc,</p>
                     <h5 class="font-size-15 mt-2">Quy chế liên quan :</h5>
                     <div class="text-muted mt-1">
                         <p><i class="mdi mdi-chevron-right text-primary mr-1"></i> To achieve this, it would be necessary</p>
                         <p><i class="mdi mdi-chevron-right text-primary mr-1"></i> Separate existence is a myth.</p>
                         <p><i class="mdi mdi-chevron-right text-primary mr-1"></i> If several languages coalesce</p>
                     </div>
                     <div class="row task-dates">
                         <div class="col-sm-4 col-6">
                             <div class="mt-4">
                                 <h5 class="font-size-14"><i class="bx bx-calendar mr-1 text-primary"></i> Ngày tạo</h5>
                                 <p class="text-muted mb-0">08 Sept, 2019</p>
                             </div>
                         </div>

                         <div class="col-sm-4 col-6">
                             <div class="mt-4">
                                 <h5 class="font-size-14"><i class="bx bx-calendar-check mr-1 text-primary"></i> ngày cập nhật</h5>
                                 <p class="text-muted mb-0">12 Oct, 2025</p>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
         <div class="col-lg-4">
             <div class="card">
                 <div class="card-body">
                     <div class="flex flex-row justify-content-between align-items-center">
                         <h4 class="card-title mb-4">Danh sách người dùng trong nhóm</h4>

                         <p class="  text-primary ">
                             Thêm mới
                             <i class="bx bx-plus-medical text-lg"></i>
                         </p>
                     </div>
                     <div class="table-responsive">
                         <table class="table table-centered table-nowrap">
                             <tbody>
                                 <?php for ($i = 0; $i < 6; $i++) { ?>
                                     <tr>
                                         <td style="width: 50px;"><img src="images\avatar-1.jpg" class="rounded-circle avatar-xs" alt=""></td>
                                         <td>
                                             <h5 class="font-size-14 m-0"><a href="" class="text-dark">Daniel Canales</a></h5>
                                         </td>
                                         <td>
                                             <div>
                                                 <a href="#" class="badge badge-primary font-size-11"><?= ($i % 2 == 1) ? "Frontend" : "Backend" ?></a>
                                                 <?= ($i % 2 == 1) ? ' <a href="#" class="badge badge-primary font-size-11">UI</a>' : '' ?>
                                             </div>
                                         </td>
                                     </tr>
                                 <?php } ?>
                             </tbody>
                         </table>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <div class="row">
         <div class="col-lg-4">
             <div class="card">
                 <div class="card-body">
                     <h4 class="card-title mb-4">Overview</h4>

                     <div id="overview-chart" class="apex-charts" dir="ltr"></div>
                 </div>
             </div>
         </div>
         <div class="col-lg-4">
             <div class="card">
                 <div class="card-body">
                     <h4 class="card-title mb-4">Danh sách file của phần mềm</h4>
                     <div class="table-responsive">
                         <table class="table table-nowrap table-centered table-hover mb-0">
                             <tbody>
                                 <tr>
                                     <td style="width: 45px;">
                                         <div class="avatar-sm">
                                             <span class="avatar-title rounded-circle bg-soft-primary text-primary font-size-24">
                                                 <i class="bx bxs-file-doc"></i>
                                             </span>
                                         </div>
                                     </td>
                                     <td>
                                         <h5 class="font-size-14 mb-1"><a href="#" class="text-dark">Skote Landing.Zip</a></h5>
                                         <small>Size : 3.25 MB</small>
                                     </td>
                                     <td>
                                         <div class="text-center">
                                             <a href="#" class="text-dark"><i class="bx bx-download h3 m-0"></i></a>
                                         </div>
                                     </td>
                                 </tr>
                                 <tr>
                                     <td>
                                         <div class="avatar-sm">
                                             <span class="avatar-title rounded-circle bg-soft-primary text-primary font-size-24">
                                                 <i class="bx bxs-file-doc"></i>
                                             </span>
                                         </div>
                                     </td>
                                     <td>
                                         <h5 class="font-size-14 mb-1"><a href="#" class="text-dark">Skote Admin.Zip</a></h5>
                                         <small>Size : 3.15 MB</small>
                                     </td>
                                     <td>
                                         <div class="text-center">
                                             <a href="#" class="text-dark"><i class="bx bx-download h3 m-0"></i></a>
                                         </div>
                                     </td>
                                 </tr>
                                 <tr>
                                     <td>
                                         <div class="avatar-sm">
                                             <span class="avatar-title rounded-circle bg-soft-primary text-primary font-size-24">
                                                 <i class="bx bxs-file-doc"></i>
                                             </span>
                                         </div>
                                     </td>
                                     <td>
                                         <h5 class="font-size-14 mb-1"><a href="#" class="text-dark">Skote Logo.Zip</a></h5>
                                         <small>Size : 2.02 MB</small>
                                     </td>
                                     <td>
                                         <div class="text-center">
                                             <a href="#" class="text-dark"><i class="bx bx-download h3 m-0"></i></a>
                                         </div>
                                     </td>
                                 </tr>
                                 <tr>
                                     <td>
                                         <div class="avatar-sm">
                                             <span class="avatar-title rounded-circle bg-soft-primary text-primary font-size-24">
                                                 <i class="bx bxs-file-doc"></i>
                                             </span>
                                         </div>
                                     </td>
                                     <td>
                                         <h5 class="font-size-14"><a href="#" class="text-dark">Veltrix admin.Zip</a></h5>
                                         <small>Size : 2.25 MB</small>
                                     </td>
                                     <td>
                                         <div class="text-center">
                                             <a href="#" class="text-dark"><i class="bx bx-download h3 m-0"></i></a>
                                         </div>
                                     </td>
                                 </tr>
                             </tbody>
                         </table>
                     </div>
                 </div>
             </div>
         </div>
         <div class="col-lg-4">
             <div class="card">
                 <div class="card-body">
                     <h4 class="card-title mb-4">Lịch sử thay đổi</h4>

                     <div class="media mb-4">
                         <div class="mr-3">
                             <img class="media-object rounded-circle avatar-xs" alt="" src="assets\images\users\avatar-2.jpg">
                         </div>
                         <div class="media-body">
                             <h5 class="font-size-13 mb-1">David Lambert</h5>
                             <p class="text-muted mb-1">
                                 Separate existence is a myth.
                             </p>
                         </div>
                         <div class="ml-3">
                             <a href="" class="text-primary">Reply</a>
                         </div>
                     </div>

                     <div class="media mb-4">
                         <div class="mr-3">
                             <img class="media-object rounded-circle avatar-xs" alt="" src="assets\images\users\avatar-3.jpg">
                         </div>
                         <div class="media-body">
                             <h5 class="font-size-13 mb-1">Steve Foster</h5>
                             <p class="text-muted mb-1">
                                 <a href="" class="text-success">@Henry</a>
                                 To an English person it will like simplified
                             </p>
                         </div>
                         <div class="ml-3">
                             <a href="" class="text-primary">Reply</a>
                         </div>
                     </div>

                     <div class="media mb-4">
                         <div class="avatar-xs mr-3">
                             <span class="avatar-title rounded-circle bg-soft-primary text-primary font-size-16">
                                 S
                             </span>
                         </div>
                         <div class="media-body">
                             <h5 class="font-size-13 mb-1">Steven Carlson</h5>
                             <p class="text-muted mb-1">
                                 Separate existence is a myth.
                             </p>
                         </div>
                         <div class="ml-3">
                             <a href="" class="text-primary">Reply</a>
                         </div>
                     </div>

                     <div class="text-center mt-4 pt-2">
                         <a href="#" class="btn btn-primary btn-sm">View more</a>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 @endsection