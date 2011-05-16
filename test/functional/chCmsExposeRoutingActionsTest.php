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
      ->contains('Routing.prefix = "\/index.php";')
      ->contains('Routing.variablePrefix = [":"]; ')
      ->contains('Routing.variableSuffix = ""; ')
      ->contains('Routing.segmentSeparators = ["\/","."]; ')
      ->contains('Routing.defaults = {"sf_culture":"en"}; ')
      ->contains('Routing.connect("exposed_route", "\/exposed", []);')
      ->contains('Routing.connect("default", "\/:module\/:action\/*", []);')
      ->contains('Routing.connect("default_index", "\/:module", {"foo":"bar"});')
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
      ->contains('Routing.connect("default_index", "\/:module", {"action":"index"});')
    ->end()
;
// vim: ft=symfony.php.sftest
