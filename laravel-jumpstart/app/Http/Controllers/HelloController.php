<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelloController extends Controller
{
    public function greet()
{
$name = "Developer";
return view('greeting', ['name' => $name]);
}
}