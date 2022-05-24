@extends('adminlte::page')

@section('content_header')
<h1 class="m-0 text-dark">{{ !empty($title) ? $title : 'Rating' }}</h1>
<div class="btn-group btn-group-sm pull-right" role="group">
    @can("view ratings")
    <a href="{{ route('rating.index') }}" class="btn btn-primary" title="{{ trans('ratings.show_all') }}">
        <i class="fas fa-list-alt"></i>
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

                <form method="POST" action="{{ route('rating.update', $rating->id) }}" id="edit_rating_form"
                    name="edit_branch_form" accept-charset="UTF-8" class="form-horizontal">
                    {{ csrf_field() }}
                    <input name="_method" type="hidden" value="PUT">
                    @include ('ratings.form', [
                    'rating' => $rating,
                    ])

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-10">
                            <input class="btn btn-primary" type="submit" value="{{ trans('ratings.update') }}">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
