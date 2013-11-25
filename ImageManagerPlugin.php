<?php
/**
 * Image Manager
 *
 * @copyright Libis (libis.be)
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 */

//require_once dirname(__FILE__) . '/helpers/ImageManagerFunctions.php';

/**
 * Image Manager plugin.
 */
class ImageManagerPlugin extends Omeka_Plugin_AbstractPlugin
{
    /**
     * @var array Hooks for the plugin.
     */
    protected $_hooks = array('install', 'uninstall','initialize',
        'define_routes', 'config_form', 'config','admin_head');

    /**
     * @var array Filters for the plugin.
     */
    protected $_filters = array('admin_navigation_main');

     /**
     * Install the plugin.
     */
    public function hookInstall()
    {
        
    }

    /**
     * Uninstall the plugin.
     */
    public function hookUninstall()
    {        
        
    }


    /**
     * Add the translations.
     */
    public function hookInitialize()
    {
        add_translation_source(dirname(__FILE__) . '/languages');
        get_view()->addHelperPath(dirname(__FILE__) . '/views/helpers', 'ImageManager_View_Helper_');
    }

     /**
     * Add the routes for accessing simple pages by slug.
     * 
     * @param Zend_Controller_Router_Rewrite $router
     */
    public function hookDefineRoutes($args)
    {
        // Add custom routes based on the page slug.
        $router = $args['router'];
	$router->addRoute(
	    'image-manager', 
	    new Zend_Controller_Router_Route(
	       "image-manager/", 
	        array('module' => 'image-manager')
	    )
	);
        
        $router = $args['router'];
	$router->addRoute(
	    'image-manager/connector', 
	    new Zend_Controller_Router_Route(
	       "image-manager/connector", 
	        array('module' => 'image-manager',
                      'controller' => 'index',
                      'action' => 'connector'
                    )
	    )
	);
    }
    
    public function hookAdminHead(){        
        //css
        queue_css_url('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/themes/smoothness/jquery-ui.css');
        queue_css_file('theme');
        queue_css_file('elfinder.min');
        //js
        //queue_js_url("http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.js");
        queue_js_file('elFinder/js/elFinder.min');        
    }

    /**
     * Display the plugin config form.
     */
    public function hookConfigForm()
    {
        require dirname(__FILE__) . '/config_form.php';
    }

    /**
     * Set the options from the config form input.
     */
    public function hookConfig()
    {
        set_option('simple_pages_filter_page_content', (int)(boolean)$_POST['simple_pages_filter_page_content']);
    }

   
    /**
     * Add the Image Manager link to the admin main navigation.
     * 
     * @param array Navigation array.
     * @return array Filtered navigation array.
     */
    public function filterAdminNavigationMain($nav)
    {
        $nav[] = array(
            'label' => __('Image Manager'),
            'uri' => url('image-manager')            
        );
        return $nav;
    }    
}
