<?php

require __DIR__ . '/../../vendor/autoload.php';

use Phoenix\Foundry\Artifacts\ArtifactStatus;

foreach (ArtifactStatus::cases() as $status) {

    echo $status->label();

    if ($status->isFinal()) {
        echo " [Final]";
    }

    echo PHP_EOL;
}

echo PHP_EOL;

echo "Draft -> Planned: ";

var_export(
    ArtifactStatus::DRAFT
        ->canTransitionTo(ArtifactStatus::PLANNED)
);

echo PHP_EOL;

echo "Draft -> Released: ";

var_export(
    ArtifactStatus::DRAFT
        ->canTransitionTo(ArtifactStatus::RELEASED)
);

echo PHP_EOL;