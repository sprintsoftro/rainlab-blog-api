<?php

namespace Bedard\RainLabBlogApi;

use System\Classes\PluginBase;

/**
 * RainLabBlogApi Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'author'      => 'Scott Bedard',
            'description' => 'A simple and extendable HTTP API for RainLab.Blog',
            'homepage'    => 'https://github.com/scottbedard/rainlab-blog-api',
            'icon'        => 'icon-pencil',
            'name'        => 'RainLab.Blog API',
        ];
    }
}
