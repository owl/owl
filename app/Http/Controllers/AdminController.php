<?php namespace Owl\Http\Controllers;

class AdminController extends Controller
{
    public function index()
    {
        return \View::make('manage.index');
    }
}
