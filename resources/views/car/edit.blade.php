@extends('adminlte::page')

@section('content_header')
<h1 class="m-0 text-dark">{{ !empty($title) ? $title : 'Car' }}</h1>
<div class="btn-group btn-group-sm pull-right" role="group">
    @can("view cars")
    <a href="{{ route('car.view_cars',$car->service_id) }}" class="btn btn-primary" title="{{ trans('car.show_all') }}">
        <i class="fas fa-list-alt"></i>
    </a>
    @endcan
    @can("add cars")
    <a href="{{ route('car.create',['service_type'=>$car->service_id]) }}" class="btn btn-success" title="{{ trans('car.create') }}">
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

                <form method="POST" action="{{ route('car.update', $car->id) }}" id="edit_car_form" name="edit_car_form"
                    accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input name="_method" type="hidden" value="PUT">
                    @include ('car.form', [
                    'car' => $car,
                    'car_photo'=> $car_photo
                    ])

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-10">
                            <input class="btn btn-primary" type="submit" value="{{ trans('car.update') }}">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script type="text/javascript">
    $(function () {
   $('.date-picker').datepicker({
               format: 'yyyy-mm-d'
    });
   $('#branch_id').select2({
        placeholder: 'Select Location',
        ajax: {
            url: '{{ route("car.search.location") }}',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });   
   <?php if(isset($car->location)) { ?>
    var branch_selected = new Option('{{$car->location->name}}', '{{$car->location->id}}', true, true);
    <?php } ?>
    $('#branch_id').append(branch_selected).trigger('change');   
   $('#location_id').select2({
        placeholder: 'Select Location',
        ajax: {
            url: '{{ route("car.search.location") }}',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });
   <?php if(isset($car->location)) { ?>
    var newLocation = new Option('{{$car->location->name}}', '{{$car->location->id}}', true, true);
    <?php } ?>
    $('#location_id').append(newLocation).trigger('change');
    // Summernote
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

