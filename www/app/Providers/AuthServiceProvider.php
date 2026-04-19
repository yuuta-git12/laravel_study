<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Admin;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('example-com-user', function(Admin $admin){    // 第一引数:ゲート名、第二引数コールバック関数
            // IDのドメインがexample.comかどうか
            return substr($admin->login_id, -11) === 'example.com';
        });
    }
}
