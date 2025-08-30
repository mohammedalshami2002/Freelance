<?php

namespace App\Traits;

trait UserRedirectTrait
{

    public function redirectUserByType($user)
    {
        switch ($user->type_user) {
            case 'admin':
                return redirect()->route('dashboard');


            case 'client':
                return redirect()->route('Client.dashboard');


            case 'service_provider':
                return redirect()->route('service_provider.dashboard');


            default:
                return redirect()->route('home'); 
        }
    }
}
