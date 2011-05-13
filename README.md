chCmsExposeRoutingPlugin: expose your symfony routes to javascript
==================================================================

Goal
----

this plugin is used to expose your symfony routes to your javascript.

Requirement
-----------

You need jquery to use this plugin. jQuery is not bundeled with this plugin, you have to include it yourself.

How does it work ?
------------------

### enable

First, enable the plugin in your project configuration:

    ```php
    // config/ProjectConfiguration.class.php

    public function setup()
    {
      $this->enablePlugins(array('chCmsExposeRoutingPlugin'));
    }
    ```

Then enable *chCmsExposeRouting* in your application:

    ```yml
    # app/{your_app}/config/settins.yml

        enabled_modules:
          - chCmsExposeRouting
    ```

you're done !

### register your routes

the only thing you need to do is to add an _app_expose_ option:

    ```yml
    // app/{your_app}/config/routing.yml

    my_route_to_expose:
      url:  /foo/:id/bar
      params: { action: foo, module: bar }
      options:
        app_expose: true

    my_secret_route:
      url:  /foo/:id/bar/1
      params: { action: foo, module: bar }
      options:
        app_expose: false

    another_secret_route:
      url:  /foo/:id/bar/2
      params: { action: foo, module: bar }
    ```

### access routes in browser

It's as simple as calling `Routing.generate('route_id', /* your params */)`.

    ```js
    Routing.generate('route_id', {id: 10});
    // will result in /foo/10/bar
    Routing.generate('route_id', {"id": 10, "foo":"bar"});
    // will result in /foo/10/bar?foo-bar
    
    $.get(Routing.generate('route_id', {"id": 10, "foo":"bar"}));
    // will call /foo/10/bar?foo-bar
    ```

TODO
----

* add test structure
* disable auto include for js
* include all routes
* define routes to include in an other way ?
* cache js routing
