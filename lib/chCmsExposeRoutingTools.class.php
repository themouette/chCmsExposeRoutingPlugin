<?php
/**
 * This file declare the chCmsExposeRoutingTools class.
 *
 * @package chCmsExposeRoutingPlugin
 * @subpackage lib
 * @author Julien Muetton <julien_muetton@carpe-hora.com>
 * @copyright (c) Carpe Hora SARL 2011
 * @since 2011-05-15
 */

/**
 * the chCmsExposeRoutingPlugin tools.
 */
class chCmsExposeRoutingTools
{
  /**
   * filter route parameters against a blacklist.
   * balclist is read from app_ch_cms_expose_routing_params_blacklist config value
   *
   * @param array   $params   the paremeters to filte
   * @return array
   **/
  public static function filterParameters($params)
  {
    $ret = array();
    $blacklist = sfConfig::get('app_ch_cms_expose_routing_params_blacklist', array('module', 'action'));

    foreach ($params as $name => $value) 
    {
      if (!in_array($name, $blacklist))
      {
        $ret[$name] = $value;
      }
    }

    return $ret;
  }
} // END OF chCmsExposeRoutingTools
