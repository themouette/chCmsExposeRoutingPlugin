#!/bin/bash
SCRIPTPATH=`readlink -f $0`;
PLUGIN_PATH=`dirname $SCRIPTPATH`;

# js doc, relies on [dox](http://visionmedia.github.com/dox/)
dox --title chCmsExposeRoutingPlugin --private --intro doc/header.md web/js/routing.js > doc/js/index.html

# php doc, relies on [docblox](http://www.docblox-project.org/)
docblox run -d $PLUGIN_PATH -t doc/php/ -i doc/,test/,web/
