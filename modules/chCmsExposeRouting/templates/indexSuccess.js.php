/* 
list of routes.
auto generated.
*/
var Routing = $.ExposeRouting;

Routing.prefix = <?php echo json_encode($options['context']['prefix']); ?>; 
Routing.variablePrefix = <?php echo json_encode($options['variable_prefixes']); ?>; 
Routing.variableSuffix = <?php echo json_encode($options['suffix']); ?>; 
Routing.segmentSeparators = <?php echo json_encode($options['segment_separators']); ?>; 
Routing.defaults = <?php echo json_encode(chCmsExposeRoutingTools::filterParameters($defaultParameters)); ?>; 
Routing.csrf = <?php echo json_encode($csrf); ?>;
<?php foreach($exposed_routes as $id => $route): ?>
Routing.connect(<?php echo json_encode($id); ?>
, <?php echo json_encode($route->getPattern()); ?>
, <?php echo json_encode(chCmsExposeRoutingTools::filterParameters($route->getDefaults())); ?>
);
<?php endforeach; ?>
<?php 
// vim:ft=php.html.sftemplate
?>
