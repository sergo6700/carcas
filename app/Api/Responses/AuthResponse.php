<?php

namespace Api\Responses;

/**
 * Class AuthResponse
 * @package Api\Responses
 */
class AuthResponse extends BaseApiResponse
{
    /**
     * @param $content
     * @return \Illuminate\Http\Response
     */
    public function make($content)
    {
        return parent::make([
            'type' => 'Bearer',
            'token' => $content['access_token'],
            'expiresIn' => $content['expires_in'],
            'expiresAt' => $content['expires_in'] + time(),
            'refreshToken' => $content['refresh_token'],
            'refreshExpiresAt' => config('api.auth.rememberExpire') + time(),
        ]);
    }
}