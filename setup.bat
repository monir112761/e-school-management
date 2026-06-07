@echo off
REM স্কুল ম্যানেজমেন্ট সিস্টেম সেটআপ স্ক্রিপ্ট
REM This script automates the installation process

SETLOCAL EnableDelayedExpansion

ECHO.
ECHO ========================================
ECHO স্কুল ম্যানেজমেন্ট সিস্টেম সেটআপ
ECHO ========================================
ECHO.

REM Check if PHP is installed
php -v >nul 2>&1
if errorlevel 1 (
    ECHO ❌ PHP is not installed or not in PATH
    pause
    exit /b 1
)

REM Check if Composer is installed
composer -v >nul 2>&1
if errorlevel 1 (
    ECHO ❌ Composer is not installed or not in PATH
    pause
    exit /b 1
)

ECHO ✅ PHP এবং Composer ইনস্টল করা আছে

ECHO.
ECHO [1/5] কম্পোজার ডিপেন্ডেন্সি ইনস্টল করছি...
composer install
if errorlevel 1 (
    ECHO ❌ কম্পোজার ইনস্টলেশন ব্যর্থ
    pause
    exit /b 1
)

ECHO [2/5] .env ফাইল তৈরি করছি...
if not exist .env (
    copy .env.example .env
    ECHO ✅ .env ফাইল তৈরি হয়েছে
) else (
    ECHO ℹ️  .env ফাইল ইতিমধ্যে আছে
)

ECHO [3/5] অ্যাপ্লিকেশন কী জেনারেট করছি...
php artisan key:generate --force

ECHO [4/5] ডাটাবেস মাইগ্রেশন চালাচ্ছি...
php artisan migrate --force
if errorlevel 1 (
    ECHO ❌ মাইগ্রেশন ব্যর্থ। নিশ্চিত করুন যে ডাটাবেস সংযোগ সঠিক।
    pause
    exit /b 1
)

ECHO [5/5] নমুনা ডেটা লোড করছি...
php artisan db:seed --class=SchoolSeeder --force
if errorlevel 1 (
    ECHO ❌ সিডিং ব্যর্থ
    pause
    exit /b 1
)

ECHO.
ECHO ========================================
ECHO ✅ সেটআপ সম্পন্ন হয়েছে!
ECHO ========================================
ECHO.
ECHO লগইন ক্রেডেনশিয়াল:
ECHO.
ECHO Super Admin:
ECHO   Email: superadmin@example.com
ECHO   Password: password
ECHO.
ECHO School Admin:
ECHO   Email: admin@demoschool.com
ECHO   Password: password
ECHO.
ECHO Developer এ সার্ভার চালু করতে:
ECHO   php artisan serve
ECHO.
ECHO তারপর ব্রাউজার এ যান: http://localhost:8000
ECHO.
pause
