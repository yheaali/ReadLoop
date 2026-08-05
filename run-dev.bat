@echo off
chcp 65001 >nul
cd /d "%~dp0"

set "PHP_EXE="
where php >nul 2>&1 && set "PHP_EXE=php"
if not defined PHP_EXE if exist "C:\xampp\php\php.exe" set "PHP_EXE=C:\xampp\php\php.exe"
if not defined PHP_EXE (
    echo لم يُعثر على PHP. أضف PHP إلى PATH أو ثبّت XAMPP في C:\xampp
    echo PHP not found. Add PHP to PATH or install XAMPP at C:\xampp
    pause
    exit /b 1
)

echo تشغيل الخوادم من المجلد:
echo %CD%
echo.

if /i "%PHP_EXE%"=="php" (
    start "BookForum - Laravel" /D "%~dp0" cmd /k php artisan serve
) else (
    start "BookForum - Laravel" /D "%~dp0" cmd /k ""%PHP_EXE%" artisan serve"
)
timeout /t 2 /nobreak >nul
start "BookForum - Vite" /D "%~dp0" cmd /k "npm run dev"
timeout /t 3 /nobreak >nul
start "" "http://127.0.0.1:8000"

echo.
echo فُتحت نافذتان: Laravel و Vite. المتصفح: http://127.0.0.1:8000
echo Close both windows to stop.
pause
