<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StripeWebHookController extends Controller
{
    //

    public function __invoke(Request $request)
    {
        $payload = json_decode($request->getContent(), true);
        $method = 'handle' . Str::studly(str_replace('.', '_', $payload['type']));

        if (method_exists($this, $method)){
            return $this->{$method}($payload);
        }
    }

    protected function handlePaymentIntentSucceeded($payload){
        \Log::info($payload);
    }
}
