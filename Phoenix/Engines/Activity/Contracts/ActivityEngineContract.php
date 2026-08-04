<?php
/*
|--------------------------------------------------------------------------
| Path
|--------------------------------------------------------------------------
| C:\Projects\Phoenix\Engines\Activity\Contracts\ActivityEngineContract.php
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace Phoenix\Engines\Activity\Contracts;

interface ActivityEngineContract
{
    public function initialize(?int $userId = null): void;

    public function login(?string $description = null): void;

    public function logout(?string $description = null): void;

    public function view(?string $description = null): void;

    public function insert(
        string $table,
        int|string|null $recordId = null,
        ?array $newValues = null,
        ?string $description = null
    ): void;

    public function update(
        string $table,
        int|string|null $recordId = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?string $description = null
    ): void;

    public function delete(
        string $table,
        int|string|null $recordId = null,
        ?array $oldValues = null,
        ?string $description = null
    ): void;

    public function export(
        string $report,
        ?string $description = null
    ): void;

    public function import(
        string $source,
        ?string $description = null
    ): void;

    public function print(
        string $document,
        ?string $description = null
    ): void;

    public function custom(
        string $action,
        ?string $description = null,
        ?string $tableName = null,
        int|string|null $recordId = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?array $metadata = null
    ): void;
}