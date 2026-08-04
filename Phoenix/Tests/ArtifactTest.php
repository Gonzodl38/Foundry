<?php

require __DIR__ . '/../../vendor/autoload.php';

use Phoenix\Foundry\Artifacts\Artifact;
use Phoenix\Foundry\Artifacts\ArtifactId;
use Phoenix\Foundry\Artifacts\ArtifactType;
use Phoenix\Foundry\Exceptions\InvalidArtifactTransitionException;

$artifact = new Artifact(
    ArtifactId::generate(),
    ArtifactType::WORK_ORDER
);

echo "Artifact ID: " . $artifact->id() . PHP_EOL;
echo "Type: " . $artifact->type()->label() . PHP_EOL;
echo "Status: " . $artifact->status()->label() . PHP_EOL;

echo PHP_EOL;

$artifact->plan();
$artifact->forge();
$artifact->verify();
$artifact->certify();
$artifact->release();

echo "Final Status: " . $artifact->status()->label() . PHP_EOL;

echo PHP_EOL;
echo "History:" . PHP_EOL;

foreach ($artifact->history() as $status) {
    echo "- " . $status->label() . PHP_EOL;
}

echo PHP_EOL;

echo "Testing invalid transition..." . PHP_EOL;

try {
    $artifact->plan();
} catch (InvalidArtifactTransitionException $e) {
    echo "PASS: " . $e->getMessage() . PHP_EOL;
}