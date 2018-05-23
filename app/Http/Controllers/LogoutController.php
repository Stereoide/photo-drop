<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhotoDrop;

class LogoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        PhotoDrop::logout();

        return redirect(route('login.index'));
    }
}
