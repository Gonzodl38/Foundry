#!/usr/bin/env python3
# ==============================================================================
# Repository Path:
# C:\Projects\tools\repository_auditor.py
#
# Purpose:
# Audits the Phoenix repository against the repository standard.
#
# Usage:
#     python repository_auditor.py
#
# Exit Codes:
#     0 = PASS
#     1 = FAIL
# ==============================================================================

from pathlib import Path
import json
import sys

ROOT = Path(r"C:\Projects")

EXPECTED_DIRECTORIES = [
    "Phoenix",
    "Phoenix/Application",
    "Phoenix/Bootstrap",
    "Phoenix/CLI",
    "Phoenix/Commands",
    "Phoenix/Configuration",
    "Phoenix/Container",
    "Phoenix/Foundry",
    "Phoenix/Kernel",
    "Phoenix/Products",
    "Phoenix/Releases",
    "Phoenix/Reports",
    "Phoenix/Support",
    "Phoenix/Workspace",
    "docs",
    "tools",
    "vendor"
]

EXPECTED_FILES = [
    "composer.json",
    "tools/phoenix.php"
]


class RepositoryAuditor:

    def __init__(self):

        self.errors = []
        self.warnings = []
        self.report = {
            "directories": [],
            "files": [],
            "warnings": [],
            "result": "PASS"
        }

    # -----------------------------------------------------------------

    def exists(self, relative):

        return (ROOT / relative).exists()

    # -----------------------------------------------------------------

    def audit_directories(self):

        print()
        print("Directories")
        print("-------------------------------------")

        for directory in EXPECTED_DIRECTORIES:

            if self.exists(directory):

                print(f"[PASS] {directory}")

                self.report["directories"].append({
                    "path": directory,
                    "status": "PASS"
                })

            else:

                print(f"[FAIL] {directory}")

                self.errors.append(directory)

                self.report["directories"].append({
                    "path": directory,
                    "status": "FAIL"
                })

    # -----------------------------------------------------------------

    def audit_files(self):

        print()
        print("Files")
        print("-------------------------------------")

        for filename in EXPECTED_FILES:

            if self.exists(filename):

                print(f"[PASS] {filename}")

                self.report["files"].append({
                    "path": filename,
                    "status": "PASS"
                })

            else:

                print(f"[FAIL] {filename}")

                self.errors.append(filename)

                self.report["files"].append({
                    "path": filename,
                    "status": "FAIL"
                })

    # -----------------------------------------------------------------

    def audit_duplicate_docs(self):

        print()
        print("Documentation")
        print("-------------------------------------")

        duplicates = [

            ("docs/Governance", "docs/governance"),

            ("docs/Guides", "docs/guides"),

            ("docs/Reference", "docs/reference"),

            ("docs/specification", "docs/specifications"),
        ]

        for old, new in duplicates:

            old_exists = self.exists(old)

            new_exists = self.exists(new)

            if old_exists and new_exists:

                warning = f"Duplicate: {old} / {new}"

                print("[WARNING]", warning)

                self.warnings.append(warning)

            elif old_exists:

                warning = f"Rename recommended: {old} -> {new}"

                print("[WARNING]", warning)

                self.warnings.append(warning)

    # -----------------------------------------------------------------

    def write_report(self):

        report_folder = ROOT / "Phoenix" / "Reports"

        report_folder.mkdir(parents=True, exist_ok=True)

        report_file = report_folder / "repository_audit.json"

        self.report["warnings"] = self.warnings

        if self.errors:
            self.report["result"] = "FAIL"

        with open(report_file, "w", encoding="utf8") as fp:

            json.dump(
                self.report,
                fp,
                indent=4
            )

        print()
        print("Report")
        print("-------------------------------------")
        print(report_file)

    # -----------------------------------------------------------------

    def finish(self):

        print()
        print("=====================================")

        if self.errors:

            print("RESULT : FAIL")

            print(f"{len(self.errors)} error(s)")

            return 1

        print("RESULT : PASS")

        print("Repository certified.")

        return 0

    # -----------------------------------------------------------------

    def run(self):

        print()
        print("=====================================")
        print("Phoenix Repository Auditor")
        print("=====================================")

        self.audit_directories()

        self.audit_files()

        self.audit_duplicate_docs()

        self.write_report()

        return self.finish()


# ==============================================================================

if __name__ == "__main__":

    sys.exit(
        RepositoryAuditor().run()
    )