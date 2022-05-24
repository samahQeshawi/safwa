@extends('web._portal')

@section('content')

    <div class="login-wrapper">

      <div class="container">

        <div class="row">

          <div class="col-lg-12 text-center">
            <a href="/" >
            <div class="login-site-logo">

              <img src="{{ asset('images/logo.png') }}" class="img-fluid">

            </div>
            </a>
          </div>

        </div>

        <div class="row mt-5 justify-content-center">

          <div class="col-lg-5">

            <div class="login-form-wrapper">

              <h2 class="text-orange text-uppercase">Hey !</h2>

              <h5 class="text-uppercase mt-3">Sign Up</h5>

              <form action="car-payment.html" class="mt-4">

                <div class="form-group mt-4 border-bottom">

                  <label for="sign-up-name">Name</label>

                  <input type="name" class="form-control" id="sign-up-name" placeholder="">

                </div>

                <div class="form-group mt-4 border-bottom">

                  <label for="sign-up-email">Email Address</label>

                  <input type="email" class="form-control" id="sign-up-email" placeholder="">

                </div>

                <label for="mobile-number">Mobile Number</label>

                <div class="form-row border-bottom no-margin">
                  <div class="col-md-3 no-padding">
                    <select id="country-code" class="form-control">
                      <option selected>SA +966</option>
                      <option>UAE +971</option>
                    </select>
                  </div>
                  <div class="col-md-9 no-padding">
                    <input type="text" class="form-control" id="mobile-number">
                  </div>
                </div>

                <div class="form-group mt-4 border-bottom">

                  <label for="login-password">Password</label>

                  <input type="password" class="form-control" id="login-password" placeholder="">

                </div>


                <div class="row mt-4 mb-4">

                  <div class="col-lg-12">

                    <div class="form-check">
                      <label class="form-check-label" for="filter-checkbox">I agreed <a href="terms">terms</a> and <a href="conditions">conditions</a></label>
                      <input type="checkbox" class="form-check-input" id="filter-checkbox">
                    </div>

                  </div>

                </div>

                <div class="row mt-3">

                  <div class="col text-right">

                    <button class="btn banner-btn btn-block">Login</button>

                  </div>

                </div>

                <div class="row mt-4">

                  <div class="col text-center">

                    <p><b>Have an account already? <span></span><b><u><a  class="text-uppercase text-dark" href="customers_portal">Login</a></u></b></span></b></p>

                  </div>

                </div>

              </form>

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
