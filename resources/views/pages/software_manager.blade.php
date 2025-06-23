 @extends('layouts.app')
 @section('content')
 <div class="container-fluid">
     <div class="row">
         <div class="col-12">
             <div class="page-title-box d-flex align-items-center justify-content-between">
                 <h4 class="mb-0 font-size-18">Quản lý phần mềm</h4>
             </div>
         </div>
     </div>
     <div class="row">
         <?php for ($i = 0; $i < 12; $i++) { ?>
             <div class="col-12 col-sm-6 col-lg-4 mb-4">
                 <!-- Card here -->
                 <div class="card">
                     <div class="card-body">
                         <div class="media">
                             <div class="avatar-md mr-4">
                                 <span class="avatar-title rounded-circle bg-light text-danger font-size-16">
                                     <img src="images\img-1.jpg" alt="" height="30">
                                 </span>
                             </div>
                             <div class="media-body overflow-hidden">
                                 <h5 class="text-truncate font-size-15"><a href="software_detail" class="text-dark">Tool</a></h5>
                                 <p class="text-muted mb-4">It will be as simple as Occidental</p>
                                 <div class="team">
                                     <a href="javascript: void(0);" class="team-member d-inline-block" data-toggle="tooltip" data-placement="top" title="" data-original-title="Daniel Canales">
                                         <img src="images\avatar-1.jpg" class="rounded-circle avatar-xs m-1" alt="">
                                     </a>
                                     <a href="javascript: void(0);" class="team-member d-inline-block" data-toggle="tooltip" data-placement="top" title="" data-original-title="Jennifer Walker">
                                         <img src="images\avatar-1.jpg" class="rounded-circle avatar-xs m-1" alt="">
                                     </a>
                                 </div>
                             </div>
                         </div>
                     </div>
                     <div class="px-4 py-3 border-top flex flex-row justify-content-between">
                         <ul class="list-inline mb-0">
                             <li class="list-inline-item mr-3">
                                 <span class="badge badge-primary">4.1.1</span>
                             </li>
                             <li class="list-inline-item mr-3" data-toggle="tooltip" data-placement="top" title="" data-original-title="Due Date">
                                 <i class="bx bx-calendar mr-1"></i> 15 Oct, 19
                             </li>
                             <li class="list-inline-item mr-3" data-toggle="tooltip" data-placement="top" title="" data-original-title="Comments">
                                 </i> 214
                             </li>
                         </ul>
                         <ul class="list-inline mb-0 ">

                             <li class="list-inline-item mr-3">
                                 <a href="#" class="text-muted"><i class="bx bx-link-external"></i> Link</a>
                             </li>
                             <li class="list-inline-item mr-3">
                                 <a href="#" class="text-muted"><i class="bx bx-file"></i> File</a>
                             </li>
                         </ul>
                     </div>
                 </div>
             </div>
         <?php } ?>
     </div>


     <div class="row">
         <div class="col-lg-12">
             <ul class="pagination pagination-rounded justify-content-center mt-2 mb-5">
                 <li class="page-item disabled">
                     <a href="#" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                 </li>
                 <li class="page-item">
                     <a href="#" class="page-link">1</a>
                 </li>
                 <li class="page-item active">
                     <a href="#" class="page-link">2</a>
                 </li>
                 <li class="page-item">
                     <a href="#" class="page-link">3</a>
                 </li>
                 <li class="page-item">
                     <a href="#" class="page-link">4</a>
                 </li>
                 <li class="page-item">
                     <a href="#" class="page-link">5</a>
                 </li>
                 <li class="page-item">
                     <a href="#" class="page-link"><i class="mdi mdi-chevron-right"></i></a>
                 </li>
             </ul>
         </div>
     </div>
 </div>



 </div>
 @endsection