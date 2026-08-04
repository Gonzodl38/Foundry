#!/usr/bin/env python3
"""
Phoenix Foundry
Repository Inspector

Inspects a repository and reports structural inconsistencies.

This tool NEVER modifies the repository.
"""

from pathlib import Path
from dataclasses import dataclass, field
from typing import List
import argparse
import json
import sys

VERSION = "1.1.0"

EXPECTED_DOC_DIRECTORIES = {
    "architecture",
    "articles",
    "constitution",
    "glossary",
    "governance",
    "guides",
    "principles",
    "reference",
    "specifications",
    "standards",
    "templates",
    "work-orders",
}


@dataclass
class RenameSuggestion:
    current: str
    expected: str


@dataclass
class InspectionReport:
    warnings: List[str] = field(default_factory=list)
    errors: List[str] = field(default_factory=list)
    renames: List[RenameSuggestion] = field(default_factory=list)

    def exit_code(self) -> int:
        if self.errors:
            return 2
        if self.warnings or self.renames:
            return 1
        return 0

    def print_text(self, root: Path):

        print("=" * 70)
        print("PHOENIX FOUNDRY")
        print("Repository Inspection Report")
        print("=" * 70)
        print()

        print(f"Repository : {root}")
        print()

        if self.errors:
            print("ERRORS")
            for item in self.errors:
                print(f"  ✖ {item}")
            print()

        if self.warnings:
            print("WARNINGS")
            for item in self.warnings:
                print(f"  ! {item}")
            print()

        if self.renames:
            print("SUGGESTED RENAMES")
            for item in self.renames:
                print(f"  {item.current} -> {item.expected}")
            print()

        print("SUMMARY")
        print(f"  Errors   : {len(self.errors)}")
        print(f"  Warnings : {len(self.warnings)}")
        print(f"  Renames  : {len(self.renames)}")

    def print_json(self):

        data = {
            "errors": self.errors,
            "warnings": self.warnings,
            "renames": [
                {
                    "from": r.current,
                    "to": r.expected
                }
                for r in self.renames
            ]
        }

        print(json.dumps(data, indent=4))


class RepositoryInspector:

    def __init__(self, root: Path):
        self.root = root
        self.report = InspectionReport()

    def inspect(self):

        docs = self.root / "docs"

        if not docs.exists():
            self.report.errors.append("docs directory not found.")
            return self.report

        existing = {
            d.name
            for d in docs.iterdir()
            if d.is_dir()
        }

        expected_lookup = {
            item.lower(): item
            for item in EXPECTED_DOC_DIRECTORIES
        }

        for directory in existing:

            lower = directory.lower()

            if lower in expected_lookup:

                expected = expected_lookup[lower]

                if directory != expected:
                    self.report.renames.append(
                        RenameSuggestion(
                            directory,
                            expected
                        )
                    )

        if "specification" in existing:
            self.report.renames.append(
                RenameSuggestion(
                    "specification",
                    "specifications"
                )
            )

        current_names = {
            d.lower()
            for d in existing
        }

        missing = (
            EXPECTED_DOC_DIRECTORIES
            - current_names
        )

        for item in sorted(missing):
            self.report.warnings.append(
                f"Missing docs/{item}"
            )

        return self.report


def build_parser():

    parser = argparse.ArgumentParser(
        description="Phoenix Repository Inspector"
    )

    parser.add_argument(
        "repository",
        nargs="?",
        default=".",
        help="Repository path"
    )

    parser.add_argument(
        "--json",
        action="store_true",
        help="Output JSON"
    )

    parser.add_argument(
        "--version",
        action="version",
        version=f"%(prog)s {VERSION}"
    )

    return parser


def main():

    parser = build_parser()

    args = parser.parse_args()

    root = Path(args.repository).resolve()

    report = RepositoryInspector(root).inspect()

    if args.json:
        report.print_json()
    else:
        report.print_text(root)

    sys.exit(report.exit_code())


if __name__ == "__main__":
    main()