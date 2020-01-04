<?php namespace Bedard\RainLabBlogApi;

use Backend;
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
            'name'        => 'RainLabBlogApi',
            'description' => 'No description provided yet...',
            'author'      => 'Bedard',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'Bedard\RainLabBlogApi\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'bedard.rainlabblogapi.some_permission' => [
                'tab' => 'RainLabBlogApi',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'rainlabblogapi' => [
                'label'       => 'RainLabBlogApi',
                'url'         => Backend::url('bedard/rainlabblogapi/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['bedard.rainlabblogapi.*'],
                'order'       => 500,
            ],
        ];
    }
}
