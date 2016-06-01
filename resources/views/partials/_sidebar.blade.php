<aside class="col-md-3">
    <div class="panel pad5" style="padding: 10px !important;">
        <h4 class="" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Join Server</h4>
        <a href="xfire:join?game=swat4&amp;server=31.186.250.156:10480" rel="SWAT4 Normal Server" title=""><h5 class="">SWAT4 - 127.0.0.1:10480</h5></a>
    </div>

    @include('partials._shoutbox',['shouts' => App\Shout::limit(15)->latest()->get()->sortBy('created_at')])

    {{--<div class="panel pad5" style="padding: 10px !important;">
        <h5 class="info-title" style="margin:0 0 10px 0;border-bottom:2px dashed grey">Donate</h5>
        <a href="donate">Donate for KoS</a>
    </div>--}}

</aside>