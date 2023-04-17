<?php

namespace Modules\Auth\UseCases\API\OAuth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Modules\Auth\Exceptions\EmailTakenException;
use Illuminate\Http\Client\RequestException;
use Modules\Auth\Entities\User\Network;
use Laravel\Socialite\SocialiteManager;
use Modules\Shared\Entities\User\User;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Str;
use Exception;
use Storage;

final class HandleProviderCallbackAction
{
    use AuthenticatesUsers;

    private Dispatcher $dispatcher;

    public function __construct(Dispatcher $dispatcher)
    {

        $this->dispatcher = $dispatcher;
    }

    public function __invoke(string $network): mixed
    {
        try {
            $socialite = new SocialiteManager(app());
            $user = $socialite->driver($network)->stateless()->user();
            $user = $this->findOrCreateUser($network, $user);
            $this->guard()->login($user);
            auth()->user()->tokens($network)->delete();
            return redirect(config('auth.auth.redirect') .
                auth()->user()->createToken($network)->plainTextToken);
        } catch (RequestException $e) {
            return redirect(config('auth.auth.redirect'));
        }
    }


    protected function findOrCreateUser(string $network, $user)
    {
        $oauthProvider = Network::query()->where('network', $network)
            ->where('network_user_id', $user->getId())
            ->first();

        if ($oauthProvider) {
            $oauthProvider->update([
                'access_token' => $user->token,
                'refresh_token' => $user->refreshToken,
            ]);
            return $oauthProvider->user;
        }

        if (User::query()->where('email', $user->getEmail())->exists()) {
            throw new EmailTakenException;
        }
        return $this->createUser($network, $user);
    }

    private function createUser($provider, $sUser)
    {
        $user = User::networkRegister($sUser->getName(), $sUser->getEmail());
        $this->createSocialAvatar($sUser->getAvatar(), $user, $provider);
        $user->networks()->create([
            'network' => $provider,
            'network_user_id' => $sUser->getId(),
            'access_token' => $sUser->token,
            'refresh_token' => $sUser->refreshToken,
        ]);

        return $user;
    }

    private function createSocialAvatar($sUserAvatar, $user, $provider): bool|string
    {
        $fileContents = @file_get_contents($sUserAvatar);
        $ext = '';
        if ($provider == 'facebook') {
            $ext = '.png';
        }
        if ($fileContents) {
            $advertImageStore = config('storage_avatar');
            try {
                if (!Storage::disk($advertImageStore)->exists($user->id)) {
                    Storage::disk($advertImageStore)->makeDirectory($user->id);
                }
            } catch (Exception $e) {
                $advertImageStore = env('public');
                if (!Storage::disk($advertImageStore)->exists($user->id)) {
                    Storage::disk($advertImageStore)->makeDirectory($user->id);
                }
            }
            $avatarFilename = (string)Str::uuid();
            $folderPatch = $user->id;
            $fullPatch = $folderPatch . '/' . $avatarFilename . $ext;
            $userAvatarUrl = Storage::disk($advertImageStore)->url($fullPatch);
            $user->update([
                'avatar' => $fullPatch,
                'avatar_url' => $userAvatarUrl,
                'avatar_thumbnail' => $fullPatch,
                'avatar_thumbnailUrl' => $userAvatarUrl,
            ]);
            return Storage::disk($advertImageStore)->put($fullPatch, $fileContents);
        }
        return false;
    }

}
