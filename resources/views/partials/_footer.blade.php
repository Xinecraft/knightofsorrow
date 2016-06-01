<style>
    .subscriber_email_input {
        font-size: 14px;
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
            <div class="col-md-3 col-md-offset-5">
                <p class="copyright">
                    <i class="fa fa-copyright"></i> {{ date('Y') }} Knight of Sorrow
                </p>
                </div>
                <div class="col-md-3 col-md-offset-1">
                    <small class="muted">Page took {{ round((microtime(true) - LARAVEL_START),5) }} seconds to render</small>
                </div>
            </div>
        </div>
</footer>