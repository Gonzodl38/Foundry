<?php

require __DIR__ . '/../../vendor/autoload.php';


use Phoenix\Foundry\Artifacts\ArtifactId;

$id1 = ArtifactId::generate();
$id2 = ArtifactId::generate();

echo "ID 1: {$id1}\n";
echo "ID 2: {$id2}\n";

echo PHP_EOL;

echo $id1->equals($id2)
    ? "Same ID"
    : "Different IDs";