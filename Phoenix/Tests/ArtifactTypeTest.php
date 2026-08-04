<?php

require __DIR__ . '/../../vendor/autoload.php';

use Phoenix\Foundry\Artifacts\ArtifactType;

foreach (ArtifactType::cases() as $type) {

    echo $type->name;
    echo " -> ";
    echo $type->label();

    if ($type->isSourceCode()) {
        echo " [Source]";
    }

    if ($type->isDeliverable()) {
        echo " [Deliverable]";
    }

    echo PHP_EOL;
}