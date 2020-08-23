<?php

namespace Tygh\Addons\ReportUri;

use Tygh\Registry;

/**
 * Class UriReporter
 *
 * @package Tygh\Addons\ReportUri
 */
class Service
{
    /**
     * @var array reporting configuration with the according url
     */
    private $reportingConfig = [
        "group" => "default",
        "max_age" => 31536000,
        "endpoints" => [],
        "include_subdomains" => true
    ];

    /**
     * @var array holds the network error logging config
     */
    private $networkErrorLoggingConfig = [
        "report_to" => "default",
        "max_age" => 31536000,
        "include_subdomains" => true
    ];

    /**
     * @hook before_dispatch
     */
    public function onDispatchHandler()
    {
        if ($report_endpoint = Registry::get('addons.report_uri.reporting_endpoint')) {
            $this->reportingConfig['endpoints'][] = ['url' => $report_endpoint];
            header(sprintf("Report-To: %s", json_encode($this->reportingConfig)));
        }

        if (Registry::get('addons.report_uri.network_error_logging') === 'Y')
            header(sprintf("NEL: %s", json_encode($this->networkErrorLoggingConfig)));

        if ($content_security_policy = Registry::get('addons.report_uri.content_security_policy'))
            header(sprintf("Content-Security-Policy: frame-ancestors 'self'; report-uri %s", $content_security_policy));
    }
}