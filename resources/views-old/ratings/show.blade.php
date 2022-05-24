@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ isset($title) ? $title : 'Rating' }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        <form method="POST" action="{!! route('rating.destroy', $rating->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('rating.index') }}" class="btn btn-primary" title="{{ trans('ratings.show_all') }}">
                        <i class="fas fa-list-alt"></i>
                    </a>

                    <a href="{{ route('rating.edit', $rating->id ) }}" class="btn btn-primary" title="{{ trans('ratings.edit') }}">
                        <i class="fas fa-edit"></i>
                    </a>

                    <button type="submit" class="btn btn-danger" title="{{ trans('ratings.delete') }}" onclick="return confirm(&quot;{{ trans('ratings.confirm_delete') }}?&quot;)">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </form>
    </div>
@stop

@section('content')

<div class="panel panel-default">
<div class="card card-primary card-outline">
<div class="card-body">
    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>{{ trans('ratings.trip_id') }}</dt>
            <dd>{{ $rating->trip->trip_no }}</dd>            
			<dt>{{ trans('ratings.rated_by') }}</dt>
            <dd>{{ $rating->ratedBy->name }}</dd>           
            <dt>{{ trans('ratings.rated_for') }}</dt>
            <dd>{{ $rating->ratedFor->name }}</dd>         
            <dt>{{ trans('ratings.user_type') }}</dt>
            <dd>{{ $rating->ratedFor->userType->user_type }}</dd>
            <dt>{{ trans('ratings.rating') }}</dt>
            <dd>
                <div class="stars" style="--rating: 2.5;"></div>    
            </dd> 

            <dt>{{ trans('ratings.rating_comment') }}</dt>
            <dd>{{ $rating->rating_comment }}</dd>   
            <dt>{{ trans('ratings.done_by') }}</dt>
            <dd>{{ $rating->doneBy->name }}</dd>                      

        </dl>
    </div>
    </div>
</div>
</div>

@endsection
