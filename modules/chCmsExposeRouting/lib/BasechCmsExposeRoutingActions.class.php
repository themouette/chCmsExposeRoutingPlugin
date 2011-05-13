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
    $routes = $this->getContext()->getRouting()->getRoutes();
    $this->exposed_routes = array();
    $routingOptions = $this->getContext()->getRouting()->getOptions();
    $this->prefix = $routingOptions['context']['prefix'];

    foreach ($routes as $route_id => $route) 
    {
      $options = $route->getOptions();
      if (isset($options['app_expose']) && $options['app_expose'])
      {
        $this->exposed_routes[$route_id] = $route;
      }
    }
  }
}
