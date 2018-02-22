<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\Router;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 */
Router::defaultRouteClass('DashedRoute');

Router::scope('/', function ($routes) {
    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
    $routes->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);

    /**
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->fallbacks('DashedRoute');
});

    /**
     * Define API routes. Get controller names by listing a directory for 
     * controller file names, then map them using resources()
     * 2/23/2017, Tomek
     */
    Router::scope('/api', function ($routes) {
        $routes->extensions(['json']);
        $ignoreList = [
            '.', 
            '..', 
            'Component', 
            'AppController.php',
            'BakeController.php',
        ];

        $enableTruncateList = [
            'ImitsDumpMiPlans',
            'ImitsDumpMiAttempts',
            'ImitsDumpPhenotypeAttempts',
            'KompProjectsDump'
        ];

        $enableGetlastentryList = [
            'KompGenesDump',
            'KompClonesDump'
        ];

        $enableBackupMethods = [
            'sendBackup',
            'getBackupFileChecksum',
            'deleteBackups'
        ];

        $enableInjectionsMethods = [
            'getInjectionsForImits',
            'clearImitsUpdateFlag'
        ];

        $files = scandir('../src/Controller/');
        foreach($files as $f){
            if(!in_array($f, $ignoreList)) {
                //Map the route
                $controller = pathinfo($f, PATHINFO_FILENAME);
                $modelName = str_replace('Controller', '', $controller);
                $routes->resources($modelName); //Map REST route with the controller
                
                // Add truncate route in selected Models
                if (in_array($modelName, $enableTruncateList)) {
                    $routes->resources($modelName, [
                       'map' => [
                           'truncate' => [
                               'action' => 'truncate',
                               'method' => 'DELETE'
                           ]
                       ]
                    ]);
                } 

                // Add getlastentry route in selected Models
                if (in_array($modelName, $enableGetlastentryList)) {
                    $routes->resources($modelName, [
                       'map' => [
                           'getlastentry' => [
                               'action' => 'getlastentry',
                               'method' => 'GET'
                           ]
                       ]
                    ]);
                }

                // Enable backup methods in DbBackupController.php
                foreach ($enableBackupMethods as $methodName) {
                    $routes->resources('DbBackup', [
                       'map' => [
                           $methodName.'/*' => [ //the '/*' allows passing parameters (all types, including strings) to the controller's method, use ':id' to allow ints only
                               'action' => $methodName,
                               'method' => 'GET'
                           ]
                       ]
                    ]);
                }

                // Enable iMits methods in InjectionsController.php
                foreach ($enableInjectionsMethods as $methodName) {
                    $routes->resources('Injections', [
                       'map' => [
                           $methodName.'/*' => [ //the '/*' allows passing parameters (all types, including strings) to the controller's method, use ':id' to allow ints only
                               'action' => $methodName,
                               'method' => 'GET'
                           ]
                       ]
                    ]);
                }

            } //end if !in_array
        } //end foreach
    }); //end Router::scope()

/**
 * Load all plugin routes.  See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();
