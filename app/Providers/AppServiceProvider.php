<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate; 
use App\Models\User;
use Inertia\Inertia;
use Auth;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //bypass policy
       Gate::before(function (User $user, $ability){
                if ($user->hasRole('admin')) {
                    // dd('w');
                    return true;

                }
       });

       Inertia::share('auth.user', function (){
        return[
            'auth_user' => Auth::id(),
        ];
    });

    }
}
