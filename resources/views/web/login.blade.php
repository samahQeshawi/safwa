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

              <h2 class="text-orange text-uppercase">{{ __('web.welcome') }}</h2>

              <h5 class="text-uppercase mt-3">{{ __('web.login') }}</h5>

              <form action="profile" class="mt-4">

                <label for="mobile-number">{{ __('web.mobile') }}</label>

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

                  <label for="login-password">{{ __('web.password') }}</label>

                  <input type="password" class="form-control" id="login-password" placeholder="">

                </div>

                <div class="row">

                  <div class="col text-right">

                    <p><b><u>
                      <a href="forgot_password" class="text-dark">{{ __('web.forgot_password') }}</a>
                    </u></b></p>

                  </div>

                </div>

                <div class="row mt-3">

                  <div class="col text-right">

                    <button class="btn banner-btn btn-block">{{ __('web.login') }}</button>

                  </div>

                </div>

                <div class="row mt-4">

                  <div class="col text-center">

                    <p><b>{{ __('web.dont_have_account') }}<span class="text-uppercase"><b><u>
                    <a href="sign_up" class="text-uppercase text-dark">{{ __('web.sign_up') }}</a></u></b></span></b></p>

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
