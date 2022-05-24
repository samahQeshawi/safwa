{{-- Extends layout --}}
@extends('web.default')

{{-- Content --}}
@section('content')

    @include('web.layout.base._subheader')
    
    <div class="container py-4">

        <div class="row">
            <div class="col">

                <h2 class="font-weight-normal text-7 mb-2">
                    {{__('website.faqs_title')}}
                </h2>
                <p >{{__('website.faqs_intro')}}</p>

                <hr class="solid my-5">

                <div class="toggle toggle-primary" data-plugin-toggle>
                    @php
                        $n = 0;
                    @endphp
                    @foreach ($data as $row)
                        @php
                            $n++;
                        @endphp
                        <section class="toggle @if($n == 1) active @endif">
                            <a class="toggle-title">{{$row->title}}</a>
                            <div class="toggle-content">
                                <p>{!!preg_replace('/font-family.+?;/', "", $row->content);!!}</p>
                            </div>
                        </section>
                    @endforeach


                </div>

            </div>

        </div>

    </div>

@endsection

{{-- Scripts Section --}}
@section('scripts')
    {{-- <script src="{{ asset('plugins/custom/ckeditor/ckeditor-document.bundle.js') }}"></script> --}}

    <script>

    </script>
@endsection
