{{-- Extends layout --}}
@extends('web._default')

{{-- Content --}}
@section('content')

    <div class="site-inner-wrapper">

        @include('web.layout.base._subheader')


      <div class="site-inner-content our-fleet-inner-content">

        <div class="container">

          <div class="row">

            <div class="col-lg-3">

              <div class="filter-col-left">

                <ul class="list-group mb-3">
                  <h6>Sort By</h6>
                  <li class="list-group-item">Cras justo odio</li>
                  <li class="list-group-item">Dapibus ac facilisis in</li>
                  <li class="list-group-item">Morbi leo risus</li>
                  <li class="list-group-item">Porta ac consectetur ac</li>
                  <li class="list-group-item">Vestibulum at eros</li>
                </ul>

                <ul class="list-group mb-3">
                  <h6>Category</h6>
                  <li class="list-group-item">Cras justo odio</li>
                  <li class="list-group-item">Dapibus ac facilisis in</li>
                  <li class="list-group-item">Morbi leo risus</li>
                  <li class="list-group-item">Porta ac consectetur ac</li>
                  <li class="list-group-item">Vestibulum at eros</li>
                </ul>

              </div>

            </div>

            <div class="col-lg-8 offset-lg-1">

              <div class="filter-col-right">

                <div class="row">

                  <div class="col-lg-5">

                    <img class="img-fluid" src="{{ asset('images/car-img.png') }}">

                  </div>

                  <div class="col-lg-7">

                    <div class="car-name">

                      <h4 class="text-orange">VW Polo 1.6 TDI Comfortline</h4>

                      <p><b><span class="text-black">Start from $ 1 /per a day </span></b></p>

                    </div>

                    <div class="car-spec">

                      <div class="row">

                        <div class="col-6">

                          <p><img src="{{ asset('images/car-type-icon.png') }}" class="img-fluid"> Spec01 </p>

                        </div>

                        <div class="col-6">

                          <p><img src="{{ asset('images/car-fuel-icon.png') }}" class="img-fluid"> Spec01 </p>

                        </div>

                        <div class="col-6">

                          <p><img src="{{ asset('images/car-setting-icon.png') }}" class="img-fluid"> Spec01 </p>

                        </div>

                        <div class="col-6">

                          <p><img src="{{ asset('images/car-km-icon.png') }}" class="img-fluid"> Spec01 </p>

                        </div>

                      </div>
                        <a href="car-details.html">
                      <button class="btn banner-btn btn-primary btn-sm">View Details</button>
                        </a>
                    </div>

                  </div>

                </div>

              </div>

              <div class="filter-col-right">

                <div class="row">

                  <div class="col-lg-5">

                    <img class="img-fluid" src="{{ asset('images/car-img.png') }}">

                  </div>

                  <div class="col-lg-7">

                    <div class="car-name">

                      <h4 class="text-orange">VW Polo 1.6 TDI Comfortline</h4>

                      <p><b><span class="text-black">Start from $ 1 /per a day </span></b></p>

                    </div>

                    <div class="car-spec">

                      <div class="row">

                        <div class="col-6">

                          <p><img src="{{ asset('images/car-km-icon.png') }}" class="img-fluid"> Spec01 </p>

                        </div>

                        <div class="col-6">

                          <p><img src="{{ asset('images/car-km-icon.png') }}" class="img-fluid"> Spec01 </p>

                        </div>

                        <div class="col-6">

                          <p><img src="{{ asset('images/car-km-icon.png') }}" class="img-fluid"> Spec01 </p>

                        </div>

                        <div class="col-6">

                          <p><img src="{{ asset('images/car-km-icon.png') }}" class="img-fluid"> Spec01 </p>

                        </div>

                      </div>
                        <a href="car-details.html">
                      <button class="btn banner-btn btn-primary btn-sm">View Details</button>
                        </a>
                    </div>

                  </div>

                </div>

              </div>

            </div>

          </div>

        </div>

      </div>

    </div>




@endsection

{{-- Scripts Section --}}
@section('scripts')

    <script>

    </script>
@endsection
