<div class="panel panel-default grid-item item">
    <div class="panel-heading media">
        <div class="pull-left">
            {!! Html::image('/images/vip.jpg','',array('class'=>'img media-oject','width'=>'40','height'=>'40')) !!}
        </div>
        <div class="media-body row">
            <div class="col-md-9 no-padding">
                <b>{!! link_to_route('user.show',$status->user->name,[$status->user->username]) !!}</b>
                <p class="small user-status-timeago no-margin">{{ $status->timeSincePublished }}</p>
            </div>
            <div class="col-md-3">
                @if(Auth::check() and Auth::user()->id == $status->user->id)
                    {!! Form::open(['name'=>'deleteStatus','method'=>'DELETE','action'=>'StatusController@destroy','class'=>'form-inline pull-right deleteStatus']) !!}
                    {!! Html::link(action('StatusController@show',['id' => $status->id]),'S',['class'=>'btn btn-info btn-xs tooltipster', 'title' => 'Show details']) !!}
                    {!! Html::link(action('StatusController@edit',['id' => $status->id]),'E',['class'=>'btn btn-warning btn-xs tooltipster', 'title' => 'Edit Status']) !!}
                    {!! Form::hidden('id',$status->id) !!}
                    {!! Form::submit('D',['class'=>'btn btn-danger btn-xs submit tooltipster', 'title' => 'Delete Status']) !!}
                    {!! Form::close() !!}
                @endif
            </div>
        </div>

    </div>
    <div class="panel-body"> {!! $status->statusBody !!}</div>
    <div class="panel-footer text-right"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
        
    </div>
</div>