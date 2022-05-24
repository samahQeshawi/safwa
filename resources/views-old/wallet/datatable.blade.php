    <div class="btn-group btn-group-xs pull-right" role="group">
        <a href=" {{ route('wallet.show', $wallet->id) }} " class="btn btn-info" title=" {{ trans('wallet.show') }}">
            <i class="fas fa-eye"></i>
        </a>
        <button type="button" class="btn btn-danger amount-modal" data-user-id="{{$wallet->user_id}}" data-toggle="modal" data-target="#modal-lg">
           <i class="fas fa-plus"></i>
        </button>        
        <button type="button" class="btn btn-primary amount-minus-modal" data-user-id="{{$wallet->user_id}}" data-toggle="modal" data-target="#modal-lg">
           <i class="fas fa-minus"></i>
        </button>
    </div>
