/* 
list of routes.
auto generated.
*/

Routing.prefix = <?php echo json_encode($prefix); ?>; 
<?php foreach($exposed_routes as $id => $route): ?>
Routing.connect(<?php echo json_encode($id) ?>, <?php echo json_encode($route->getPattern()) ?>);
<?php endforeach; ?>

<?php 
// vim:ft=php.html.sftemplate
?>
