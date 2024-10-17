<?php

namespace App\Http\Controllers;


use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\Exceptions\OAuthServerException as passportOAuthServerException;
use Laravel\Passport\Http\Controllers\AccessTokenController as ATC;
use League\OAuth2\Server\Exception\OAuthServerException;
use Psr\Http\Message\ServerRequestInterface;
use Response;

class AuthController extends ATC
{
    public function login(ServerRequestInterface $request)
    {
        //generate token
        $tokenResponse = parent::issueToken($request);

        //convert response to json string
        $content = $tokenResponse->getContent();

        //convert json to array
        $data = json_decode($content, true);
     
        if (isset($data["error"]))
            throw new OAuthServerException('The user credentials were incorrect.', 6, 'invalid_grant', 401);
        return Response::json($data);
    }
}