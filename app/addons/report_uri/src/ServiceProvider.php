<?php

namespace Tygh\Addons\ReportUri;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider
 *
 * @package Tygh\Addons\ReportUri
 */
class ServiceProvider implements ServiceProviderInterface
{
    /**
     * @inheritDoc
     */
    public function register(Container $pimple)
    {
        $pimple['addons.report_uri.service'] = function () {
            return new Service();
        };
    }
}