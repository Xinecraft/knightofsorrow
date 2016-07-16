@if(Session::has('error'))
    <div class="alert alert-danger autohide alert-dismissible main-notification-box text-center" style="margin:20px;
    position: fixed;
    bottom: 0;
    right: 0;
    z-index: 9999;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{ Session::get('error') }}
    </div>
@endif

@if(Session::has('message'))
    <div class="alert alert-info autohide alert-dismissible main-notification-box text-center" style="margin: 20px;
    position: fixed;
    bottom: 0;
    right: 0;
    z-index: 9999;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{ Session::get('message') }}
    </div>
@endif

@if(Session::has('success'))
    <div class="alert alert-success autohide alert-dismissible main-notification-box text-center" style="margin: 20px;
    position: fixed;
    bottom: 0;
    right: 0;
    z-index: 9999;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{ Session::get('success') }}
    </div>
@endif