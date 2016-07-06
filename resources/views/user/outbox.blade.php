@extends('layouts.main')
@section('main-container')
    <div class="content col-xs-9">
        @include('partials._errors')

        <div class="rounds panel panel-default">
            <div class="panel-heading"><strong>Sent Mails ({{ $outbox->count() }})</strong></div>
            <div class="panel-body">
                <table id="" class="table table-striped table-hover no-margin">
                    <thead>
                    <tr>
                        <th class="col-xs-2">Reciever</th>
                        <th class="col-xs-8">Subject</th>
                        <th class="col-xs-2 text-right">Time</th>
                    </tr>
                    </thead>
                    <tbody id="data-items">
                    @foreach($outbox as $mail)
                        <tr class="item">
                            <td class="color-main text-bold">{!! link_to_route('user.show', $mail->reciever->displayName(), [$mail->reciever->username]) !!}</td>

                            <td>
                                @if($mail->seen_at == null)
                                    <b>{!! link_to_route('user.inbox.show',htmlentities($mail->subject),[$mail->id],['class' => 'a-simple']) !!}</b>
                                @else
                                    {!! link_to_route('user.inbox.show',htmlentities($mail->subject),[$mail->id],['class' => 'a-simple']) !!}
                                @endif
                            </td>

                            <td class="text-right">{{ $mail->created_at->diffForHumans() }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {!! $outbox->render() !!}
            <div id="loading" class="text-center"></div>
        </div>


    </div>
@endsection