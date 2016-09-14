<table class="table table-striped table-bordered table-hover no-margin">
    <thead><tr>
        <th class="">First Seen</th>
        <th class="text-right">IP Address</th>
        <th class="text-right">Country</th>
    </tr></thead>
    @forelse($players as $player)
        <tr>
            <td class="">{{ $player->created_at->diffForHumans() }} - {{ $player->created_at->toDayDateTimeString() }}</td>
            <td class="text-right">{{ $player->ip_address }}</td>
            <td class="text-right"><img class="" title="{{ $player->country->countryName }}"
                                        src="/images/flags/20_shiny/{{ $player->country->countryCode }}.png"
                                        alt="" height="22px"> - <span class="text-bold">{{ $player->country->countryName }}</span></td>
        </tr>
    @empty
        Empty
    @endforelse
</table>