<?php

namespace App\Http\Controllers;

use App\Helpers\HttpResponse;

class AuthController extends Controller
{
    private $httpResponse;

    public function __construct(HttpResponse $httpResponse)
    {
        $this->httpResponse = $httpResponse;
    }

    public function unauthorized()
    {
        return $this->httpResponse->json(401);
    }
}
