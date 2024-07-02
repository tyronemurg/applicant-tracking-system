<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\JobOpenings;
use App\Models\Departments;
use App\Models\JobCandidates;
use App\Policies\JobOpeningsPolicy;
use App\Policies\JobCandidatesPolicy;
use App\Policies\DepartmentsPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        JobOpenings::class => JobOpeningsPolicy::class,
        JobCandidates::class => JobCandidatesPolicy::class,
        Departments::class => DepartmentsPolicy::class,
        AuthenticationLog::class => AuthenticationLogPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {

        $this->registerPolicies();
        //
        /* Bypass Policy for Candidate Portal User */

        Gate::before(function ($user, $ability, $model) {
            if (\auth()->guard('candidate_web')->check()) {
                return true;
            }

            return null;
        });

        Gate::before(function (User $user, string $ability) {
          //  dd($user->isSuperAdmin());
            return $user->isSuperAdmin() ? true : null;
        });

        Gate::before(function ($user, $ability) {
           // dd($user->hasRole('Administrator'));
           $user = auth()->user();
            if($user->hasRole('Administrator')){
                Gate::before(function (User $user, string $ability) {
                    //dd($user);
                      return true ;
                  });
               // return $user->hasRole('Administrator') ? true : null;
            }
           
        });

        // $role = Role::where(['name' => 'Administrator'])->first();
        //     $permissions = Permission::query();
        //     $excludedPermission = ['impersonate'];
        //     foreach ($excludedPermission as $value) {
        //         $permissions = $permissions->where('name', 'not like', '%'.$value);
        //     }

        //     $role->givePermissionTo($permissions->get('name')->toArray());


        //  Gate::before(function ($user, $ability) use ($excludedPermission) { 
        //     // Check if the user has the 'Admin' role
        //     if ($user->hasRole('Administrator')) { 
        //         // If the ability is in the excluded permissions, deny it by returning null
        //         if (in_array($ability, $excludedPermission)) { return null; } // Otherwise, allow it
        //         return true; } 
        //         // Continue with normal permission checks
        //         return null; });

    }
}
