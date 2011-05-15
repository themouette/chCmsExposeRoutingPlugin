chCmsExposeRoutingPlugin: expose your symfony routes to javascript
==================================================================

Goal
----

[chCmsExposeRoutingPlugin](http://themouette.github.com/chCmsExposeRoutingPlugin/) is a 
[symfony 1.(3|4)](http://www.symfony-project.org/) plugin used to expose routing definition
to the client side.

if you use [symfony2](http://symfony.com/), have a look to [Bazinga/ExposeRoutingBundle](https://github.com/Bazinga/ExposeRoutingBundle) 


Requirement
-----------

You need jquery to use this plugin. jQuery is not bundeled with this plugin, you have to include it yourself.

How does it work ?
------------------

### Enable

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

### More conf

You can *disable the script auto inclusion* by adding the following in your *routing.yml*

```yml
app:
  ch_cms_expose_routing:
    register_scripts: false # you will have to register scripts manually
```

You can *disable the route auto declaration* by adding the following in your *routing.yml*

```yml
app:
  ch_cms_expose_routing:
    register_routes: false # you will have to register script route manually
```

and the register your route this way:

```yml
my_custom_route_name:
  url: /my/url/route.js
  params: { module: chCmsExposeRouting, action: index }
```

### register your exposed routes

#### make a route exposable

the only thing you need to do is to add an _app_expose_ option:

```yml
// app/{your_app}/config/routing.yml

# this route will be exposed if auto_discover is true
my_route_to_expose:
  url:  /foo/:id/bar
  params: { action: foo, module: bar }
  options:
    app_expose: true

# this route will NEVER be exposed
my_secret_route:
  url:  /foo/:id/bar/1
  params: { action: foo, module: bar }
  options:
    app_expose: false

# this route will be exposed if forced, but not autodetected
a_default route:
  url:  /foo/:id/bar/2
  params: { action: foo, module: bar }
```

#### force a route exposition

in your application config ( _app.yml_ ), add the following:

```yml
app:
  ch_cms_expose_routing:
    routes_to_expose:
      - my_first_route_to_expose
      - another_route
```

#### expose all exposable routes

if you want to expose all routes with _app_expose_ option to true, 
just add the following to your application config ( _app.yml_ ):

```yml
app:
  ch_cms_expose_routing:
    auto_discover: false
```

#### custom filter on exposed params

in your application config ( _app.yml_ ), add the following:

```yml
app:
  ch_cms_expose_routing:
    params_blacklist:
      - module
      - action
      - my_param
```

### access routes in browser

It's as simple as calling `Routing.generate('route_id', /* your params */)`.

```js
Routing.generate('route_id', {id: 10});
// will result in /foo/10/bar
Routing.generate('route_id', {"id": 10, "foo":"bar"});
// will result in /foo/10/bar?foo-bar

$.get(Routing.generate('route_id', {"id": 10, "foo":"bar"}));
// will call /foo/10/bar?foo=bar
```

TODO
----

* cache js routing
* add simple way to call server with sf_method and csrf_token
