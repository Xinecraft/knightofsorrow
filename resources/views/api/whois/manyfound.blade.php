Found [b]{{ $players->count() }}[\b] players matching [b]{{ $searchQuery }}[\b]: [b]
@foreach($players->take(5) as $player)
[c=FFFF00]{{ $player->name }}[\c][c=00ff00] - [\c]
@endforeach
[\b]