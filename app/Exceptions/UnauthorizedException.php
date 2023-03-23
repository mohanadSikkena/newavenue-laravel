<?php

namespace App\Exceptions;

use Exception;

class UnauthorizedException extends Exception
{
    //
    public function render($request)
{
    return response()->json([
        'message' => 'You are not authorized to access this resource.'
    ], 401);
}

}
