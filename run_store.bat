@echo off
title Mechaboy Store Server - Launcher
echo ========================================================
echo       MECHABOY STORE SERVER - MINECRAFT STORE
echo ========================================================
echo.

set PHP_BIN=
if exist "C:\xampp\php\php.exe" (
    set PHP_BIN=C:\xampp\php\php.exe
) else (
    where php >nul 2>nul
    if %ERRORLEVEL% equ 0 (
        set PHP_BIN=php
    )
)

if defined PHP_BIN (
    echo [OK] PHP terdeteksi: %PHP_BIN%
    echo Memulai server lokal di http://localhost:8000 ...
    echo Tekan Ctrl+C di jendela ini untuk mematikan server.
    echo.
    start "" http://localhost:8000/index.php
    "%PHP_BIN%" -S localhost:8000
) else (
    echo [INFO] PHP tidak ditemukan di sistem, membuka index.html di browser...
    start "" index.html
    pause
)
