  @extends('layouts.app')

  <head>
      <meta charset="utf-8">
      <title> </title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta content="Premium Multipurpose Admin & Dashboard Template" name="description">
      <meta content="Themesbrand" name="author">
      <link rel="shortcut icon" href="assets\images\favicon.ico">

  </head>

  @section('content')
  <div>
      <div class="row">
          <div class="col-12">
              <div class="page-title-box d-flex align-items-center justify-content-between">
                  <h4 class="mb-0 font-size-18">quản lý phần cứng</h4>
              </div>
          </div>
      </div>
      <?php for ($i = 0; $i < 3; $i++) {
        ?> <div class="row">
              <div class="col-xl-3 col-sm-6">
                  <div class="card text-center">
                      <div class="card-body">
                          <div class="avatar-sm mx-auto mb-4">
                              <span class="avatar-title rounded-circle bg-soft-primary text-primary font-size-16">
                                  D
                              </span>
                          </div>
                          <h5 class="font-size-15"><a href="#" class="text-dark">Window</a></h5>
                          <p class="text-muted">UI/UX Designer</p>

                          <div>
                              <a href="#" class="badge badge-primary font-size-11 m-1">Photoshop</a>
                              <a href="#" class="badge badge-primary font-size-11 m-1">illustrator</a>
                          </div>
                      </div>
                      <div class="card-footer bg-transparent border-top">
                          <div class="contact-links d-flex font-size-20">
                              <div class="flex-fill">
                                  <a href="" data-toggle="tooltip" data-placement="top" title="edit"><i class="bx bx-wrench"></i></a>
                              </div>
                              <div class="flex-fill">
                                  <a href="" data-toggle="tooltip" data-placement="top" title="Log"><i class="bx bx-pie-chart-alt"></i></a>
                              </div>
                              <div class="flex-fill">
                                  <a href="/hardware_detail"  title="Detail"><i class="bx bx-user-circle"></i></a>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-xl-3 col-sm-6">
                  <div class="card text-center">
                      <div class="card-body">
                          <div class="avatar-sm mx-auto mb-4">
                              <span class="avatar-title rounded-circle bg-soft-primary text-primary font-size-16">
                                  L
                              </span>
                          </div>
                          <h5 class="font-size-15"><a href="#" class="text-dark">linux</a></h5>
                          <p class="text-muted">Frontend Developer</p>

                          <div>
                              <a href="#" class="badge badge-primary font-size-11 m-1">Html</a>
                              <a href="#" class="badge badge-primary font-size-11 m-1">Css</a>
                              <a href="#" class="badge badge-primary font-size-11 m-1">2 + more</a>
                          </div>
                      </div>
                      <div class="card-footer bg-transparent border-top">
                          <div class="d-flex font-size-20 contact-links">
                              <div class="flex-fill">
                                  <a href="" data-toggle="tooltip" data-placement="top" title="edit"><i class="bx bx-wrench"></i></a>
                              </div>
                              <div class="flex-fill">
                                  <a href="" data-toggle="tooltip" data-placement="top" title="Log"><i class="bx bx-pie-chart-alt"></i></a>
                              </div>
                              <div class="flex-fill">
                                  <a href="hardware_detail"   data-placement="top" title="Detail"><i class="bx bx-user-circle"></i></a>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-xl-3 col-sm-6">
                  <div class="card text-center">
                      <div class="card-body">
                          <div class="avatar-sm mx-auto mb-4">
                              <span class="avatar-title rounded-circle bg-soft-primary text-primary font-size-16">
                                  W
                              </span>
                          </div>
                          <h5 class="font-size-15"><a href="#" class="text-dark">Win</a></h5>
                          <p class="text-muted">Backend Developer</p>

                          <div>
                              <a href="#" class="badge badge-primary font-size-11 m-1">Php</a>
                              <a href="#" class="badge badge-primary font-size-11 m-1">Java</a>
                              <a href="#" class="badge badge-primary font-size-11 m-1">Python</a>
                          </div>
                      </div>
                      <div class="card-footer bg-transparent border-top">
                          <div class="d-flex font-size-20 contact-links">
                              <div class="flex-fill">
                                  <a href="" data-toggle="tooltip" data-placement="top" title="edit"> <i class="bx bx-wrench"></i> </a>
                              </div>
                              <div class="flex-fill">
                                  <a href="" data-toggle="tooltip" data-placement="top" title="Log"><i class="bx bx-pie-chart-alt"></i></a>
                              </div>
                              <div class="flex-fill">
                                  <a href="/hardware_detail" data-toggle="tooltip" data-placement="top" title="Detail"><i class="bx bx-user-circle"></i></a>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-xl-3 col-sm-6">
                  <div class="card text-center">
                      <div class="card-body">
                          <div class="avatar-sm mx-auto mb-4">
                              <span class="avatar-title rounded-circle bg-soft-success text-success font-size-16">
                                  M
                              </span>
                          </div>
                          <h5 class="font-size-15"><a href="#" class="text-dark">U</a></h5>
                          <p class="text-muted">Full Stack Developer</p>

                          <div>
                              <a href="#" class="badge badge-primary font-size-11 m-1">Ruby</a>
                              <a href="#" class="badge badge-primary font-size-11 m-1">Php</a>
                              <a href="#" class="badge badge-primary font-size-11 m-1">2 + more</a>
                          </div>
                      </div>
                      <div class="card-footer bg-transparent border-top">
                          <div class="d-flex font-size-20 contact-links">
                              <div class="flex-fill">
                                  <a href="" data-toggle="tooltip" data-placement="top" title="Message"><i class="bx bx-wrench"></i></a>
                              </div>
                              <div class="flex-fill">
                                  <a href="" data-toggle="tooltip" data-placement="top" title="Projects"><i class="bx bx-pie-chart-alt"></i></a>
                              </div>
                              <div class="flex-fill">
                                  <a href="hardware_detail" data-toggle="tooltip" data-placement="top" title="Detail"><i class="bx bx-user-circle"></i></a>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div> <?php } ?>
      <div class="row">
          <div class="col-12">
              <div class="text-center my-3">
                  <a href="javascript:void(0);" class="text-success"><i class="bx bx-hourglass bx-spin mr-2"></i> Load more </a>
              </div>
          </div>
      </div>
  </div>
  @endsection