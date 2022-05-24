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

              <h2 class="text-orange text-uppercase">verify !</h2>

              <h5 class="text-uppercase mt-3">forgot password</h5>

              <form class="mt-4">

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

                <div class="row mt-5">

                  <div class="col">

                    <p class="text-muted">Please enter register phone number we will send 4 digit number for verfication</p>

                  </div>

                </div>

                <div class="row mt-3">

                  <div class="col text-right">

                    <button class="btn banner-btn btn-block">Send</button>

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
