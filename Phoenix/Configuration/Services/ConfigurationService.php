<?php

declare(strict_types=1);

namespace Phoenix\Configuration\Services;

use Phoenix\Configuration\Contracts\ConfigurationContract;

/**
 * Default implementation of the Phoenix configuration repository.
 *
 * Stores and retrieves configuration values independently of their source.
 */
final class ConfigurationService implements ConfigurationContract
{
    /**
     * Configuration repository.
     *
     * @var array<string, mixed>
     */
    private array $items = [];

    /**
     * {@inheritdoc}
     */
    public function set(string $key, mixed $value): void
    {
        $this->items[$key] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return $this->items[$key] ?? $default;
    }

    /**
     * {@inheritdoc}
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * {@inheritdoc}
     */
    public function all(): array
    {
        return $this->items;
    }
}