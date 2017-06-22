<?php

namespace App\Http\Controllers\Auth;

use App\Iphistory;
use Event;
use App\Events\UserRegistered;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers;

    protected $redirectTo = '/';


    /**
     * Create a new authentication controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'username' => 'required|alphanum|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {

        /**
         * Get the Country of User
         */
        $geoip = \App::make('geoip');
        $user_ip = \Input::getClientIp();
        try
        {
            if($user_geoip = $geoip->city($user_ip))
            {
                $user_isoCode = $user_geoip->country->isoCode;
                $country = \App\Country::where('countryCode', 'LIKE', $user_isoCode)->first();

                /**
                 * Country returned is not in Countrie table
                 */
                if($country == null)
                {
                    $user_country_id = 0;
                }
                else
                {
                    $user_country_id = $country->id;
                }
            }
        }
        /**
        * If the GeoIp2 failed to retrieve data
        */
        catch(\Exception $e)
        {
            switch($e)
            {
                case $e instanceof \InvalidArgumentException:
                    $user_country_id = 0;
                    break;
                case $e instanceof \GeoIp2\Exception\AddressNotFoundException:
                    $user_country_id = 0;
                    break;
                default:
                    $user_country_id = 0;
                    break;
            }
        }

        $confirmation_token = hash_hmac('sha256', str_random(40), $data['username']);

        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'name' => $data['name'],
            'password' => bcrypt($data['password']),
            'country_id' => $user_country_id,
            'last_ipaddress' => $user_ip,
            'confirmation_token' => $confirmation_token,
            'muted' => true
        ]);

        $user->iphistory()->create(['ip' => $user_ip]);

        // Attach a role of Member to it.
        // Make sure your table named roles has Members row with Id of 5
        // Or use $user->attachRole($member); with $member as a instance of Role
        $user->roles()->attach(5);

        /**
         * Fire event on User Register
         */
        Event::fire(new UserRegistered($user));

        /**
         * Return User to handle auto Login after Registration.
         */
        return $user;

    }

    /**
     * Handle a login request to the application.
     * Overrritten version of AuthenticatesAndRegistersUsers trait
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'username' => 'required', 'password' => 'required',
        ]);

        $credentials = $this->getCredentials($request);

        if (Auth::attempt($credentials, $request->has('remember'))) {

            $user_ip = \Input::getClientIp();
            $user = Auth::user();
            $user->last_ipaddress = $user_ip;
            $user->save();

            // Ipdate IP history
            if($iphistory = Iphistory::whereIp($user_ip)->first())
            {
                $iphistory->touch();
            }
            else
            {
                $user->iphistory()->create(['ip' => $user_ip]);
            }

            return redirect()->intended($this->redirectPath());
        }

        return redirect($this->loginPath())
            ->withInput($request->only('username', 'remember'))
            ->withErrors([
                'email' => $this->getFailedLoginMessage(),
            ]);
    }

    /**
     * Get the needed authorization credentials from the request.
     * Overrritten version of AuthenticatesAndRegistersUsers trait
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function getCredentials(Request $request)
    {
        return $request->only('username', 'password');
    }

    /**
     * Get the failed login message.
     * Overrritten version of AuthenticatesAndRegistersUsers trait
     *
     * @return string
     */
    protected function getFailedLoginMessage()
    {
        return 'These credentials do not match our records.';
    }

}
