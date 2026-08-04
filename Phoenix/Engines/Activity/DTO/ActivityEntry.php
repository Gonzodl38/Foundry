<?php
/*
|--------------------------------------------------------------------------
| Path
|--------------------------------------------------------------------------
| C:\Projects\Phoenix\Engines\Activity\DTO\ActivityEntry.php
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace Phoenix\Engines\Activity\DTO;

final readonly class ActivityEntry
{
    public function __construct(
        public ?int $userId,
        public string $sessionId,
        public string $requestUri,
        public string $controller,
        public string $actionMethod,
        public string $module,
        public string $actionCode,
        public ?string $tableName = null,
        public int|string|null $recordId = null,
        public ?string $description = null,
        public ?array $oldValues = null,
        public ?array $newValues = null,
        public ?array $metadata = null,
    ) {
    }

    public function toDatabase(): array
    {
        return [
            'user_id'       => $this->userId,
            'session_id'    => $this->sessionId,
            'request_uri'   => $this->requestUri,
            'controller'    => $this->controller,
            'action_method' => $this->actionMethod,
            'module'        => $this->module,
            'action_code'   => $this->actionCode,
            'table_name'    => $this->tableName,
            'record_id'     => $this->recordId,
            'description'   => $this->description,
            'old_values'    => $this->encode($this->oldValues),
            'new_values'    => $this->encode($this->newValues),
            'metadata'      => $this->encode($this->metadata),
        ];
    }

    private function encode(?array $value): ?string
    {
        if ($value === null) {
            return null;
        }

        return json_encode(
            $value,
            JSON_UNESCAPED_UNICODE
            | JSON_UNESCAPED_SLASHES
            | JSON_THROW_ON_ERROR
        );
    }

    public static function fromContext(
        array $context,
        string $actionCode,
        ?string $tableName = null,
        int|string|null $recordId = null,
        ?string $description = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?array $metadata = null
    ): self {
        return new self(
            userId: $context['user_id'],
            sessionId: $context['session_id'],
            requestUri: $context['request_uri'],
            controller: $context['controller'],
            actionMethod: $context['action_method'],
            module: $context['module'],
            actionCode: $actionCode,
            tableName: $tableName,
            recordId: $recordId,
            description: $description,
            oldValues: $oldValues,
            newValues: $newValues,
            metadata: $metadata,
        );
    }
}