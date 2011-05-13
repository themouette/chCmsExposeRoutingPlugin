<?php

/**
 * chCmsExposeRoutingPlugin configuration.
 * 
 * @package     chCmsExposeRoutingPlugin
 * @subpackage  config
 * @author      Your name here
 * @version     SVN: $Id$
 */
class chCmsExposeRoutingPluginConfiguration extends sfPluginConfiguration
{
  const VERSION = '1.0.0-DEV';

  /**
   * @see sfPluginConfiguration
   */
  public function initialize()
  {
    $this->dispatcher->connect('routing.load_configuration', array($this, 'listenToRoutingLoadConfigurationEvent'));
    $this->dispatcher->connect('context.load_factories', array($this, 'listenToLoadFactoriesEvent'));
  }

  /**
   * listen to the routing.load_configuration
   *
   * @return void
   **/
  public function listenToRoutingLoadConfigurationEvent(sfEvent $event)
  {
    if (in_array('chCmsExposeRouting', sfConfig::get('sf_enabled_modules')) && sfConfig::get('app_ch_cms_expose_routing_register_routes', true))
    {
      $this->dispatcher->notify(new sfEvent($this, 'application.log', array('register chCmsExposeRoutingPlugin route', 'priority' => sfLogger::INFO)));
      $event->getSubject()->prependRoute('ch_cms_expose_routing', new sfRequestRoute(
          '/js/app/routes.:sf_format',
          array('sf_format' => 'js', 'module' => 'chCmsExposeRouting', 'action' => 'index'),
          array('format' => array('js'), 'method' => array('GET')),
          array()
        ));
    }
  }

  /**
   * listen to context.load_factory event
   *
   * @return void
   **/
  public function listenToLoadFactoriesEvent(sfEvent $event)
  {
    if (in_array('chCmsExposeRouting', sfConfig::get('sf_enabled_modules')) && sfConfig::get('app_ch_cms_expose_routing_register_scripts', true))
    {
      $this->dispatcher->notify(new sfEvent($this, 'application.log', array('register chCmsExposeRoutingPlugin scripts', 'priority' => sfLogger::INFO)));
      $response = $event->getSubject()->getResponse();
      $routing  = $event->getSubject()->getRouting();
      $response->addJavascript('/chCmsExposeRoutingPlugin/js/routing', sfWebResponse::MIDDLE);
      $response->addJavascript($routing->generate('ch_cms_expose_routing'), sfWebResponse::LAST);
    }
  }
}
