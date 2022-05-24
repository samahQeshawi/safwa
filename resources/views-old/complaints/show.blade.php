@extends('adminlte::page')

@section('content_header')
    <h1 class="m-0 text-dark">{{ isset($title) ? $title : 'Complaint' }}</h1>
    <div class="btn-group btn-group-sm pull-right" role="group">
        <form method="POST" action="{!! route('cartype.destroy', $complaint->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('complaint.index') }}" class="btn btn-primary" title="{{ trans('complaints.show_all') }}">
                        <i class="fas fa-list-alt"></i>
                    </a>

                    <button type="submit" class="btn btn-danger" title="{{ trans('complaints.delete') }}" onclick="return confirm(&quot;{{ trans('complaints.confirm_delete') }}?&quot;)">
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
            <dt>{{ trans('complaints.complaint_no') }}</dt>
            <dd>{{ $complaint->complaint_no }}</dd>
			<dt>{{ trans('complaints.service') }}</dt>
            <dd>{{ $complaint->service->service }}</dd>
            {{-- <dt>{{ trans('complaints.car_rental') }}</dt>
            <dd>{{ $complaint->car_rental->booking_no }}</dd> --}}
            <dt>{{ trans('complaints.trip') }}</dt>
            <dd>{{ $complaint->trip->trip_no }}</dd>
            <dt>{{ trans('complaints.from_user') }}</dt>
            <dd>{{ $complaint->from_user->name }} ({{ $complaint->fromUserType->user_type}})</dd>
            <dt>{{ trans('complaints.against_user') }}</dt>
            <dd>{{ $complaint->against_user->name }} ({{ $complaint->againstUserType->user_type}})</dd>
            <dt>{{ trans('complaints.subject') }}</dt>
            <dd>{{ $complaint->subject }}</dd>
            <dt>{{ trans('complaints.complaint') }}</dt>
            <dd>{{ $complaint->complaint }}</dd>
            <dt>{{ trans('complaints.status') }}</dt>
            <dd><select name="status" id="status" class="form-control" style='width:120px;float:left;'>
                <option value="New" {{ ($complaint->status == 'New') ? 'selected':''}}>{{  trans('complaints.new') }}</option>
                <option value="Read" {{ ($complaint->status == 'Read') ? 'selected':''}}>{{ trans('complaints.read') }}</option>
                <option value="Processing" {{ ($complaint->status == 'Processing') ? 'selected':''}}>{{ trans('complaints.processing') }}</option>
                <option value="Solved" {{ ($complaint->status == 'Solved') ? 'selected':''}}>{{ trans('complaints.solved') }}</option>
                </select>
                <button type="submit" name="change-status" id="change-status" class="btn btn-primary mb-2 mr-sm-2" style="float:left;margin-left:10px;">{{ trans('complaints.change') }}</button>
            </dd>
        </dl>
    </div>
    </div>
</div>
</div>

@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#change-status').on('click',function(e) {
            e.preventDefault();
            $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });
            $.ajax({
               type: "POST",
               url: '{{ route("complaint.change_status") }}',
               dataType: "json",
               data: {
                    'status': $('#status').val(),
                    'id': '{{ $complaint->id }}'
                }, // serializes the form's elements.
               success: function(data)
               {
                    if(data.status){
                        alert("Succesfully Updated"); // show response from the php script.
                    }
               }
             });
        });
    });
</script>
@stop
