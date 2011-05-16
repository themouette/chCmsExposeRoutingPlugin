<?php

if (count($argv) > 1 && !isset($_SERVER['SYMFONY']))
{
  $_SERVER['SYMFONY'] = $argv[1];
}

$xmlExport = false;
if (count($argv) > 2)
{
  $xmlExport = $argv[2];
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
  file_put_contents($xmlExport, $h->to_xml());
}


exit($ret);
