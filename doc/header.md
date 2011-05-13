## What is this ?

[chCmsExposeRoutingPlugin](http://themouette.github.com/chCmsExposeRoutingPlugin/) is a 
[symfony 1.(3|4)](http://www.symfony-project.org/) plugin used to expose routing definition
to the client side.

This file is the client side api reference.

## Basic usage

in your script just access a server side route this way:

    Routing.get('your route name');

You can generate a url this way:
    
    Routing.generate('your_route_name', {'foo': 'bar', 'baz': 1});
