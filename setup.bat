@echo off
REM Kiểm tra Composer có sẵn không
where composer >nul 2>&1
IF ERRORLEVEL 1 (
    echo Composer khong tim thay. Vui long cai dat Composer truoc.
    pause
    exit /b 1
)

REM Chạy composer install
echo Dang chay composer install...
composer install

REM Hoan tat
echo Da hoan tat!
pause
