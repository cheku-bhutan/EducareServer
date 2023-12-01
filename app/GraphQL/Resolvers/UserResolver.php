<?php
namespace App\GraphQL\Resolvers;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Hash;

class UserResolver
{
    public function createUser($rootValue, array $args)
    {
        $input = $args['input'];

        $user = new User([
            'user_id' => $input['user_id'],
            'email' => $input['email'],
            'mobile_no' => $input['mobile_no'],
            'password' => $input['password'],
        ]);
        
        $user->save();

        $profile = new UserProfile([
            'name' => $input['name'],
            'profile_picture' => $input['profile_picture'],
        ]);
        $user->profile()->save($profile);
        return $user;
    }

    public function deleteUser($rootValue, array $args)
    {
        $id = $args['id'];

        $user = User::find($id);
        
        $user->softDelete($id);

        return $user;
    }

    public function changePassword($rootValue, array $args)
    {
        $input = $args['input'];

        $user = User::where('email', $input['email'])->first();
        
        if(!$user){
            return array(
                'code' => "error",
                'message' => "User with given email not found"
            );
        }else{
            $user->password = Hash::make($input['new_password']);
            $user->save();
            return array(
                'code' => "success",
                'message' => "Password updated Succesfully"
            );
        }
    }
}