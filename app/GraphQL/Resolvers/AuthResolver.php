<?php
namespace App\GraphQL\Resolvers;

use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;


class AuthResolver
{
    public function login($rootValue, array $args, GraphQLContext $context)
    {
        $input = $args['input'];
        $credentials = [
            'email' => $input['email'],
            'password' => $input['password'],
        ];
        
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('Personal Access Token')->accessToken;

            return [
                'token' => $token,
                'user' => $user,
            ];
        }
        return null; // or handle unsuccessful login
    }

    public function logout($rootValue, array $args, GraphQLContext $context)
    {
        $user = $context->user();

        if($user){
            $accessToken = $user->token();
            $refreshToken = $accessToken->refreshToken;
    
            // Revoke the access token
            $accessToken->revoke();
    
            // Revoke the refresh token if present
            if ($refreshToken) {
                $refreshToken->revoke();
            }
            return array(
                'user'=>$user,
                'code'=>'success',
                'message' => 'Logged out successfully'
            );
        }else{
            return array(
                'user'=>null,
                'code'=>'error',
                'message' => 'Authenticted user not found!'
            );
        }
        
        
    }
}
