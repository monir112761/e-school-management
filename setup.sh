#!/bin/bash

# স্কুল ম্যানেজমেন্ট সিস্টেম সেটআপ স্ক্রিপ্ট (Linux/Mac)

echo ""
echo "========================================"
echo "স্কুল ম্যানেজমেন্ট সিস্টেম সেটআপ"
echo "========================================"
echo ""

# Check if PHP is installed
if ! command -v php &> /dev/null; then
    echo "❌ PHP is not installed"
    exit 1
fi

# Check if Composer is installed
if ! command -v composer &> /dev/null; then
    echo "❌ Composer is not installed"
    exit 1
fi

echo "✅ PHP এবং Composer ইনস্টল করা আছে"

echo ""
echo "[1/5] কম্পোজার ডিপেন্ডেন্সি ইনস্টল করছি..."
composer install
if [ $? -ne 0 ]; then
    echo "❌ কম্পোজার ইনস্টলেশন ব্যর্থ"
    exit 1
fi

echo "[2/5] .env ফাইল তৈরি করছি..."
if [ ! -f .env ]; then
    cp .env.example .env
    echo "✅ .env ফাইল তৈরি হয়েছে"
else
    echo "ℹ️  .env ফাইল ইতিমধ্যে আছে"
fi

echo "[3/5] অ্যাপ্লিকেশন কী জেনারেট করছি..."
php artisan key:generate --force

echo "[4/5] ডাটাবেস মাইগ্রেশন চালাচ্ছি..."
php artisan migrate --force
if [ $? -ne 0 ]; then
    echo "❌ মাইগ্রেশন ব্যর্থ। নিশ্চিত করুন যে ডাটাবেস সংযোগ সঠিক।"
    exit 1
fi

echo "[5/5] নমুনা ডেটা লোড করছি..."
php artisan db:seed --class=SchoolSeeder --force
if [ $? -ne 0 ]; then
    echo "❌ সিডিং ব্যর্থ"
    exit 1
fi

echo ""
echo "========================================"
echo "✅ সেটআপ সম্পন্ন হয়েছে!"
echo "========================================"
echo ""
echo "লগইন ক্রেডেনশিয়াল:"
echo ""
echo "Super Admin:"
echo "  Email: superadmin@example.com"
echo "  Password: password"
echo ""
echo "School Admin:"
echo "  Email: admin@demoschool.com"
echo "  Password: password"
echo ""
echo "Developer এ সার্ভার চালু করতে:"
echo "  php artisan serve"
echo ""
echo "তারপর ব্রাউজার এ যান: http://localhost:8000"
echo ""
