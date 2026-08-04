<?php

require __DIR__ . '/../../vendor/autoload.php';

use Phoenix\Foundry\Artifacts\ArtifactFactory;
use Phoenix\Foundry\Artifacts\ArtifactRepository;
use Phoenix\Foundry\Artifacts\ArtifactType;

$repository = new ArtifactRepository();

$artifact = ArtifactFactory::create(
    ArtifactType::WORK_ORDER
);

$repository->save($artifact);

echo "Repository Count: ";
echo $repository->count();
echo PHP_EOL;

echo "Exists: ";
var_export($repository->exists($artifact->id()));
echo PHP_EOL;

$loaded = $repository->find($artifact->id());

echo "Loaded Type: ";
echo $loaded?->type()->label();
echo PHP_EOL;

$repository->remove($artifact->id());

echo "Repository Count After Remove: ";
echo $repository->count();
echo PHP_EOL;