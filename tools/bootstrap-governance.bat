@echo off

REM ==========================================================
REM Phoenix Foundry
REM Work Order : WO-000004
REM Description: Governance Bootstrap
REM ==========================================================

cd /d C:\Projects

echo.
echo Creating Governance Structure...
echo.

REM ----------------------------------------------------------
REM Documentation
REM ----------------------------------------------------------

if not exist "docs" mkdir "docs"

if not exist "docs\constitution" mkdir "docs\constitution"
if not exist "docs\articles" mkdir "docs\articles"
if not exist "docs\principles" mkdir "docs\principles"
if not exist "docs\standards" mkdir "docs\standards"
if not exist "docs\adr" mkdir "docs\adr"
if not exist "docs\work-orders" mkdir "docs\work-orders"
if not exist "docs\architecture" mkdir "docs\architecture"
if not exist "docs\glossary" mkdir "docs\glossary"

REM ----------------------------------------------------------
REM Tools
REM ----------------------------------------------------------

if not exist "tools" mkdir "tools"

REM ----------------------------------------------------------
REM Initial Documents
REM ----------------------------------------------------------

if not exist "docs\constitution\Phoenix-Constitution.md" (
    type nul > "docs\constitution\Phoenix-Constitution.md"
)

echo.
echo ==========================================================
echo Phoenix Governance Structure created successfully.
echo ==========================================================
pause