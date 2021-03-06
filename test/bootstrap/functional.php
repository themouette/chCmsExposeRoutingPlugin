<?php

include(dirname(__FILE__).'/sf_test_lib.inc');

if (!isset($_SERVER['SYMFONY']))
{
  $_SERVER['SYMFONY'] = '../../lib/vendor/symfony/lib/';
}

if (!isset($app))
{
  $app = 'frontend';
}

if (!isset($rootdir))
{
  $rootdir = dirname(__FILE__).'/../fixtures/project/';
}

require_once $_SERVER['SYMFONY'].'/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

function chCmsExposeRoutingPlugin_cleanup()
{
  sfToolkit::clearDirectory(dirname(__FILE__).'/../fixtures/project/cache');
  sfToolkit::clearDirectory(dirname(__FILE__).'/../fixtures/project/log');
}
chCmsExposeRoutingPlugin_cleanup();
register_shutdown_function('chCmsExposeRoutingPlugin_cleanup');

require_once dirname(__FILE__).'/../fixtures/project/config/ProjectConfiguration.class.php';
$configuration = ProjectConfiguration::getApplicationConfiguration($app, 'test', isset($debug) ? $debug : true, $rootdir);
sfContext::createInstance($configuration);
