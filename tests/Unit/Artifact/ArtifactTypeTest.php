<?php
// File: C:\Projects\tests\Unit\Artifact\ArtifactTypeTest.php
declare(strict_types=1);

namespace Phoenix\Tests\Unit\Artifact;

use Phoenix\Tests\TestCase;
use Phoenix\Foundry\Artifacts\ArtifactType;
final class ArtifactTypeTest extends TestCase
{
    public function testArtifactTypeContainsWorkOrder(): void
    {
        $this->assertContains(
            ArtifactType::WORK_ORDER,
            ArtifactType::cases()
        );
    }
    public function testWorkOrderHasCorrectLabel(): void
    {
        $this->assertSame(
            'Work Order',
            ArtifactType::WORK_ORDER->label()
        );
    }
    public function testEveryArtifactTypeHasNonEmptyLabel(): void
    {
        foreach (ArtifactType::cases() as $type) {
            $this->assertNotEmpty(
                $type->label()
            );
        }
    }
    public function testArtifactTypeLabelsAreUnique(): void
    {
        $labels = array_map(
            fn(ArtifactType $type) => $type->label(),
            ArtifactType::cases()
        );

        $this->assertSame(
            count($labels),
            count(array_unique($labels))
        );
    }
}