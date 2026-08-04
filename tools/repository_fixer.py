#!/usr/bin/env python3
# ==============================================================================
# Repository Path:
# C:\Projects\tools\repository_fixer.py
#
# Purpose:
# Applies deterministic repository fixes defined in repository_rules.yaml.
#
# Usage:
#     python repository_fixer.py
# ==============================================================================

from pathlib import Path
import shutil
import json
import sys

ROOT = Path(__file__).resolve().parent.parent
RULES = ROOT / "tools" / "repository_rules.json"


class RepositoryFixer:

    def __init__(self):

        with open(RULES, encoding="utf8") as fp:
            self.rules = json.load(fp)

        self.modified = False

    # -------------------------------------------------------------------------

    def mkdir(self, path: Path):

        if not path.exists():
            path.mkdir(parents=True)
            print(f"[CREATE] {path.relative_to(ROOT)}")
            self.modified = True

    # -------------------------------------------------------------------------

    def rename(self, source: Path, destination: Path):

        if not source.exists():
            return

        if destination.exists():
            print(
                f"[SKIP] {destination.relative_to(ROOT)} already exists"
            )
            return

        destination.parent.mkdir(parents=True, exist_ok=True)

        shutil.move(str(source), str(destination))

        print(
            f"[MOVE] {source.relative_to(ROOT)}"
        )

        print(
            f"       -> {destination.relative_to(ROOT)}"
        )

        self.modified = True

    # -------------------------------------------------------------------------

    def create_directories(self):

        print()
        print("Creating missing directories")
        print("----------------------------------------")

        for directory in self.rules.get("directories", {}).get("required", []):

            self.mkdir(ROOT / directory)

    # -------------------------------------------------------------------------

    def rename_directories(self):

        print()
        print("Normalizing directory names")
        print("----------------------------------------")

        for item in self.rules.get("renames", []):

            self.rename(
                ROOT / item["from"],
                ROOT / item["to"]
            )

    # -------------------------------------------------------------------------

    def verify(self):

        print()
        print("Verification")
        print("----------------------------------------")

        failures = 0

        for directory in self.rules.get("directories", {}).get("required", []):

            path = ROOT / directory

            if path.exists():

                print(f"[PASS] {directory}")

            else:

                failures += 1

                print(f"[FAIL] {directory}")

        print()

        if failures:

            print("Repository NOT compliant.")
            return 1

        print("Repository compliant.")

        return 0

    # -------------------------------------------------------------------------

    def run(self):

        print()
        print("========================================")
        print(" Phoenix Repository Fixer")
        print("========================================")

        self.create_directories()

        self.rename_directories()

        print()

        if self.modified:

            print("Repository updated.")

        else:

            print("Repository already compliant.")

        return self.verify()


if __name__ == "__main__":

    sys.exit(
        RepositoryFixer().run()
    )