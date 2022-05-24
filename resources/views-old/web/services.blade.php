{{-- Extends layout --}}
@extends('web.default')

{{-- Content --}}
@section('content')

    @include('web.layout.base._subheader')
    
    <div class="container pb-1">

        <div class="row pt-4">
            <div class="col">
                <div class="overflow-hidden mb-3">
                    <h2 class="font-weight-bold text-8 mb-0 appear-animation" data-appear-animation="maskUp">
                        We Are Here To Help You
                    </h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-10">
                <div class="overflow-hidden">
                    <p class="lead mb-0 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="200">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque rutrum pellentesque imperdiet. Nulla lacinia iaculis nulla non <span class="alternative-font">metus.</span> pulvinar. Sociis natoque penatibus et magnis dis parturient montes.
                    </p>
                </div>
            </div>
            <div class="col-lg-2 appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="500">
                <a href="#" class="btn btn-modern btn-dark mt-1">Get a Quote!</a>
            </div>
        </div>

        <div class="row">
            <div class="col py-3">
                <hr class="solid mt-5 mb-2">
            </div>
        </div>

        <div class="row">
            <div class="featured-boxes featured-boxes-style-2">
                <div class="row">
                    <div class="col-md-6 col-lg-4 appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="700">
                        <div class="featured-box featured-box-effect-4">
                            <div class="box-content">
                                <i class="icon-featured icon-screen-tablet icons text-color-primary bg-color-grey"></i>
                                <h4 class="font-weight-bold">Mobile Apps</h4>
                                <p class="px-3">Lorem ipsum dolor sit amt, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="900">
                        <div class="featured-box featured-box-effect-4">
                            <div class="box-content">
                                <i class="icon-featured icon-layers icons text-color-light bg-color-primary"></i>
                                <h4 class="font-weight-bold">Creative Websites</h4>
                                <p class="px-3">Lorem ipsum dolor sit amt, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="1100">
                        <div class="featured-box featured-box-effect-4">
                            <div class="box-content">
                                <i class="icon-featured icon-magnifier icons text-color-primary bg-color-grey"></i>
                                <h4 class="font-weight-bold">SEO Optimization</h4>
                                <p class="px-3">Lorem ipsum dolor sit amt, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 appear-animation" data-appear-animation="fadeInLeftShorter" data-appear-animation-delay="1500">
                        <div class="featured-box featured-box-effect-4">
                            <div class="box-content">
                                <i class="icon-featured icon-screen-desktop icons text-color-light bg-color-primary"></i>
                                <h4 class="font-weight-bold">Brand Solutions</h4>
                                <p class="px-3">Lorem ipsum dolor sit amt, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 appear-animation" data-appear-animation="fadeInLeftShorter" data-appear-animation-delay="1300">
                        <div class="featured-box featured-box-effect-4">
                            <div class="box-content">
                                <i class="icon-featured icon-doc icons text-color-primary bg-color-grey"></i>
                                <h4 class="font-weight-bold">HTML5 / CSS3 / JS</h4>
                                <p class="px-3">Lorem ipsum dolor sit amt, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 appear-animation" data-appear-animation="fadeInLeftShorter" data-appear-animation-delay="1100">
                        <div class="featured-box featured-box-effect-4">
                            <div class="box-content">
                                <i class="icon-featured icon-menu icons text-color-light bg-color-primary"></i>
                                <h4 class="font-weight-bold">Buttons</h4>
                                <p class="px-3">Lorem ipsum dolor sit amt, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="section bg-color-grey section-height-3 border-0 mt-5 mb-0">
        <div class="container">

            <div class="row">
                <div class="col">

                    <div class="row align-items-center pt-4 appear-animation" data-appear-animation="fadeInLeftShorter">
                        <div class="col-md-4 mb-4 mb-md-0">
                            <img class="img-fluid scale-2 pr-5 pr-md-0 my-4" src="{{ asset('template/basic/img/layout-styles.png') }}" alt="layout styles" />
                        </div>
                        <div class="col-md-8 pl-md-5">
                            <h2 class="font-weight-normal text-6 mb-3"><strong class="font-weight-extra-bold">Layout</strong> Styles &amp; Variants</h2>
                            <p class="text-4">There are so many styles you can combine that is possible to create almost any kind of layout based on Porto Template, navigate in our preview and see the header variations, the colors, and the page content types that you will be able to use.</p>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur imperdiet hendrerit volutpat. Sed in nunc nec ligula consectetur mollis in vel justo. Vestibulum ante ipsum primis in faucibus orci.</p>
                        </div>
                    </div>

                    <hr class="solid my-5">

                    <div class="row align-items-center pt-5 pb-3 appear-animation" data-appear-animation="fadeInRightShorter">
                        <div class="col-md-8 pr-md-5 mb-5 mb-md-0">
                            <h2 class="font-weight-normal text-6 mb-3"><strong class="font-weight-extra-bold">Exclusive</strong> Style Switcher</h2>
                            <p class="text-4">With our exlusive Style Switcher you will be able to choose any color you want for your website, choose the layout style (wide / boxed), website type (one page / normal), then generate the css that will be compiled by a {less} proccessor.</p>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur imperdiet hendrerit volutpat. Sed in nunc nec ligula consectetur mollis in vel justo. Vestibulum ante ipsum primis in faucibus orci.</p>
                        </div>
                        <div class="col-md-4 px-5 px-md-3">
                            <img class="img-fluid scale-2 my-4" src="{{ asset('template/basic/img/style-switcher.png') }}" alt="style switcher" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>				

    <div class="container-fluid">
        <div class="row featured-boxes-full featured-boxes-full-scale">
            <div class="col-lg-3 featured-box-full featured-box-full-primary">
                <i class="far fa-life-ring"></i>
                <h4>Customer Support</h4>
                <p class="font-weight-light">Lorem ipsum dolor sit amet, consectetur adipiscing metus elit. Quisque rutrum pellentesque imperdiet. Quisque rutrum pellentesque imperdiet.</p>
            </div>
            <div class="col-lg-3 featured-box-full featured-box-full-primary">
                <i class="fas fa-film"></i>
                <h4>Sliders</h4>
                <p class="font-weight-light">Lorem ipsum dolor sit amet, consectetur adipiscing metus elit. Quisque rutrum pellentesque imperdiet. Quisque rutrum pellentesque imperdiet.</p>
            </div>
            <div class="col-lg-3 featured-box-full featured-box-full-primary">
                <i class="far fa-star"></i>
                <h4>Winner</h4>
                <p class="font-weight-light">Lorem ipsum dolor sit amet, consectetur adipiscing metus elit. Quisque rutrum pellentesque imperdiet. </p>
            </div>
            <div class="col-lg-3 featured-box-full featured-box-full-primary">
                <i class="far fa-edit"></i>
                <h4>Customizable</h4>
                <p class="font-weight-light">Lorem ipsum dolor sit amet, consectetur adipiscing metus elit. Quisque rutrum pellentesque imperdiet. Quisque rutrum pellentesque imperdiet.</p>
            </div>
        </div>
    </div>

    <div class="container pt-4">
        <div class="row text-center pt-4 mt-5">
            <div class="col">
                <h2 class="word-rotator slide font-weight-bold text-8 mb-2">
                    <span>We're not the only ones </span>
                    <span class="word-rotator-words bg-primary">
                        <b class="is-visible">excited</b>
                        <b>happy</b>
                    </span>
                    <span> about Porto Template...</span>
                </h2>
                <h4 class="text-primary lead tall text-4">30,000 CUSTOMERS IN 100 COUNTRIES USE PORTO TEMPLATE. MEET OUR CUSTOMERS.</h4>
            </div>
        </div>

        <div class="row text-center mt-5 pb-5 mb-5">
            <div class="owl-carousel owl-theme carousel-center-active-item mb-0" data-plugin-options="{'responsive': {'0': {'items': 1}, '476': {'items': 1}, '768': {'items': 5}, '992': {'items': 7}, '1200': {'items': 7}}, 'autoplay': true, 'autoplayTimeout': 3000, 'dots': false}">
                <div>
                    <img class="img-fluid" src="{{ asset('template/basic/img/logos/logo-1.png') }}" alt="">
                </div>
                <div>
                    <img class="img-fluid" src="{{ asset('template/basic/img/logos/logo-2.png') }}" alt="">
                </div>
                <div>
                    <img class="img-fluid" src="{{ asset('template/basic/img/logos/logo-3.png') }}" alt="">
                </div>
                <div>
                    <img class="img-fluid" src="{{ asset('template/basic/img/logos/logo-4.png') }}" alt="">
                </div>
                <div>
                    <img class="img-fluid" src="{{ asset('template/basic/img/logos/logo-5.png') }}" alt="">
                </div>
                <div>
                    <img class="img-fluid" src="{{ asset('template/basic/img/logos/logo-6.png') }}" alt="">
                </div>
                <div>
                    <img class="img-fluid" src="{{ asset('template/basic/img/logos/logo-4.png') }}" alt="">
                </div>
                <div>
                    <img class="img-fluid" src="{{ asset('template/basic/img/logos/logo-2.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>

    <section class="call-to-action call-to-action-strong-grey content-align-center call-to-action-in-footer">
        <div class="container py-5">
            <div class="row py-3">
                <div class="col-md-9 col-lg-9">
                    <div class="call-to-action-content">
                        <h2 class="font-weight-normal text-7 mb-0">Porto is <strong>everything</strong> you need to create an <strong>awesome</strong> website!</h2>
                        <p class="mb-0">The best HTML template for your new website.</p>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3">
                    <div class="call-to-action-btn">
                        <a href="http://themeforest.net/item/porto-responsive-html5-template/4106987" target="_blank" class="btn btn-dark btn-lg text-3 font-weight-semibold px-4 py-3 mt-5">Get Started Now</a><span class="arrow hlb d-none d-md-block" data-appear-animation="rotateInUpLeft" style="top: -90px; left: 70%;"></span>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

{{-- Scripts Section --}}
@section('scripts')
    {{-- <script src="{{ asset('plugins/custom/ckeditor/ckeditor-document.bundle.js') }}"></script> --}}

    <script>

    </script>
@endsection
