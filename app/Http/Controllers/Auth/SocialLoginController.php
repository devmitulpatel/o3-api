<?php

namespace App\Http\Controllers\Auth;

use Exception;
use Socialite;
use App\SocialAccount;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialLoginController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)
            ->scopes(['users:email'])
            ->redirect();
    }

    public function callback($provider)
    {
        try {
            $providerUser = Socialite::with($provider)->user();
        } catch (Exception $e) {
            return redirect()->route('login');
        }

        $user = $this->findOrCreate($providerUser, $provider);

        auth()->login($user, true);

        return redirect()->to(RouteServiceProvider::HOME);
    }

    /**
     * @param \Laravel\Socialite\Contracts\User $providerUser
     * @param $provider
     * @return mixed
     */
    protected function findOrCreate(ProviderUser $providerUser, $provider)
    {
        $account = SocialAccount::where('provider_name', $provider)
            ->where('provider_id', $providerUser->getId())
            ->first();

        if ($account) {
            return $account->user;
        }

        $user = User::where('email', $providerUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'email' => $providerUser->getEmail(),
                'name'  => $providerUser->getName(), // TODO: get first name, last name
            ]);

            event(new Registered($user));
        }

        $user->social_accounts()->create([
            'provider_id'   => $providerUser->getId(),
            'provider_name' => $provider,
        ]);

        return $user;
    }
}
