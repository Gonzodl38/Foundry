<?php

declare(strict_types=1);

namespace Phoenix\Container\Exceptions;

final class CircularDependencyException extends ContainerException
{
    /**
     * @param string[] $stack
     */
    public static function fromStack(array $stack, string $class): self
    {
        $stack[] = $class;

        return new self(
            "Circular dependency detected.\n\n" .
            implode("\n -> ", $stack)
        );
    }
}