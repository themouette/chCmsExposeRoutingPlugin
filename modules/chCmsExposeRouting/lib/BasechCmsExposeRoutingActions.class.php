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
   * retrive matching route and check it can be displayed.
   *
   * @param string $route_id the id of route to retrieve
   * @return sfRoute|null
   **/
  protected function retrieveRoute($route_id, $routing)
  {
    if ($routing->hasRouteName($route_id))
    {
      $routes = $routing->getRoutes();
      $route = $routes[$route_id];
      $options = $route->getOptions();

      // check exposition
      if (!isset($options['app_expose']) || true === $options['app_expose'])
      {
        return $route;
      }
    }
    return null;
  }

  /**
   * adds the application configured routes.
   *
   * @return array
   **/
  protected function applicationConfiguredRoutes($routing)
  {
    $routes = array();

    foreach(sfConfig::get('app_ch_cms_expose_routing_routes_to_expose', array()) as $route_id)
    {
      if($route = $this->retrieveRoute($route_id, $routing))
      {
        $routes[$route_id] = $route;
      }
    }

    return $routes;
  }

  /**
   * iterate over every routes to retrive routes 
   * with *app_expose* option set to true.
   *
   * @return array
   **/
  protected function autoDiscoverExposedRoutes($routing)
  {
    $routes = array();

    if (sfConfig::get('app_ch_cms_expose_routing_auto_discover', true))
    {
      foreach($routing->getRoutes() as $route_id => $route)
      {
        $options = $route->getOptions();
        
        if (isset($options['app_expose']) && $options['app_expose'])
        {
          $routes[$route_id] = $route;
        }
      }
    }

    return $routes;
  }

  /**
   * retrieve all the routes that should be exposed
   *
   * @param sfWebRequest $request the user request
   * @return 
   */
  public function executeIndex(sfWebRequest $request)
  {
    $csrf = array();
    $form = new BaseForm();
    if($form->isCSRFProtected())
    {
      $csrf[BaseForm::getCSRFFieldName()] = $form->getDefault(BaseForm::getCSRFFieldName()); 
    }
    $this->setVar('csrf', $csrf, true);

    $routing = $this->getContext()->getRouting();

    // set defaults
    $routingOptions = $routing->getOptions();
    $this->setVar('options', $routingOptions, true);
    $this->setVar('defaultParameters', $routing->getDefaultParameters(), true);

    // filter exposed routes
    $routes = $routing->getRoutes();
    $exposed_routes = array_merge(
        $this->autoDiscoverExposedRoutes($routing),
        $this->applicationConfiguredRoutes($routing));

    $this->setVar('exposed_routes', $exposed_routes, true);
  }
}
