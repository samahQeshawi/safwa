{{-- Extends layout --}}
@extends('web._default')

{{-- Content --}}
@section('content')

    <div class="site-inner-wrapper">

        @include('web.layout.base._subheader')


      <div class="site-inner-content jobs-inner-content">

        <div class="container">

          <div class="row">

            <div class="col-12">

              <div class="row d-flex justify-content-between">

                <div class="col-lg-6">

                  <div class="block-03-left">

                    <div class="mt-5">

                      <div class="col-11">

                        <img src="{{ asset('images/contact-img.png') }}" class="img-fluid">

                      </div>

                    </div>

                  </div>

                </div>

                <div class="col-lg-5">

                  <div class="block-03-right">

                    <form class="contact-form">

                        <h4 class="contact-form-title pb-2 mb-2">{{ __('web.get_touch') }}</h4>

                        <div class="form-group">
                          <label for="user-name">{{ __('web.name') }}</label>
                          <input type="text" class="form-control" id="user-name" placeholder="">
                        </div>

                        <div class="form-group">
                          <label for="user-email-address">{{ __('web.email') }}</label>
                          <input type="email" class="form-control" id="user-email-address" placeholder="">
                        </div>

                        <div class="form-group">
                          <label for="user-email-subject">{{ __('web.subject') }}</label>
                          <input type="email" class="form-control" id="user-email-subject" placeholder="">
                        </div>

                        <div class="form-group">
                          <label for="user-email-message">{{ __('web.message') }}</label>
                          <textarea class="form-control" id="user-email-message" rows="3"></textarea>
                        </div>

                        <button type="submit" class="btn yellow-btn btn-sm mt-2">{{ __('web.submit') }}</button>

                    </form>

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
