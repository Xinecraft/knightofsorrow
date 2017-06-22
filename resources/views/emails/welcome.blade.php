{{ $user->name }} , Welcome to KNIGHTofSORROW.IN <br>
Please visit the following link to confirm your email. <br>
{!! link_to_route('user.email.confirmation',null,[$user->id,$user->confirmation_token]) !!} <br>
<i>Note: If the above link not clickable then please copy and paste the link provided below in address bar of your browser and press enter.</i>
{!! route('user.email.confirmation',[$user->id,$user->confirmation_token]) !!} <br>

Regards,
uS| Team
knightofsorrow.in