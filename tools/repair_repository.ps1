<#
------------------------------------------------------------------------------
Repository Path
------------------------------------------------------------------------------
C:\Projects\tools\repair_repository.ps1

Purpose
------------------------------------------------------------------------------
Repairs the Phoenix repository structure, moves folders to their expected
locations, validates the result, and prints a completion message.

Usage
------------------------------------------------------------------------------
PowerShell:
    powershell -ExecutionPolicy Bypass -File C:\Projects\tools\repair_repository.ps1
------------------------------------------------------------------------------
#>

$ErrorActionPreference = "Stop"

$Repository = "C:\Projects"

Write-Host ""
Write-Host "========================================="
Write-Host " Phoenix Repository Repair"
Write-Host "========================================="
Write-Host ""

if (!(Test-Path $Repository))
{
    Write-Error "Repository not found:"
    Write-Error $Repository
    exit 1
}

Set-Location $Repository

function Ensure-Folder
{
    param([string]$Folder)

    if (!(Test-Path $Folder))
    {
        New-Item -ItemType Directory -Path $Folder | Out-Null
        Write-Host "[CREATE] $Folder"
    }
}

function Move-IfExists
{
    param(
        [string]$Source,
        [string]$Destination
    )

    if (Test-Path $Source)
    {
        Ensure-Folder (Split-Path $Destination)

        if (!(Test-Path $Destination))
        {
            Move-Item $Source $Destination
            Write-Host "[MOVE] $Source"
            Write-Host "       -> $Destination"
        }
        else
        {
            Write-Host "[SKIP] Destination already exists:"
            Write-Host "       $Destination"
        }
    }
}

Write-Host ""
Write-Host "Creating required folders..."
Write-Host ""

Ensure-Folder "C:\Projects\Phoenix\CLI"
Ensure-Folder "C:\Projects\Phoenix\Commands"
Ensure-Folder "C:\Projects\Phoenix\Foundry"
Ensure-Folder "C:\Projects\Phoenix\Kernel"
Ensure-Folder "C:\Projects\Phoenix\Support"
Ensure-Folder "C:\Projects\Phoenix\Workspace"

Ensure-Folder "C:\Projects\Workspace"
Ensure-Folder "C:\Projects\Reports"
Ensure-Folder "C:\Projects\tools"

Write-Host ""
Write-Host "Moving misplaced folders..."
Write-Host ""

Move-IfExists `
"C:\Projects\CLI" `
"C:\Projects\Phoenix\CLI"

Move-IfExists `
"C:\Projects\Commands" `
"C:\Projects\Phoenix\Commands"

Move-IfExists `
"C:\Projects\Foundry" `
"C:\Projects\Phoenix\Foundry"

Move-IfExists `
"C:\Projects\Kernel" `
"C:\Projects\Phoenix\Kernel"

Move-IfExists `
"C:\Projects\Support" `
"C:\Projects\Phoenix\Support"

Move-IfExists `
"C:\Projects\Workspace" `
"C:\Projects\Phoenix\Workspace"

Write-Host ""
Write-Host "Repository structure"
Write-Host "------------------------------"
Write-Host ""

tree C:\Projects /F

Write-Host ""
Write-Host "Validation"
Write-Host "------------------------------"

$Required = @(
"C:\Projects\Phoenix",
"C:\Projects\Phoenix\CLI",
"C:\Projects\Phoenix\Commands",
"C:\Projects\Phoenix\Kernel",
"C:\Projects\Phoenix\Foundry",
"C:\Projects\Phoenix\Support",
"C:\Projects\Phoenix\Workspace",
"C:\Projects\tools"
)

$Failed = $false

foreach($Folder in $Required)
{
    if(Test-Path $Folder)
    {
        Write-Host "[PASS] $Folder"
    }
    else
    {
        Write-Host "[FAIL] $Folder"
        $Failed = $true
    }
}

Write-Host ""

if($Failed)
{
    Write-Host "Repository repair NOT completed."
    exit 1
}

Write-Host "========================================="
Write-Host " Repository repaired successfully"
Write-Host "========================================="
Write-Host ""
Write-Host "The repository structure is valid."
Write-Host ""
Write-Host "This Work Order can now be closed."
Write-Host ""
exit 0