<div class="row status-post">
    {!! Form::open(['route' => 'post-status']) !!}
    <div class="div form-group status-post-input">
        {!! Form::textarea('body',null,['id'=>'statusupdatetextarea','class'=>'form-control','placeholder'=>"What's in your mind?" ,"cols" => 60, "rows" => 3]) !!} <br>
    </div>
    <div class="form-group status-post-submit">
        {!! Form::submit('Update Status',['class'=>'btn btn-primary right btn-xs']) !!}
    </div>
    {!! Form::close() !!}
</div>