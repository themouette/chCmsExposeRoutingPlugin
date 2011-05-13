/* 
list of routes.
auto generated.
*/

Routing.prefix = <?php echo json_encode($options['context']['prefix']); ?>; 
Routing.variablePrefix = <?php echo json_encode($options['variable_prefixes']); ?>; 
Routing.segmentSeparators = <?php echo json_encode($options['segment_separators']); ?>; 
Routing.defaults = <?php echo json_encode($defaultParameters); ?>; 
<?php foreach($exposed_routes as $id => $route): ?>
  <?php if( ($options = $route->getOptions()) 
            && isset($options['app_expose']) 
            && true === $options['app_expose']): ?>
Routing.connect(<?php echo json_encode($id); ?>
, <?php echo json_encode($route->getPattern()); ?>
, <?php echo json_encode($route->getDefaults()); ?>
);
  <?php endif; ?>
<?php endforeach; ?>
<?php 
// vim:ft=php.html.sftemplate
?>
