<div class="row player-records">
    <div style="width: 99.99%" class="col-xs-12 panel panel-default no-padding no-margin no-left-padding">
        <div class="panel-heading">
            <span class="info-title">Notifications</span>
        </div>
        <div class="panel-body">
            <ul class="list-group">
                @forelse($feeds as $feed)
                    <li class="list-group-item">
                        <a href="{{ route('user.show',$feed->user->username) }}">
                            <strong class="primary-font">{{ $feed->user->displayName() }}</strong>
                        </a> updated his status <i class="text-danger">{!! link_to_route('show-status',$feed->timeSincePublished,[$feed->id],['class' => 'status-timeago']) !!}</i>. <small class="text-muted convert-emoji"> {{ str_limit($feed->body,50) }} </small>
                    </li>
                @empty
                    <li class="list-group-item">No New Notifcations</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>