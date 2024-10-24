<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

class TesteController extends Controller
{
    public function teste()
    {
        return response()->json(['message' => 'success'], 200);
    }
}
