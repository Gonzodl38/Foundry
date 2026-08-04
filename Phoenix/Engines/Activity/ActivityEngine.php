<?php
/*
|--------------------------------------------------------------------------
| Path
|--------------------------------------------------------------------------
| C:\Projects\Phoenix\Engines\Activity\ActivityEngine.php
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace Phoenix\Engines\Activity;

use Phoenix\Engines\Activity\Contracts\ActivityEngineContract;
use Phoenix\Engines\Activity\Services\ActivityLoggerService;

final class ActivityEngine implements ActivityEngineContract
{
    public function __construct(
        private readonly ActivityLoggerService $logger = new ActivityLoggerService()
    ) {
    }

    public function initialize(?int $userId = null): void
    {
        ActivityContext::initialize($userId);
    }

    public function login(?string $description = null): void
    {
        $this->logger->login($description);
    }

    public function logout(?string $description = null): void
    {
        $this->logger->logout($description);
    }

    public function view(?string $description = null): void
    {
        $this->logger->view($description);
    }

    public function insert(
        string $table,
        int|string|null $recordId = null,
        ?array $newValues = null,
        ?string $description = null
    ): void {
        $this->logger->insert(
            tableName: $table,
            recordId: $recordId,
            newValues: $newValues,
            description: $description
        );
    }

    public function update(
        string $table,
        int|string|null $recordId = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?string $description = null
    ): void {
        $this->logger->update(
            tableName: $table,
            recordId: $recordId,
            oldValues: $oldValues,
            newValues: $newValues,
            description: $description
        );
    }

    public function delete(
        string $table,
        int|string|null $recordId = null,
        ?array $oldValues = null,
        ?string $description = null
    ): void {
        $this->logger->delete(
            tableName: $table,
            recordId: $recordId,
            oldValues: $oldValues,
            description: $description
        );
    }

    public function export(
        string $report,
        ?string $description = null
    ): void {
        $this->logger->export($report, $description);
    }

    public function import(
        string $source,
        ?string $description = null
    ): void {
        $this->logger->import($source, $description);
    }

    public function print(
        string $document,
        ?string $description = null
    ): void {
        $this->logger->print($document, $description);
    }

    public function custom(
        string $action,
        ?string $description = null,
        ?string $tableName = null,
        int|string|null $recordId = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?array $metadata = null
    ): void {
        $this->logger->custom(
            action: $action,
            description: $description,
            tableName: $tableName,
            recordId: $recordId,
            oldValues: $oldValues,
            newValues: $newValues,
            metadata: $metadata
        );
    }
}