<aside class="col-md-3">
    <div class="panel pad5" style="padding: 10px !important;">
        <h4 class="" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Join Server <small>(using)</small></h4>

        <ul class="list-group">
            <li class="list-group-item">
                <span class="small"><kbd>ip</kbd> &nbsp;&nbsp;&nbsp;&nbsp;  -  <b class="text-danger">81.4.127.91:10480</b></span>
            </li>
            <li class="list-group-item">
                <span class="small"><kbd>name</kbd> - <b class="text-danger">knightofsorrow.tk:10480</b></span>
            </li>
        </ul>
    </div>

    @include('partials._shoutbox',['shouts' => App\Shout::limit(15)->latest()->get()->sortBy('created_at')])

    <script type="text/javascript" src="http://www.easypolls.net/ext/scripts/emPoll.js?p=5753d3d5e4b073540521b847"></script><a class="OPP-powered-by" href="https://www.murvey.com" style="text-decoration:none;"><div style="font: 9px arial; color: gray;">survey software</div></a>
      {{--<div class="panel pad5" style="padding: 10px !important;">
        <h5 class="info-title" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Donate</h5>
        <a href="donate">Donate for KoS</a>
    </div>--}}

</aside>