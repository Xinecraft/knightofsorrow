<style>
    .subscriber_email_input {
        font-size: 14px;
    }
    .copyright
    {
        font-family: 'Passion One', cursive;
        font-size: 17px;
    }

    @media (max-width: 767px) {
        .subscriber_email_input {
            font-size: 12px;
        }
        .footer-social-icon
        {
            margin-top:13px !important;
        }

        .copyright {
            font-size: 14px;
        }

        .developed_by {
            font-size: 12px;
            padding-bottom: 10px;
        }
    }
</style>
<footer class="footer" style="    padding: 25px 0;
    background: #232323;color: #f6f6f6">
    <div class="container">
        <div class="row">

            <div class="col-xs-2">
            <iframe src="https://www.facebook.com/plugins/like.php?href=https://www.facebook.com/knightofsorrow.tk&width=87&layout=button_count&action=like&show_faces=false&share=false&height=21&appId=102061086801044" width="87" height="21" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
            </div>

            <div class="col-xs-4 col-xs-offset-2 text-center">
                <p class="copyright">
                    <i class="fa fa-copyright"></i> {{ date('Y') }} KNIGHTofSORROW
                </p>
                <i><small class="muted">Page rendered in {{  round((microtime(true) - LARAVEL_START),3) }} seconds with {{Session::get('query_no')}} queries</small></i>
                </div>
                <div class="col-xs-3 col-xs-offset-1">
                    <i><small class="text-muted">Time: {{ \Carbon\Carbon::now()->toDayDateTimeString() }}</small></i>

                </div>
            </div>
        </div>
</footer>