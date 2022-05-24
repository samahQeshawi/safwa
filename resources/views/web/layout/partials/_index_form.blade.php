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

                  <form name="rental_car_form" action="search-result.html">
                    <div class="row mt-5 mb-4">
                      <div class="col-lg-4">
                        <i class="fas fa-map-marker-alt f-icon"></i>
                        <input type="text" class="form-control get_location" placeholder="Pickup Location" id="pick_location" readonly>
                        <div id="pick_location_embedMap" class="embedMap">
                        <!--Google map will be embedded here-->
                        </div>

                      </div>

                      <div class="col">
                        <i class="far fa-calendar-alt f-icon"></i>
                        <input value="" placeholder="Pickup Date" class="textbox-n form-control" type="text" onfocus="(this.type='date')" id="date">

                      </div>
                      <div class="col">
                        <i class="far fa-clock f-icon"></i>
                        <input type="text" class="form-control timepicker" placeholder="Pickup Time" id="timepicker"/>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-4">
                        <i class="fas fa-map-marker-alt f-icon"></i>
                        <input type="text" class="form-control get_location" placeholder="Dropoff Location" id="drop_location" data-filter="{{route('pick_location')}}?q=#QUERY#">
                        <div id="drop_location_embedMap" class="embedMap">
                        <!--Google map will be embedded here-->
                        </div>
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
                    <div class="row">
                      <div class="col-lg-3">
                        <div class="form-check mb-3">
                          <input type="checkbox" class="form-check-input" id="delivery_to_customer">
                          <label class="form-check-label" for="delivery_to_customer">Delivery to customer</label>
                        </div>
                      </div>

                      <div class="col-9  text-right">
                        <a href="search-result.html"><button class="btn banner-btn mt-4">search car</button></a>
                      </div>
                    </div>
                  </form>

                </div>

                <div id="tab2" class="tab-pane tab-box">

                  <form name="airport_taxi_form" action="search-result.html">
                    <div class="row mt-5 mb-4" id="">
                      <div class="col-lg-3">
                        <i class="fas fa-map-marker-alt f-icon input1_icon"></i>
                        <input type="text" class="form-control input1_val" placeholder="Airport Location" name="start_destination" id="airport" data-filter="{{route('pick_location')}}?q=#QUERY#">
                        <div id="airport_suggestion_list" class="suggestion">
                        <!--Google map will be embedded here-->
                        </div>

                      </div>
                      <div class="col-lg-1">
                        <a href="#" id="flip_click">
                          <svg width="18" height="16" class="reverse-arrow" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 4H1" stroke="#FFA100" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16 7L19 4L16 1" stroke="#FFA100" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M4 17L1 14L4 11" stroke="#FFA100" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M1 14H19" stroke="#FFA100" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                          </svg>
                        </a>
                      </div>
                      <div class="col-lg-3">
                        <i class="fas fa-building f-icon input2_icon"></i>
                        <input type="text" class="form-control input2_val" placeholder="Hotel Name" name="end_destination" id="hotel" data-filter="{{route('pick_location')}}?q=#QUERY#">
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
                          <input type="checkbox" class="form-check-input" id="book_round_trip">
                          <label class="form-check-label" for="book_round_trip">Book Roundtrip</label>
                        </div>
                      </div>
                    </div>
                    <div class="row" id="book_round_trip_input" style="display:none;">
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
