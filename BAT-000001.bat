@echo off
setlocal EnableExtensions EnableDelayedExpansion

REM ============================================================================
REM Artifact ID : BAT-000001
REM Title       : Build Phoenix Workspace
REM Version     : 1.0.0
REM Work Order  : WO-000001
REM Purpose     : Build a compliant Phoenix workspace.
REM ============================================================================

title Phoenix - Build Workspace

REM ============================================================================
REM CONFIGURATION
REM ============================================================================

set "ROOT=C:\Projects"
set "PHOENIX=%ROOT%\Phoenix"

set CREATED=0
set EXISTING=0
set ERRORS=0

REM ============================================================================
REM BUILD ROOT
REM ============================================================================

if not exist "%ROOT%" (
    mkdir "%ROOT%"
    if errorlevel 1 (
        echo [ERROR  ] Unable to create %ROOT%
        exit /b 1
    )
)

if not exist "%PHOENIX%" (
    mkdir "%PHOENIX%"
    if errorlevel 1 (
        echo [ERROR  ] Unable to create %PHOENIX%
        exit /b 1
    )
)

REM ============================================================================
REM WORKSPACE STRUCTURE
REM ============================================================================

set DIRS=^
Kernel ^
Kernel\Manifest ^
Kernel\Builder ^
Kernel\Validator ^
Kernel\Registry ^
Kernel\Foundation ^
Standards ^
Foundry ^
Products ^
Releases ^
Reports ^
Workspace

echo.
echo ============================================================
echo                PHOENIX WORKSPACE BUILDER
echo ============================================================
echo.

echo Root      : %ROOT%
echo Workspace : %PHOENIX%
echo.

REM ============================================================================
REM ENGINE
REM ============================================================================

for %%D in (%DIRS%) do (

    if exist "%PHOENIX%\%%D" (

        echo [EXISTS ] %%D
        set /a EXISTING+=1

    ) else (

        mkdir "%PHOENIX%\%%D"

        if errorlevel 1 (

            echo [ERROR  ] %%D
            set /a ERRORS+=1

        ) else (

            echo [CREATE ] %%D
            set /a CREATED+=1

        )

    )

)

REM ============================================================================
REM VALIDATION
REM ============================================================================

echo.
echo Validating workspace...
echo.

for %%D in (%DIRS%) do (

    if exist "%PHOENIX%\%%D" (
        echo [ OK ] %%D
    ) else (
        echo [FAIL] %%D
        set /a ERRORS+=1
    )

)

REM ============================================================================
REM REPORT
REM ============================================================================

echo.
echo ============================================================
echo              PHOENIX WORKSPACE BUILD REPORT
echo ============================================================
echo.

echo Workspace : %PHOENIX%
echo.
echo Created   : %CREATED%
echo Existing  : %EXISTING%
echo Errors    : %ERRORS%
echo.

if %ERRORS% EQU 0 (
    echo RESULT    : SUCCESS
) else (
    echo RESULT    : FAILED
)

echo.
echo ============================================================

REM ============================================================================
REM EXIT
REM ============================================================================

if %ERRORS% EQU 0 (
    exit /b 0
) else (
    exit /b 1
)