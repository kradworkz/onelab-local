<?php

namespace App\Providers;

use View;
use App\Models\Agency;
use Illuminate\Support\ServiceProvider;

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
        $agency_id = config('app.agency');
        $agency = Agency::where('id',$agency_id)->first();
      
        View::share('agency',$agency);

        // Activity::saving(function (Activity $activity) {
        //     $activity->properties = $activity->properties->put('agent', [
        //         'ip' => Request::ip(),
        //         'url' => Request::fullUrl(),
        //     ]);
        // });

        \Validator::extend('image64', function ($attribute, $value, $parameters, $validator) {
            if($value != null){
                $type = explode('/', explode(':', substr($value, 0, strpos($value, ';')))[1])[1];
                if (in_array($type, $parameters)) {
                    return true;
                }
                return false;
            }
        });
    
        \Validator::replacer('image64', function($message, $attribute, $rule, $parameters) {
            return str_replace(':values',join(",",$parameters),$message);
        });
    }
}
