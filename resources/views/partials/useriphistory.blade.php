<table class="table table-striped table-bordered table-hover no-margin">
    <thead><tr>
        <th class="">IP Address</th>
        <th class="">First Seen</th>
        <th class="">Last Seen</th>
    </tr></thead>
    @forelse($useriphistory as $history)
        <tr>
            <td class=""><b>{!! link_to_route('api.ip.country',$history->ip,[$history->ip])  !!}</b></td>
            <td class="">{{ $history->created_at->diffForHumans() }} - {{ $history->created_at->toDayDateTimeString() }}</td>
            <td class="">{{ $history->updated_at->diffForHumans() }} - {{ $history->updated_at->toDayDateTimeString() }}</td>
        </tr>
    @empty
        Empty
    @endforelse
</table>