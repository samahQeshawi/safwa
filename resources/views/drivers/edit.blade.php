@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ !empty($title) ? $title : 'Driver' }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        @can("view drivers")
        <a href="{{ route('drivers.driver.index') }}" class="btn btn-primary" title="{{ trans('drivers.show_all') }}">
            <i class="fas fa-list-alt"></i>
        </a>
        @endcan
        @can("add drivers")
        <a href="{{ route('drivers.driver.create') }}" class="btn btn-success" title="{{ trans('drivers.create') }}">
            <i class="fas fa-plus-circle"></i>
        </a>
        @endcan

    </div>
@stop

@section('content')

    <div class="panel panel-default">
    <div class="card card-primary card-outline">
    <div class="card-body">




        <div class="panel-body">

            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form method="POST" action="{{ route('drivers.driver.update', $driver->id) }}" id="edit_driver_form" name="edit_driver_form" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('drivers.form', [
                                        'driver' => $driver,
                                        'car_photo'=> $car_photo
                                      ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="{{ trans('drivers.update') }}">
                    </div>
                </div>
            </form>
 </div> </div>
        </div>
    </div>

@endsection

@section('js')
<script type="text/javascript">
    $(function () {
   $('.date-picker').datepicker({
               format: 'yyyy-mm-d'
    });
   $('#service_id').on('change',function() {
        var service_id = $(this).val();
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.ajax({
            type: "POST",
            url: "{{ route("car.getcategories") }}",
            data: { 'id': service_id  },
            dataType:"json",
            type: "get",
            success: function(data){
                //Empty the DropDown
                $("#category_id").empty();
                // Use jQuery's each to iterate over the opts value
                $.each(data, function(i, d) {
                    // You will need to alter the below to get the right values from your json object.  Guessing that d.id / d.modelName are columns in your carModels data
                    $('#category_id').append('<option value="' + d.id + '">' + d.category + '</option>');
                });
            }
        });
   });
    $('#short_description').summernote({
        height: 100,
        toolbar: [
            [ 'style', [ 'style' ] ],
            [ 'font', [ 'bold', 'italic', 'underline', 'clear'] ],
            [ 'fontname', [ 'fontname' ] ],
            [ 'fontsize', [ 'fontsize' ] ],
            [ 'color', [ 'color' ] ],
            [ 'para', [ 'ol', 'ul', 'paragraph' ] ],
            [ 'insert', [ 'link'] ],
            [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
        ]
    });
    $('#description').summernote({
        height: 250,
        toolbar: [
            [ 'style', [ 'style' ] ],
            [ 'font', [ 'bold', 'italic', 'underline', 'clear'] ],
            [ 'fontname', [ 'fontname' ] ],
            [ 'fontsize', [ 'fontsize' ] ],
            [ 'color', [ 'color' ] ],
            [ 'para', [ 'ol', 'ul', 'paragraph' ] ],
            [ 'insert', [ 'link'] ],
            [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
        ]
    });    
    $("#photo_upload").change(function () {
        if (typeof (FileReader) != "undefined") {
            var dvPreview = $("#image-preview");
            dvPreview.html("");
            var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
            var img_index = 0 ;
            $($(this)[0].files).each(function () {
                var file = $(this);
                if (regex.test(file[0].name.toLowerCase())) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var diva_wrapper = $("<div></div>");
                        var radioBtn = $('<div class="image-index-wrapper"><input type="radio" name="main_image" value="'+img_index+'"/></div>');
                        var img = $("<img />");
                        img.attr("style", "height:100px;width: 100px");
                        img.attr("src", e.target.result);
                        diva_wrapper.append(img);
                        diva_wrapper.append(radioBtn);
                        diva_wrapper.addClass('image-wrapper');
                        dvPreview.append(diva_wrapper);
                        img_index++;
                    }
                    reader.readAsDataURL(file[0]);
                } else {
                    alert(file[0].name + " is not a valid image file.");
                    dvPreview.html("");
                    return false;
                }
            });
        } else {
            alert("This browser does not support HTML5 FileReader.");
        }
    });    
  })
</script>
@endsection
