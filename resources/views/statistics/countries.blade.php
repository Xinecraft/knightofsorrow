@extends('layouts.main')

@section('main-container')
<div id="news">
    <ul id="items">
        @foreach($countries as $item)
            <li class="item">
                <a href="" target="_blank">{{ $item->countryName }}</a>
            </li>
        @endforeach
    </ul>
    {!! $countries->render() !!}
</div>
@endsection