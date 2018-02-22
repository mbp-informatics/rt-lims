<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.8
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Configure paths required to find CakePHP + general filepath
 * constants
 */
require __DIR__ . '/paths.php';

// Use composer to load the autoloader.
require ROOT . DS . 'vendor' . DS . 'autoload.php';

/**
 * Bootstrap CakePHP.
 *
 * Does the various bits of setup that CakePHP needs to do.
 * This includes:
 *
 * - Registering the CakePHP autoloader.
 * - Setting the default application paths.
 */
require CORE_PATH . 'config' . DS . 'bootstrap.php';

// You can remove this if you are confident you have intl installed.
if (!extension_loaded('intl')) {
    trigger_error('You must enable the intl extension to use CakePHP.', E_USER_ERROR);
}

use Cake\Cache\Cache;
use Cake\Console\ConsoleErrorHandler;
use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;
use Cake\Core\Plugin;
use Cake\Database\Type;
use Cake\Datasource\ConnectionManager;
use Cake\Error\ErrorHandler;
use Cake\Log\Log;
use Cake\Mailer\Email;
use Cake\Network\Request;
use Cake\Routing\DispatcherFactory;
use Cake\Utility\Inflector;
use Cake\Utility\Security;
use Cake\I18n\Time;

/**
 * Read configuration file and inject configuration into various
 * CakePHP classes.
 *
 * By default there is only one configuration file. It is often a good
 * idea to create multiple configuration files, and separate the configuration
 * that changes from configuration that does not. This makes deployment simpler.
 */
try {
    Configure::config('default', new PhpConfig());
    Configure::load('app', 'default', false);
} catch (\Exception $e) {
    die($e->getMessage() . "\n");
}

// Load an environment local configuration file.
// You can use a file like app_local.php to provide local overrides to your
// shared configuration.
//Configure::load('app_local', 'default');

// When debug = false the metadata cache should last
// for a very very long time, as we don't want
// to refresh the cache while users are doing requests.
if (!Configure::read('debug')) {
    Configure::write('Cache._cake_model_.duration', '+1 years');
    Configure::write('Cache._cake_core_.duration', '+1 years');
}

/**
 * Set server timezone to UTC. You can change it to another timezone of your
 * choice but using UTC makes time calculations / conversions easier.
 */
// date_default_timezone_set('UTC');
date_default_timezone_set('America/Los_Angeles');

/**
 * Configure the mbstring extension to use the correct encoding.
 */
mb_internal_encoding(Configure::read('App.encoding'));

/**
 * Set the default locale. This controls how dates, number and currency is
 * formatted and sets the default language to use for translations.
 */
ini_set('intl.default_locale', 'en_US');

/**
 * Register application error and exception handlers.
 */
$isCli = php_sapi_name() === 'cli';
if ($isCli) {
    (new ConsoleErrorHandler(Configure::read('Error')))->register();
} else {
    (new ErrorHandler(Configure::read('Error')))->register();
}

// Include the CLI bootstrap overrides.
if ($isCli) {
    require __DIR__ . '/bootstrap_cli.php';
}

/**
 * Set the full base URL.
 * This URL is used as the base of all absolute links.
 *
 * If you define fullBaseUrl in your config file you can remove this.
 */
if (!Configure::read('App.fullBaseUrl')) {
    $s = null;
    if (env('HTTPS')) {
        $s = 's';
    }

    $httpHost = env('HTTP_HOST');
    if (isset($httpHost)) {
        Configure::write('App.fullBaseUrl', 'http' . $s . '://' . $httpHost);
    }
    unset($httpHost, $s);
}

Cache::config(Configure::consume('Cache'));
ConnectionManager::config(Configure::consume('Datasources'));
Email::configTransport(Configure::consume('EmailTransport'));
Email::config(Configure::consume('Email'));
Log::config(Configure::consume('Log'));
Security::salt(Configure::consume('Security.salt'));

/**
 * The default crypto extension in 3.0 is OpenSSL.
 * If you are migrating from 2.x uncomment this code to
 * use a more compatible Mcrypt based implementation
 */
// Security::engine(new \Cake\Utility\Crypto\Mcrypt());

/**
 * Setup detectors for mobile and tablet.
 */
Request::addDetector('mobile', function ($request) {
    $detector = new \Detection\MobileDetect();
    return $detector->isMobile();
});
Request::addDetector('tablet', function ($request) {
    $detector = new \Detection\MobileDetect();
    return $detector->isTablet();
});

/**
 * Custom Inflector rules, can be set to correctly pluralize or singularize
 * table, model, controller names or whatever other string is passed to the
 * inflection functions.
 *
 * Inflector::rules('plural', ['/^(inflect)or$/i' => '\1ables']);
 * Inflector::rules('irregular', ['red' => 'redlings']);
 * Inflector::rules('uninflected', ['dontinflectme']);
 * Inflector::rules('transliteration', ['/å/' => 'aa']);
 */

/**
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. make sure you read the documentation on Plugin to use more
 * advanced ways of loading plugins
 *
 * Plugin::loadAll(); // Loads all plugins at once
 * Plugin::load('Migrations'); //Loads a single plugin named Migrations
 *
 */

Plugin::load('Migrations');
Plugin::load('Bootstrap', ['bootstrap' => true]);

// Only try to load DebugKit in development mode
// Debug Kit should not be installed on a production system
if (Configure::read('debug')) {
    Plugin::load('DebugKit', ['bootstrap' => true]);
}

/**
 * Connect middleware/dispatcher filters.
 */
DispatcherFactory::add('Asset');
DispatcherFactory::add('Routing');
DispatcherFactory::add('ControllerFactory');

/**
 * Enable default locale format parsing.
 * This is needed for matching the auto-localized string output of Time() class when parsing dates.
 */

/* Setting the Locale Parser to null allows Cake to accept yyyy-mm-dd date string produced by jQuery datepicker */
Type::build('date')->useLocaleParser(null); 
Type::build('datetime')->useLocaleParser();


/** !! IMPORTANT !! 
  * The below configuration constants are used to define constraints on the built-int 'list' finder -
  * namely $query->find('list') - used in dropdowns. It was necessary, because the return sets
  * were so large, they were slowing down the site significantly. To disable these constraints,
  * comment out configuration writes below. 
  *
  * Note: To make this work, I modified core cake file at vendor/cakephp/cakephp/src/ORM/Table.php
  * -Tomek, 10/20/2016
 */
define('LISTLIMIT', 1000);
define('LISTORDER', 'DESC');

/** Audit (change) Log 
  * It fires on beforeSave event and logs any edits made to an entity to 'change_log'
  * table. Data is PHP serialized. It also fires on beforeDelete event to log deletions.
  * If there are no differences between old and new version, nothing is logged.
  * This also does NOT handle adding new entities. -Tomek, 10/20/2016
 */
use Cake\Event\EventListenerInterface;
use Cake\ORM\TableRegistry;
class ChangeLogListener implements EventListenerInterface
{
    public function implementedEvents()
    {
        return array(
            'Model.beforeSave' => 'beforeSaveEvent',
            'Model.beforeDelete' => 'beforeDeleteEvent',
        );
    }

    private function getUserInfo()
    {
            $userInfo['id'] = $_SESSION['Auth']['User']['id'];
            $userInfo['role'] = $_SESSION['Auth']['User']['role']['name'];
            $userInfo['username'] = $_SESSION['Auth']['User']['username'];
            $userInfo['email'] = $_SESSION['Auth']['User']['email'];
            return $userInfo;
    }

    public function beforeDeleteEvent($event, $entity, $associations)
    {
        if (defined('APIREQUEST')) { return; } //don't log api requests
        $table = $event->subject();
        $newEntity = $entity->toArray();
        if (isset($newEntity['id'])) {
            $oldEntity = $table->get($newEntity['id'])->toArray();
        } else {
            return;
        }

        $connection = ConnectionManager::get('default');
        $results = $connection
            ->execute('
                INSERT INTO change_log (user_info, table_alias, entity_id, change_date, old_entity, deletion) 
                VALUES (:user_info, :table_alias, :entity_id, :change_date, :old_entity, :deletion)
                ', [
                    'user_info' => serialize($this->getUserInfo()),
                    'table_alias' => $table->alias(),
                    'entity_id' => $newEntity['id'],
                    'change_date' => date("Y-m-d H:i:s"),
                    'old_entity' => serialize($oldEntity),
                    'deletion' => 1
                    ]
            );
    }

    public function beforeSaveEvent($event, $entity, $associations)
    {
        if (defined('APIREQUEST')) { return; } //don't log api requests
        $table = $event->subject();
        $tableAlias = $table->alias();
        $newEntity = $entity->toArray();
        $connection = ConnectionManager::get('default');

        if (isset($newEntity['id'])) { // edit() action
            $oldEntity = $table->get($newEntity['id'])->toArray();            
        } else { // add() action
            $oldEntity = null;
            /* Since we're adding a new row, we don't have its id yet.
             */
            $raw_table_name = Inflector::tableize($tableAlias);
            $raw_table_name  = str_replace('_dumps', '_dump', $raw_table_name); //didn't follow Cake conventios for komp_xxx_dump (singular, should be plural) tables so need to do this here now
            $raw_table_name  = str_replace('resuses', 'resus', $raw_table_name); //special case: embryo_resus model
            if ( $raw_table_name == 'requests' || $raw_table_name == 'panels' ) { return; } //debug.Kit tables
            $results = $connection
                ->execute("SELECT `AUTO_INCREMENT` as id FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = '$raw_table_name'")
                ->fetch('assoc');
            $newRecordId = (int) $results['id'];
        }

        if ($oldEntity) { //compare fields only if edit()
            foreach ($newEntity as $fieldName => $val) {
                if (!isset($oldEntity[$fieldName])) {
                    $oldEntity[$fieldName] = '';
                }
                    if ($fieldName == 'created' || $fieldName == 'modified') {
                     continue; //skip meta dates when comparing fields
                    }
                    if (is_array($val) ) {
                        continue; //skip arrays (containable models)
                    }
                    if ($newEntity[$fieldName] != $oldEntity[$fieldName]) {
                        $changes[$fieldName] = ['old_value' => (array) $oldEntity[$fieldName], 'new_value' => (array) $newEntity[$fieldName]];
                    }
            } //end foreach
        }

        //Nothing has changed, stop now (unless it's an edit() action)
        if ($oldEntity) {
            if (!isset($changes)) { return; }
        }
        
        $changeLog = [];
        $changeLog['user_info'] = serialize($this->getUserInfo());
        $changeLog['table_alias'] = $tableAlias;
        $changeLog['entity_id'] = isset($newEntity['id']) ? $newEntity['id'] : $newRecordId; //edit() vs add()
        $changeLog['changes'] =  isset($changes) ? serialize($changes) : null;
        $changeLog['change_date'] = date("Y-m-d H:i:s");
        $changeLog['old_entity'] = $oldEntity ? serialize($oldEntity) : serialize($newEntity); //edit() vs add() NOTE: If it's addition, then old_entity db field is storing new entity
        $changeLog['addition'] = !$oldEntity ? 1 : null; //edit() vs add()
        
        $results = $connection
            ->execute('
                INSERT INTO change_log (user_info, table_alias, entity_id, changes, change_date, old_entity, addition) 
                VALUES (:user_info, :table_alias, :entity_id, :changes, :change_date, :old_entity, :addition)
                ', [
                    'user_info' => $changeLog['user_info'],
                    'table_alias' => $changeLog['table_alias'],
                    'entity_id' => $changeLog['entity_id'],
                    'changes' => $changeLog['changes'],
                    'change_date' => $changeLog['change_date'],
                    'old_entity' => $changeLog['old_entity'],
                    'addition' => $changeLog['addition']
                    ]
            );
    } //end function beforeSaveEvent()
} //end class ChangeLogListener


/** User ID logging 
  * This event fires on beforeMarshal event and patches data object 
  * with currently logged in user id. Thanks to this all saves include 
  * the user id. Make sure though that every table has user_id field! 
  * - Tomek, 10/20/2016
 */
use Cake\Event\Event;
class ModelBeforeMarshalListener implements EventListenerInterface
{
    public function implementedEvents()
    {
        return array(
            'Model.beforeMarshal' => 'beforeMarshalEvent',
        );
    }
    public function beforeMarshalEvent(Event $event, ArrayObject $data, ArrayObject $options)
    { 
        $params = explode('/', $_SERVER['REQUEST_URI']);
        $action = isset($params[2]) ?  $params[2] : null;
        //Don't save user id on edit - this is logged in change log
        if ($action == 'add' || defined('APIREQUEST')) {
            $data['user_id'] = isset($_SESSION['Auth']['User']['id']) ?  $_SESSION['Auth']['User']['id'] : 'null';
        }
    }
}

/* Attach the listeners to the EventManager */
use Cake\Event\EventManager;
$ChangeLogListener = new ChangeLogListener();
$beforeMarshalListener = new ModelBeforeMarshalListener();
EventManager::instance()->attach($ChangeLogListener);
EventManager::instance()->attach($beforeMarshalListener);
Plugin::load('DebugKit');
