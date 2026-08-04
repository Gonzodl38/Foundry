1. docs/Governance/Phoenix-Architecture-Doctrine.md
Purpose

Defines the architectural principles that govern the design of the Phoenix Framework.

This document is the highest technical authority of the project.

Scope

Applies to:

Core Framework
Foundation
Capabilities
Contributions
Refactoring
Work Orders
Principles
Principle 1 — Single Responsibility

Every subsystem answers exactly one question.

Principle 2 — Composition over Coupling

Subsystems are composed through Providers.

They never directly construct each other.

Principle 3 — Bootstrap Creates

Bootstrap creates the framework.

Bootstrap never extends the framework.

Principle 4 — Providers Extend

Providers extend the framework.

Providers never create the framework.

Principle 5 — Stable Core

Growth occurs by adding capabilities.

The following should become increasingly stable:

Container
Application
Bootstrap
Foundation
Principle 6 — Contracts First

Every public contract is defined before implementation.

Principle 7 — Downward Dependencies

Dependencies always point downward.

No circular dependencies.

Principle 8 — Independent Evolution

Subsystems evolve independently.

Removing one subsystem should require only removing its Provider.

Principle 9 — Public API First

The public API is the product.

Implementations are internal details.

Principle 10 — Simplicity

Implement the simplest solution that completely satisfies the current contract.

Compliance

Every Work Order must demonstrate compliance.