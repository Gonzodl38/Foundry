@echo off
setlocal EnableDelayedExpansion

REM ============================================================================
REM Repository Path:
REM C:\phoenix\repair_structure.bat
REM ----------------------------------------------------------------------------
REM Purpose:
REM Repairs the Phoenix repository structure, verifies the result,
REM and reports success or failure.
REM ============================================================================

set ROOT=C:\phoenix

echo.
echo ==========================================================
echo Phoenix Repository Structure Repair
echo ==========================================================
echo.

if not exist "%ROOT%" (
    echo ERROR: Repository not found.
    echo Expected:
    echo %ROOT%
    pause
    exit /b 1
)

cd /d "%ROOT%"

echo Repository:
echo %CD%
echo.

REM ============================================================================
REM Create required folders
REM ============================================================================

for %%D in (

"Projects\Phoenix\CLI"
"Projects\Phoenix\Commands"
"Projects\Phoenix\Foundry\Artifact"
"Projects\Phoenix\Foundry\Planner"
"Projects\Phoenix\Foundry\Executor"
"Projects\Phoenix\Foundry\Verifier"
"Projects\Phoenix\Kernel\Transaction"
"Projects\Phoenix\Kernel\Certification"
"Projects\Phoenix\Workspace\Kanban"

) do (

    if not exist %%~D (
        mkdir %%~D
    )

)

REM ============================================================================
REM Verify mandatory folders
REM ============================================================================

set FAILED=0

call :CHECK "Projects\Phoenix\CLI"
call :CHECK "Projects\Phoenix\Commands"
call :CHECK "Projects\Phoenix\Foundry"
call :CHECK "Projects\Phoenix\Kernel"
call :CHECK "Projects\Phoenix\Workspace"
call :CHECK "Projects\tools"

echo.

if "%FAILED%"=="1" (
    echo ==========================================================
    echo STRUCTURE VERIFICATION FAILED
    echo ==========================================================
    pause
    exit /b 1
)

echo ==========================================================
echo STRUCTURE VERIFIED
echo ==========================================================
echo.

tree Projects /A

echo.
echo ==========================================================
echo WORK ORDER COMPLETED
echo.
echo Repository structure repaired successfully.
echo You may now close this Work Order.
echo ==========================================================
pause
exit /b 0

:CHECK

if exist %1 (
    echo [OK] %1
) else (
    echo [ERROR] %1
    set FAILED=1
)

exit /b