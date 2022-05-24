@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ isset($title) ? $title : 'Rating' }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        <form method="POST" action="{!! route('rating.destroy', $rating->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    @can("view ratings")
                    <a href="{{ route('rating.index') }}" class="btn btn-primary" title="{{ trans('ratings.show_all') }}">
                        <i class="fas fa-list-alt"></i>
                    </a>
                    @endcan
                    @can("edit ratings")
                    <a href="{{ route('rating.edit', $rating->id ) }}" class="btn btn-primary" title="{{ trans('ratings.edit') }}">
                        <i class="fas fa-edit"></i>
                    </a>
                    @endcan
                    @can("delete ratings")

                    <button type="submit" class="btn btn-danger" title="{{ trans('ratings.delete') }}" onclick="return confirm(&quot;{{ trans('ratings.confirm_delete') }}?&quot;)">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                    @endcan
                </div>
            </form>
    </div>
@stop

@section('content')


<div class="panel panel-default">
<div class="card card-primary card-outline">
<div class="card-body">
    <div class="panel-body">
          <div class="card bg-light mb-3">
            <div class="card-header text-white bg-primary mb-3">Rating Information</div>
                            <div class="card-body">
                                 <div class="row">
                                    <div class="col md-6">        
                                         <dt>{{ trans('ratings.trip_id') }}</dt>
                                            <dd>{{ $rating->trip->trip_no }}</dd>   
                                    </div>
                                    <div class="col md-6"> 
                                              
                                        <dt>{{ trans('ratings.rated_by') }}</dt>
                                        <dd>{{ @$rating->ratedBy->name }}</dd> 
                                    </div>
                                </div>        
                                <div class="row">
                                    <div class="col md-6">        
                                           <dt>{{ trans('ratings.rated_for') }}</dt>
                                            <dd>{{ @$rating->ratedFor->name }}</dd>     
                                    </div>
                                    <div class="col md-6"> 
                                                    
                                        <dt>{{ trans('ratings.user_type') }}</dt>
                                        <dd>{{ @$rating->ratedFor->userType->user_type }}</dd>
                                    </div>
                                </div>    
                                 <div class="row">
                                    <div class="col md-6">        
                                          
                                        <dt>{{ trans('ratings.rating') }}</dt>
                                        <dd>
                                            <div class="stars" style="--rating: 2.5;"></div>    
                                        </dd>    
                                    </div>
                                    <div class="col md-6"> 
                                                    
                                                                  

                                        <dt>{{ trans('ratings.rating_comment') }}</dt>
                                        <dd>{{ $rating->rating_comment }}</dd>   
                                    </div>
                                </div>
          
                                <div class="row">
                                    <div class="col md-6">        
                                           <dt>{{ trans('ratings.done_by') }}</dt>
                                            <dd>{{ $rating->doneBy->name }}</dd>     
                                    </div>
                                    <div class="col md-6"> 
                                                    
                                    </div>
                                </div>   
                            </div>
                        </div>
                                

        
    </div>
    </div>
</div>
</div>

@endsection
