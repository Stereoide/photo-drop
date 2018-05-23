<?php

namespace App\Http\Controllers;

use App\Exceptions\UserNotLoggedInException;
use Illuminate\Http\Request;
use App\Photo;
use App\User;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use App\Exceptions\LoginFailedException;
use PhotoDrop;
use Illuminate\Support\Facades\Session;

class PhotoDropApiController extends Controller
{
    public function assertUserIsLoggedIn()
    {
        if (is_null(PhotoDrop::getLoggedInUser())) {
            throw new UserNotLoggedInException();
        }
    }

    public function createUser($name, $email, $token = null)
    {
        /* Generate token if necessary */

        $token = $token ?? PhotoDrop::generateRandomToken();

        /* Create user */

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'token' => $token,
        ]);

        return $user;
    }

    public function generateRandomToken()
    {
        $isUnique = false;

        while (!$isUnique) {
            try {
                $token = Uuid::uuid4()->toString();

                $matchingUsers = User::where('token', $token)->get();
                $isUnique = $matchingUsers->isEmpty();
            } catch (UnsatisfiedDependencyException $e) {
                echo 'Caught exception: ' . $e->getMessage() . "\n";
            }
        }

        return $token;
    }

    public function getLoggedInUser()
    {
        $userId = Session::get('login.user-id');

        if (is_null($userId)) {
            return null;
        }

        /* Try to fetch the logged in user */

        $user = User::findOrFail($userId);

        return $user;
    }

    public function getUserByToken(string $token)
    {
        return User::where('token', $token)->first();
    }

    public function isValidLogin(string $token)
    {
        $user = PhotoDrop::getUserByToken($token);
        return !is_empty($user);
    }

    public function login(string $token)
    {
        $user = PhotoDrop::getUserByToken($token);
        if (is_null($user)) {
            throw new LoginFailedException($token . ' is not a valid token');
        }

        Session::put('login.user-id', $user->id);
    }

    public function logout()
    {
        Session::forget('login.user-id');
    }
}
