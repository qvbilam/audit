<?php
declare(strict_types=1);

namespace Qvbilam\Audit;


class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton(Audit::class, function(){
            return new Audit(config('services.audit.key'), config("services.audit.app_id"));
        });

        $this->app->alias(Audit::class, 'audit');
    }

    public function provides(): array
    {
        return [Audit::class, 'audit'];
    }
}