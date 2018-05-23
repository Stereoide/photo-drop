<?php

namespace App\Http\Controllers;

use App\Exceptions\LoginFailedException;
use App\Http\Requests\LoginFormRequest;
use Illuminate\Http\Request;
use PhotoDrop;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* Determine whether the current user is already logged in */

        $user = PhotoDrop::getLoggedInUser();

        if (!is_null($user)) {
            return redirect(route('photos.index'));
        }

        /* Redirect to create method */

        return redirect(route('login.create'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.login.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\LoginFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LoginFormRequest $request)
    {
        $token = $request->input('token');

        PhotoDrop::login($token);

        return redirect(route('photos.index'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\LoginFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function prefill(string $token)
    {
        PhotoDrop::login($token);

        return redirect(route('photos.index'));
    }
}
