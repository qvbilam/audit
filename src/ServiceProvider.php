<?php

/*
 * This file is part of the qvbilam/audit
 *
 * (c) qvbilam <qvbilam@163.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Qvbilam\Audit;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton(Audit::class, function () {
            return new Audit(config('services.audit.key'), config('services.audit.app_id'));
        });

        $this->app->alias(Audit::class, 'audit');
    }

    /**
     * @return string[]
     */
    public function provides()
    {
        return [Audit::class, 'audit'];
    }
}
