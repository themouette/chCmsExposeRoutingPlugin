<?php

include dirname(__FILE__).'/../bootstrap/functional.php';

$browser = new sfTestFunctional(new sfBrowser());

$browser
  ->info("check default config")
    ->get('/js/app/routes.js')
    
    //check routing is OK
    ->with('request')->begin()
      ->isMethod('get')
      ->isParameter('module', 'chCmsExposeRouting')
      ->isParameter('action', 'index')
    ->end()
    
    // check the response
    ->with('response')->begin()
      ->isStatusCode(200)
      ->isHeader('content-type', 'application/javascript')
      ->matches('/'.preg_quote('Routing.prefix = "\/index.php";', '/').'/')
      ->matches('/'.preg_quote('Routing.variablePrefix = [":"]; ', '/').'/')
      ->matches('/'.preg_quote('Routing.variableSuffix = ""; ', '/').'/')
      ->matches('/'.preg_quote('Routing.segmentSeparators = ["\/","."]; ', '/').'/')
      ->matches('/'.preg_quote('Routing.defaults = {"sf_culture":"en"}; ', '/').'/')
      ->matches('/'.preg_quote('Routing.connect("exposed_route", "\/exposed", []);', '/').'/')
      ->matches('/'.preg_quote('Routing.connect("default", "\/:module\/:action\/*", []);', '/').'/')
      ->matches('/'.preg_quote('Routing.connect("default_index", "\/:module", {"foo":"bar"});', '/').'/')
      ->matches('!/private_route/')
    ->end()
    // end of get /js/app/routes.js
    ->get('/')
    
    //check routing is OK
    ->with('request')->begin()
      ->isMethod('get')
      ->isParameter('module', 'default')
      ->isParameter('action', 'index')
    ->end()
    
    // check the response
    ->with('response')->begin()
      ->isStatusCode(200)
      ->isValid()
      ->checkElement('head script[src=/index.php/js/app/routes.js]', 1)
      ->checkElement('head script[src=/chCmsExposeRoutingPlugin/js/routing.js]', 1)
    ->end()
    // end of get /
  // end of block check url is accessible
;

//change environment
$configuration = ProjectConfiguration::getApplicationConfiguration($app, 'test_without_auto_discover',isset($debug) ? $debug : true, $rootdir);
sfContext::createInstance($configuration);
$browser = new sfTestFunctional(new sfBrowser());

$browser
  ->info("check with auto_discover to off")
    ->get('/js/app/routes.js')
    
    // check the response
    ->with('response')->begin()
      ->isStatusCode(200)
      ->isHeader('content-type', 'application/javascript')
      ->matches('!/exposed_route/')
    ->end()
    // end of get /js/app/routes.js
  // end of block check with auto_discover to off
;

//change environment
$configuration = ProjectConfiguration::getApplicationConfiguration($app, 'test_without_auto_register',isset($debug) ? $debug : true, $rootdir);
sfContext::createInstance($configuration);
$browser = new sfTestFunctional(new sfBrowser());

$browser
  ->info("check with no_register_routes")
    ->get('/js/app/routes.js')
    
    //check routing is OK
    ->with('request')->begin()
      ->isMethod('get')
    ->end()
    
    // check the response
    ->with('response')->begin()
      ->isStatusCode(404)
    ->end()
    // end of get /js/app/routes.js

    ->get('/')
    
    //check routing is OK
    ->with('request')->begin()
      ->isMethod('get')
      ->isParameter('module', 'default')
      ->isParameter('action', 'index')
    ->end()
    
    // check the response
    ->with('response')->begin()
      ->isStatusCode(200)
      ->isValid()
      ->checkElement('head script[src=/index.php/js/app/routes.js]', 0)
      ->checkElement('head script[src=/chCmsExposeRoutingPlugin/js/routing.js]', 0)
    ->end()
    // end of get /
  // end of block check with no_register_routes
;

//change environment
$configuration = ProjectConfiguration::getApplicationConfiguration($app, 'test_with_custom_blacklist',isset($debug) ? $debug : true, $rootdir);
sfContext::createInstance($configuration);
$browser = new sfTestFunctional(new sfBrowser());

$browser
  ->info("check with params_blacklist")
    ->get('/js/app/routes.js')
    // check the response
    ->with('response')->begin()
      ->isStatusCode(200)
      ->isHeader('content-type', 'application/javascript')
      ->matches('!/exposed_route/')
      ->matches('/'.preg_quote('Routing.connect("default_index", "\/:module", {"action":"index"});', '/').'/')
    ->end()
;
// vim: ft=symfony.php.sftest
