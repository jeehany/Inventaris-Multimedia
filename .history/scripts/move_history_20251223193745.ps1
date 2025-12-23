<#
Move `.history` folder into `backups` with timestamp.
Run this from the project root in PowerShell:
  .\scripts\move_history.ps1
#>
Param()

$proj = Split-Path -Path $PSScriptRoot -Parent
Set-Location $proj

$src = Join-Path $proj '.history'
if (-Not (Test-Path $src)) {
    Write-Host "No .history folder found at $src"
    exit 0
}

$ts = Get-Date -Format 'yyyyMMdd_HHmmss'
$dstRoot = Join-Path $proj 'backups'
if (-Not (Test-Path $dstRoot)) { New-Item -ItemType Directory -Path $dstRoot | Out-Null }

$dst = Join-Path $dstRoot ("history_$ts")
Write-Host "Moving .history -> $dst"
Move-Item -Path $src -Destination $dst

Write-Host "Move complete. Files moved to: $dst"
Write-Host "Please check the backups folder; if everything is good you can delete backups/history_* manually later."
