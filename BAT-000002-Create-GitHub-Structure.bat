@echo off
setlocal EnableDelayedExpansion

echo.
echo ============================================
echo     Phoenix Foundry GitHub Bootstrap
echo ============================================
echo.

REM --------------------------------------------------
REM Repository Root
REM --------------------------------------------------

set ROOT=%CD%

REM --------------------------------------------------
REM Remove placeholder .github file
REM --------------------------------------------------

if exist "%ROOT%\.github" (
    if not exist "%ROOT%\.github\" (
        echo Removing placeholder .github file...
        del "%ROOT%\.github"
    )
)

REM --------------------------------------------------
REM Create directories
REM --------------------------------------------------

echo.
echo Creating directories...

mkdir ".github" 2>nul
mkdir ".github\ISSUE_TEMPLATE" 2>nul
mkdir ".github\workflows" 2>nul

REM --------------------------------------------------
REM Helper
REM --------------------------------------------------

call :CreateFile ".github\CODEOWNERS"
call :CreateFile ".github\CONTRIBUTING.md"
call :CreateFile ".github\SECURITY.md"
call :CreateFile ".github\SUPPORT.md"
call :CreateFile ".github\dependabot.yml"
call :CreateFile ".github\FUNDING.yml"
call :CreateFile ".github\pull_request_template.md"

call :CreateFile ".github\ISSUE_TEMPLATE\bug_report.md"
call :CreateFile ".github\ISSUE_TEMPLATE\feature_request.md"
call :CreateFile ".github\ISSUE_TEMPLATE\governance_change.md"
call :CreateFile ".github\ISSUE_TEMPLATE\work_order.md"
call :CreateFile ".github\ISSUE_TEMPLATE\config.yml"

call :CreateFile ".github\workflows\ci.yml"
call :CreateFile ".github\workflows\codeql.yml"
call :CreateFile ".github\workflows\documentation.yml"
call :CreateFile ".github\workflows\release.yml"
call :CreateFile ".github\workflows\repository-health.yml"
call :CreateFile ".github\workflows\standards.yml"

echo.
echo ============================================
echo GitHub structure successfully created.
echo ============================================
goto :EOF

:CreateFile

if exist "%~1" (
    echo [OK] %~1
) else (
    echo.>"%~1"
    echo [NEW] %~1
)

exit /b