<?php

/*
|--------------------------------------------------------------------------
| Repository Path
|--------------------------------------------------------------------------
| /Projects/Phoenix/Foundry/Artifacts/ArtifactType.php
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace Phoenix\Foundry\Artifacts;

enum ArtifactType: string
{
    case WORK_ORDER    = 'work_order';

    case SPECIFICATION = 'specification';

    case COMMAND       = 'command';

    case SERVICE       = 'service';

    case PHP_CLASS     = 'php_class';

    case INTERFACE     = 'interface';

    case REPORT        = 'report';

    case CERTIFICATE   = 'certificate';

    case RELEASE       = 'release';

    case TEMPLATE      = 'template';

    case CONFIGURATION = 'configuration';

    case DIRECTORY     = 'directory';

    public function label(): string
    {
        return match ($this) {
            self::WORK_ORDER    => 'Work Order',
            self::SPECIFICATION => 'Specification',
            self::COMMAND       => 'Command',
            self::SERVICE       => 'Service',
            self::PHP_CLASS     => 'PHP Class',
            self::INTERFACE     => 'Interface',
            self::REPORT        => 'Report',
            self::CERTIFICATE   => 'Certificate',
            self::RELEASE       => 'Release',
            self::TEMPLATE      => 'Template',
            self::CONFIGURATION => 'Configuration',
            self::DIRECTORY     => 'Directory',
        };
    }

    public function isSourceCode(): bool
    {
        return match ($this) {
            self::COMMAND,
            self::SERVICE,
            self::PHP_CLASS,
            self::INTERFACE => true,

            default => false,
        };
    }

    public function isDeliverable(): bool
    {
        return match ($this) {
            self::REPORT,
            self::CERTIFICATE,
            self::RELEASE => true,

            default => false,
        };
    }
}