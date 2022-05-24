                <ul class="navbar-nav ml-auto">

                  <li class="nav-item active">

                    <a class="nav-link @if( request()->path() === (request()->lang . '/index') ) active @endif" href="home">
                      <i class="icon icon-home"></i>
                        <span>{{ __('web.home') }}</span>
                    </a>

                  </li>

                  <li class="nav-item">

                    <a class="nav-link" href="fleet">
                      <i class="icon icon-our-fleet"></i>
                      <span>{{ __('web.fleet') }}</span>
                    </a>

                  </li>

                  <li class="nav-item">

                    <a class="nav-link" href="branches">
                      <i class="icon icon-branches"></i>
                      <span>{{ __('web.branches') }}</span>
                    </a>

                  </li>

                  <li class="nav-item">

                    <a class="nav-link" href="offers">
                      <i class="icon icon-offers"></i>
                      <span>{{ __('web.offers') }}</span>
                    </a>

                  </li>

                  <!-- <li class="nav-item">

                    <a class="nav-link" href="corporate-contracts.html">
                      <i class="icon icon-contract"></i>
                      <span>Corporate Contracts</span>
                    </a>

                  </li> -->

                  <li class="nav-item">

                    <a class="nav-link" href="contact">
                      <i class="icon icon-employment"></i>
                      <span>{{ __('web.contact') }}</span>
                    </a>

                  </li>

                  <!-- <li class="nav-item">

                    <a class="nav-link" href="#">
                      <i class="icon icon-login"></i>
                      <span>Supplier Portal</span>
                    </a>

                  </li> -->

                </ul>

                <ul class="navbar-nav">

                  <li class="nav-item">
                    <a href="customers_portal" class="nav-link login-btn" >{{ __('web.customers_portal') }}</a>

                    <a href="#" class="nav-link language-link changeLang"
                    @if(session()->get('langCode') == 'en')
                        data-id="ar" >عربي
                    @else
                        data-id="en" >EN
                    @endif
                    </a>

                  </li>

                </ul>
