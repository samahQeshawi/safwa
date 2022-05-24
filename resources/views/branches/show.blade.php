@extends('adminlte::page')

@section('content_header')
<h1 class="m-0 text-dark">{{ isset($title) ? $title : 'Branch' }}</h1>
<div class="btn-group btn-group-sm pull-right" role="group">
    <form method="POST" action="{!! route('branches.destroy', $branch->id) !!}" accept-charset="UTF-8">
        <input name="_method" value="DELETE" type="hidden">
        {{ csrf_field() }}
        <div class="btn-group btn-group-sm" role="group">
            @can("view branch")
            <a href="{{ route('branches.index') }}" class="btn btn-primary" title="{{ trans('branch.show_all') }}">
                <i class="fas fa-list-alt"></i>
            </a>
            @endcan
            @can("add branch")
            <a href="{{ route('branches.create') }}" class="btn btn-success" title="{{ trans('branch.create') }}">
                <i class="fas fa-plus-circle"></i>
            </a>
            @endcan
            @can("edit branch")
            <a href="{{ route('branches.edit', $branch->id ) }}" class="btn btn-primary"
                title="{{ trans('branch.edit') }}">
                <i class="fas fa-edit"></i>
            </a>
            @endcan
            @can("delete branch")
            <button type="submit" class="btn btn-danger" title="{{ trans('branch.delete') }}"
                onclick="return confirm(&quot;{{ trans('branch.confirm_delete') }}?&quot;)">
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
                    <div class="card-header text-white bg-primary mb-3">Branch Details</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col md-6">
                                <dt>{{ trans('branch.service') }}</dt>
                                <dd>{{ optional($branch->service)->service }}</dd>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col md-6">
                                <dt>{{ trans('branch.branch_code') }}</dt>
                                <dd>{{ optional($branch)->branch_code }}</dd>
                            </div>
                            <div class="col md-6">
                                <dt>{{ trans('branch.name') }}</dt>
                                <dd>{{ optional($branch)->name }}</dd>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col md-6">
                                <dt>{{ trans('branch.email') }}</dt>
                                <dd>{{ optional($branch)->email }}</dd>
                            </div>
                            <div class="col md-6">
                                <dt>{{ trans('branch.phone') }}</dt>
                                <dd>{{ optional($branch)->phone }}</dd>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col md-6">
                                <dt>{{ trans('branch.country') }}</dt>
                                <dd>{{ optional($branch->country)->name }}</dd>
                            </div>
                            <div class="col md-6">
                                <dt>{{ trans('branch.city') }}</dt>
                                <dd>{{ optional($branch->city)->name }}</dd>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col md-6">
                                <dt>{{ trans('branch.address') }}</dt>
                                <dd>{{ optional($branch)->address }}</dd>
                            </div>
                            <div class="col md-6">
                                <dt>{{ trans('branch.is_active') }}</dt>
                                <dd>{{ ($branch->is_active) ? 'Yes' : 'No' }}</dd>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card bg-light mb-3">
                    <div class="card-header text-white bg-primary mb-3">Location Details</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col md-6">
                                <div id="map_location"></div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card bg-light mb-3">
                    <div class="card-header text-white bg-primary mb-3">Other Details</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col md-6">
                                <dt>{{ trans('branch.created_at') }}</dt>
                                <dd>{{ $branch->created_at }}</dd>
                            </div>
                            <div class="col md-6">
                                <dt>{{ trans('branch.updated_at') }}</dt>
                                <dd>{{ $branch->updated_at }}</dd>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')

<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA-q1JYVn8f510Ta_pZPI0iOHcFpBFshMY&callback=initMap&libraries=&v=weekly"
    defer></script>
<style type="text/css">
    #map_location {
        height: 0;
        overflow: hidden;
        margin-left: 8px;
        margin-bottom: 4px;
        padding-bottom: 35.25%;
        padding-top: 30px;
        position: relative;
    }
</style>
<script>
    function initMap() {

    const myLatlng = { lat: {{optional($branch)->latitude ?: 24.774265 }}, lng: {{optional($branch)->longitude ?: 46.738586}} };
    const map = new google.maps.Map(document.getElementById("map_location"), {
      zoom: 6,
      center: myLatlng,
    });
    // Create the initial InfoWindow.
    let infoWindow = new google.maps.InfoWindow({
      content: "{{optional($branch)->name}} <br> ({{optional($branch)->latitude }}, {{optional($branch)->longitude}})<br><br> {{optional($branch)->address}}",
      position: myLatlng,
    });
    infoWindow.open(map);

    new google.maps.Marker({
		position: myLatlng,
		map: map
	});
  }
</script>
@endsection
