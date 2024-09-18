<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\HttpResponse;

class UserController extends Controller
{
    private $httpResponse;

    public function __construct(HttpResponse $httpResponse)
    {
        $this->httpResponse = $httpResponse;
    }

    public function index()
    {
        try {
            //
            return $this->httpResponse->data([], true)->json();
        } catch (\Exception $e) {
            return $this->httpResponse->debug($e->getMessage())->json(500);
        }
    }

    public function listLimit($qtd = 1)
    {
        try {
            //
            return $this->httpResponse->data([], true)->json();
        } catch (\Exception $e) {
            return $this->httpResponse->debug($e->getMessage())->json(500);
        }
    }

    public function store(Request $request)
    {
        try {
            //
            return $this->httpResponse->data([], true)->json();
        } catch (\Exception $e) {
            return $this->httpResponse->debug($e->getMessage())->json(500);
        }
    }

    public function show(string $id)
    {
        try {
            //
            return $this->httpResponse->data([], true)->json();
        } catch (\Exception $e) {
            return $this->httpResponse->debug($e->getMessage())->json(500);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            //
            return $this->httpResponse->data([], true)->json();
        } catch (\Exception $e) {
            return $this->httpResponse->debug($e->getMessage())->json(500);
        }
    }

    public function destroy(string $id)
    {
        try {
            //
            return $this->httpResponse->data([], true)->json();
        } catch (\Exception $e) {
            return $this->httpResponse->debug($e->getMessage())->json(500);
        }
    }
}
