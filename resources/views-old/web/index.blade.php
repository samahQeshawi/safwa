{{-- Extends layout --}}
@extends('web._default')

@section('content')

    <div class="site-banner-wrapper">

      <div class="container">

        <div class="row">

          <div class="col-lg-12">

            <div class="home-search-wrapper">

              <ul class="nav nav-pills">
                <li class="nav-item">
                  <a href="#tab1" class="nav-link navbar-default active" data-toggle="tab">Rental Cars</a>
                </li>
                <li class="nav-item">
                  <a href="#tab2" class="nav-link navbar-default" data-toggle="tab">Airport Taxi</a>
                </li>
              </ul>

              <div class="tab-content">

                <div id="tab1" class="tab-pane active tab-box">

                  <form action="search-result.html">
                    <div class="row mt-5 mb-4">
                      <div class="col-lg-4">
                        <i class="fas fa-map-marker-alt f-icon"></i>
                        <input type="text" class="form-control" placeholder="Pickup Location">
                      </div>
                      <div class="col">
                        <i class="far fa-calendar-alt f-icon"></i>
                        <input value=""placeholder="Pickup Date" class="textbox-n form-control" type="text" onfocus="(this.type='date')" id="date">

                      </div>
                      <div class="col">
                        <i class="far fa-clock f-icon"></i>
                        <input type="text" class="form-control timepicker" placeholder="Pickup Time" id="timepicker"/>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-4">
                        <i class="fas fa-map-marker-alt f-icon"></i>
                        <input type="text" class="form-control" placeholder="Dropoff Location">
                      </div>
                      <div class="col">
                        <i class="far fa-calendar-alt f-icon"></i>
                        <input value=""placeholder="Dropoff Date" class="textbox-n form-control" type="text" onfocus="(this.type='date')" id="date">

                      </div>
                      <div class="col">
                        <i class="far fa-clock f-icon"></i>
                        <input type="text" class="form-control timepicker" placeholder="Dropoff Time" id="timepicker"/>
                      </div>
                    </div>
                    <div class="row text-right">
                      <div class="col-12">
                        <a href="search-result.html"><button class="btn banner-btn mt-4">search car</button></a>
                      </div>
                    </div>
                  </form>

                </div>

                <div id="tab2" class="tab-pane tab-box">

                  <form action="search-result.html">
                    <div class="row mt-5 mb-4">
                      <div class="col-lg-4">
                        <i class="fas fa-map-marker-alt f-icon"></i>
                        <input type="text" class="form-control" placeholder="Airport Location">
                      </div>
                      <div class="col-lg-1">
                        <a href="#">
                          <svg width="18" height="16" class="reverse-arrow" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 4H1" stroke="#FFA100" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16 7L19 4L16 1" stroke="#FFA100" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M4 17L1 14L4 11" stroke="#FFA100" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M1 14H19" stroke="#FFA100" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                          </svg>
                        </a>
                      </div>
                      <div class="col-lg-4">
                        <i class="fas fa-building f-icon"></i>
                        <input type="text" class="form-control" placeholder="Hotel Name">
                      </div>
                      <div class="col">
                        <i class="far fa-calendar-alt f-icon"></i>
                        <input value=""placeholder="Flight Arrival Date" class="textbox-n form-control" type="text" onfocus="(this.type='date')" id="date">

                      </div>
                      <div class="col">
                        <i class="far fa-clock f-icon"></i>
                        <input type="text" class="form-control timepicker" placeholder="Flight Arrival Time" id="timepicker"/>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-3">
                        <div class="form-check mb-3">
                          <input type="checkbox" class="form-check-input" id="book-round-trip">
                          <label class="form-check-label" for="book-round-trip">Book Roundtrip</label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-3">
                        <i class="far fa-calendar-alt f-icon"></i>
                        <input value=""placeholder="Flight Arrival Date" class="textbox-n form-control" type="text" onfocus="(this.type='date')" id="date">

                      </div>
                      <div class="col-lg-3">
                        <i class="far fa-clock f-icon"></i>
                        <input type="text" class="form-control timepicker" placeholder="Flight Arrival Time" id="timepicker"/>
                      </div>
                    </div>
                    <div class="row text-right">
                      <div class="col-12">
                        <button class="btn banner-btn mt-4">search car</button>
                      </div>
                    </div>
                  </form>


                </div>

              </div>

            </div>

        </div>

      </div>

    </div> <!-- Site Banner DIV Code Ends ---->


    <div class="site-block-02-wrapper">

      <div class="col-lg-12 text-center">

        <h4 id="welcome" class="yellow-title pt-5">Welcome</h4>

        <h1 class="black-title">Our Services</h1>

      </div>

      <div class="block-02-inner-wrapper main">

         <!-- Slider -->

      <div class="page_container">
        <div id="immersive_slider">
          <div class="slide">
            <div class="content">
              <h2><a class="yellow-title" href="">Airport Service</a></h2>
              <p>Nam ac ligula congue, interdum enim sit amet, fermentum nisi,Nam ac ligula congue, interdum enim sit amet, fermentum nisi.Nam ac ligula congue.interdum enim sit amet, fermentum nisi,Nam ac ligula congue, interdum enim sit amet, fermentum nisi.Nam ac ligula congue.</p>
            </div>
            <div class="image">
              <a href="http://www.bucketlistly.com" target="_blank">
                <img src="{{ asset('images/slide1.jpg') }}" alt="Slider 1">
              </a>
            </div>
          </div>
          <div class="slide">
            <div class="content">
              <h2><a class="yellow-title" href="">Taxi Services</a></h2>
              <p>Nam ac ligula congue, interdum enim sit amet, fermentum nisi,Nam ac ligula congue, interdum enim sit amet, fermentum nisi.Nam ac ligula congue.interdum enim sit amet, fermentum nisi,Nam ac ligula congue, interdum enim sit amet, fermentum nisi.Nam ac ligula congue.</p>
            </div>
            <div class="image">
             <a href="http://www.bucketlistly.com/apps" target="_blank"> <img src="{{ asset('images/slide2.jpg') }}" alt="Slider 1"></a>
            </div>
          </div>
          <div class="slide">
            <div class="content">
              <h2><a class="yellow-title" href="">Rent Car Services</a></h2>
              <p>Nam ac ligula congue, interdum enim sit amet, fermentum nisi,Nam ac ligula congue, interdum enim sit amet, fermentum nisi.Nam ac ligula congue.interdum enim sit amet, fermentum nisi,Nam ac ligula congue, interdum enim sit amet, fermentum nisi.Nam ac ligula congue.</p>
            </div>
            <div class="image">
              <a href="http://www.thepetedesign.com" target="_blank"><img src="{{ asset('images/slide3.jpg') }}" alt="Slider 1"></a>
            </div>
          </div>

          <a href="#" class="is-prev">

              <i class="fas fa-chevron-left"></i>

          </a>
          <a href="#" class="is-next">

            <i class="fas fa-chevron-right"></i>

          </a>
        </div>
      </div>


        <!-- Slider ends -->


      </div>
    </div> <!-- Site Block-02-Wrapper DIV Closed -->

    <div class="site-block-06-wrapper">

      <div class="col-lg-12 text-center">

        <h4 id="welcome" class="yellow-title pt-5">App feature</h4>

        <h1 class="black-title">Download the app</h1>

      </div>

      <div class="block-06-inner-wrapper">

        <div class="container">

          <div class="row">

            <div class="col">

              <h4 class="black-title">Book an <span class="yellow-title bg-dark pl-1 pr-1">safwa</span> from the App</h4>

              <h6 class="pt-3">Download the app for exclusive deals and ease of booking </h6>

              <div class="store-blk">

                <a href="">

                  <img class="img-fluid pt-4 pr-4" src="{{ asset('images/appstore.png') }}">

                </a>

                <a href="">

                  <img class="img-fluid pt-4 pr-4" src="{{ asset('images/playstore.png') }}">

                </a>

              </div>

            </div>

            <div class="col-4">

              <img class="img-fluid app-feature-phone d-sm-none d-md-block d-none d-sm-block" src="{{ asset('images/ios-mob-img.png') }}" width="200">

            </div>

          </div>

        </div>

      </div>

    </div><!-- Site Block-06-Wrapper DIV Closed -->


    <div class="site-block-04-wrapper">

      <div class="col-12 text-center">

        <h4 id="app-feature" class="black-title pt-3">About Us</h4>

        <h1 class="yellow-title">Why Choose us</h1>

      </div>

      <div class="block-04-inner-wrapper">

        <div class="container">

          <div class="row">

            <div class="col-lg-7">

              <ul class="about-us-ul">

                <li><h5><i class="fab fa-bandcamp"> </i> Gas & insurance included</h5></li>

                <li><h5><i class="fab fa-bandcamp"> </i> Any Locations Rent</h5></li>

                <li><h5><i class="fab fa-bandcamp"> </i> Cleaning Included</h5></li>

                <li><h5><i class="fab fa-bandcamp"> </i> Online 24 / 7 Support</h5></li>

              </ul>

              <button class="btn banner-btn mt-3">search car</button>

            </div>

            <div class="col-lg-5 text-center">

              <img class="img-fluid about-us-img" src="{{ asset('images/about-us-img.jpg') }}">

              <h5 class="custom-position">Take only memories,<br/>leave only footprints</h5>

            </div>

          </div>

        </div>

      </div>

    </div> <!-- Site Block-04-Wrapper DIV Closed -->


    <div class="site-block-05-wrapper">

      <div class="block-05-inner-wrapper">

        <div class="container">

          <div class="row">

            <div class="col-12">

              <h4 class="yellow-title">For Drivers</h4>

              <h2 class="black-title">Do You Want To Earn With Us?</h2>

            </div>

            <div class="col-lg-5">

              <p class="mt-4">Nam ac ligula congue, interdum enim sit amet, fermentum nisi,Nam ac ligula congue, interdum enim sit amet, fermentum nisi.Nam ac ligula congue.interdum enim sit amet, fermentum nisi,Nam ac ligula congue, interdum enim sit amet, fermentum nisi.Nam ac ligula congue.</p>

              <button class="btn yellow-btn">become a driver</button>

            </div>

            <div class="col-lg-7 text-center">

              <img class="img-fluid" src="{{ asset('images/yellow-car-side-img.png') }}">

            </div>

          </div>

        </div>

      </div>

    </div> <!-- Site Block-05-Wrapper DIV Closed -->


@endsection

