<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExampleController extends Controller
{
    public function homepage () {
        $ourName = 'Lars';
        $animals = ['Latte', 'Kitkat', 'Nugget'];
        return view('homepage', ['allAnimals' => $animals, 'name' => $ourName, 'catname' => 'Latte']);
    }

    public function aboutPage () {
        return view('single-post');
    }
}
