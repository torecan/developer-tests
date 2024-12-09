<?php

require __DIR__ . '/vendor/autoload.php';

use App\ActionFactory;

$shortopts = "a:f:";
$longopts  = array(
    "action:",
    "file:",
);

$options = getopt($shortopts, $longopts);

if(isset($options['a'])) {
    $action = $options['a'];
} elseif(isset($options['action'])) {
    $action = $options['action'];
} else {
    throw new \Exception("No action is selected");
}

if(isset($options['f'])) {
    $file = $options['f'];
} elseif(isset($options['file'])) {
    $file = $options['file'];
} else {
    throw new \Exception("No file is selected");
}


$actionFactory = new ActionFactory();
$actionFactory->create($action, $file);
