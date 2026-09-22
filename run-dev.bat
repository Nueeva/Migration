@echo off
title Kasir & Inventory App Launcher
echo ====================================================
echo  Menjalankan Aplikasi POS Kasir & Backend Laravel
echo ====================================================

echo [1/2] Memastikan Storage Link & Cache...
cd /d C:\laragon\www\Migration\crud-laravel
"C:\laragon\bin\php\php-8.3.33-Win32-vs16-x64\php.exe" artisan optimize:clear

echo [2/2] Menjalankan Frontend Nuxt di http://localhost:3000...
cd /d C:\laragon\www\Migration\kasir-frontend
npm run dev

pause
