<?php

$options = getopt("", array("symfony:", "xml:"));

if (isset($options['symfony']))
{
  $_SERVER['SYMFONY'] = $options['symfony'];
}

$xmlExport = false;
if (isset($options['xml']))
{
  $xmlExport = $options['xml'];
}

//default symfony look for project lib vendor
if (!isset($_SERVER['SYMFONY']))
{
  $_SERVER['SYMFONY'] = '../../lib/vendor/symfony/lib/';
}

include dirname(__FILE__).'/../bootstrap/unit.php';

$h = new lime_harness(new lime_output_color());
$h->register(sfFinder::type('file')->name('*Test.php')->in(dirname(__FILE__).'/..'));

$ret = $h->run() ? 0 : 1;

// publish xml results
if ($xmlExport)
{
  echo sprintf("export to xml file %s", $xmlExport);
  file_put_contents($xmlExport, $h->to_xml());
}


exit($ret);
