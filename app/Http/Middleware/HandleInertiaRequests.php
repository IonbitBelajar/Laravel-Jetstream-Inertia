<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

use App\Models\User;
use App\Models\Post;
class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        $user  = $request->user();
        return array_merge(parent::share($request), [
            'permission' => function () use ($user) {
                if (!$user) return;

                return [
                    'users' => [
                        'create' => $user->can('create', User::class),
                        'viewAny' => $user->can('viewAny', User::class),
                        'editRole' => $user->hasRole('admin'),
                    ],
                    'posts' => [
                        'create' => $user->can('create', Post::class),
                        'viewAny' => $user->can('viewAny', Post::class),
                        // 'viewAny' => $user->can('viewAny', User::class),
                    ],
                ];
            },
            'flash' => [
                'message' => fn () => $request->session()->get('message')
            ],
        ]);

        
        
       
        
    }
  
}
