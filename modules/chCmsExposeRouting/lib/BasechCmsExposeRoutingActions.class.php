<?php

/**
 * Base actions for the chCmsExposeRoutingPlugin chCmsExposeRouting module.
 * 
 * @package     chCmsExposeRoutingPlugin
 * @subpackage  chCmsExposeRouting
 * @author      Your name here
 * @version     SVN: $Id$
 */
abstract class BasechCmsExposeRoutingActions extends sfActions
{
  /**
   * retrieve all the routes that should be exposed
   *
   * @param sfWebRequest $request the user request
   * @return 
   */
  public function executeIndex(sfWebRequest $request)
  {
    $routing = $this->getContext()->getRouting();

    // set defaults
    $routingOptions = $routing->getOptions();
    $this->setVar('options', $routingOptions, true);
    $this->setVar('defaultParameters', $routing->getDefaultParameters(), true);

    // filter exposed routes
    $routes = $routing->getRoutes();
    $exposed_routes = array();

    foreach ($routes as $route_id => $route) 
    {
      $options = $route->getOptions();
      if (isset($options['app_expose']) && $options['app_expose'])
      {
        $exposed_routes[$route_id] = $route;
      }
    }
    $this->setVar('exposed_routes', $exposed_routes, true);
  }
}
