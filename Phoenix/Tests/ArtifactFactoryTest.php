<?php

require __DIR__ . '/../../vendor/autoload.php';

use Phoenix\Foundry\Artifacts\ArtifactFactory;
use Phoenix\Foundry\Artifacts\ArtifactType;

$artifact = ArtifactFactory::create(
    ArtifactType::WORK_ORDER
);

echo "ID: ";
echo $artifact->id();
echo PHP_EOL;

echo "Type: ";
echo $artifact->type()->label();
echo PHP_EOL;

echo "Status: ";
echo $artifact->status()->label();
echo PHP_EOL;

echo PHP_EOL;

echo "Factory created a valid artifact.";
echo PHP_EOL;