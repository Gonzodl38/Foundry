<?php

declare(strict_types=1);

namespace Phoenix\Configuration\Contracts;

/**
 * Defines the public contract for the Phoenix configuration repository.
 *
 * Implementations are responsible for storing and retrieving configuration
 * values. The source of those values is outside the scope of this contract.
 */
interface ConfigurationContract
{
    /**
     * Stores a configuration value.
     *
     * @param string $key   Configuration key.
     * @param mixed  $value Configuration value.
     */
    public function set(string $key, mixed $value): void;

    /**
     * Retrieves a configuration value.
     *
     * @param string $key     Configuration key.
     * @param mixed  $default Value returned when the key does not exist.
     *
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed;

    /**
     * Determines whether a configuration key exists.
     *
     * @param string $key Configuration key.
     */
    public function has(string $key): bool;

    /**
     * Returns all configuration values.
     *
     * @return array<string, mixed>
     */
    public function all(): array;
}