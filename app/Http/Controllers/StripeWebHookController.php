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

        \Log::info($method);
    }

    protected function handePaymentIntentSucceeded(){
        \Log::info('handled');
    }
}
