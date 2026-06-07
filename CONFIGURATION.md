# ⚙️ কনফিগারেশন গাইড

এই ডকুমেন্ট আপনাকে স্কুল ম্যানেজমেন্ট সিস্টেম সেটআপ করতে সাহায্য করবে।

## 🔧 Environment ভেরিয়েবল (.env)

`.env` ফাইল তৈরি করুন এবং নিম্নলিখিত ভেরিয়েবল সেট করুন:

```env
APP_NAME="School Management System"
APP_ENV=local
APP_KEY=base64:YOUR_APP_KEY_HERE  # php artisan key:generate দিয়ে জেনারেট করুন
APP_DEBUG=true  # প্রোডাকশনে false করুন
APP_URL=http://localhost:8000

# ডাটাবেস কনফিগারেশন
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=e_school_management
DB_USERNAME=root
DB_PASSWORD=

# মেইল কনফিগারেশন (ভবিষ্যতে)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS=noreply@example.com
MAIL_FROM_NAME="School Management"

# ক্যাশ কনফিগারেশন
CACHE_DRIVER=file
CACHE_STORE=file

# সেশন কনফিগারেশন
SESSION_DRIVER=file

# কিউ কনফিগারেশন
QUEUE_CONNECTION=sync

# ফাইল স্টোরেজ
FILESYSTEM_DISK=local

# মাল্টি-টেন্যান্সি (Stancl)
TENANCY_HOST=*.school.local
TENANCY_DOMAIN=school.local

# JWT টোকেন সিক্রেট (API এর জন্য)
JWT_SECRET=your_jwt_secret_here
```

## 🗄️ ডাটাবেস সেটআপ

### MySQL ডাটাবেস তৈরি করুন

```sql
CREATE DATABASE e_school_management CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
GRANT ALL PRIVILEGES ON e_school_management.* TO 'root'@'localhost';
FLUSH PRIVILEGES;
```

### মাইগ্রেশন চালান

```bash
php artisan migrate
```

### নমুনা ডেটা লোড করুন

```bash
php artisan db:seed --class=SchoolSeeder
```

## 🌐 মাল্টি-টেন্যান্সি ডোমেইন সেটআপ

### Windows (XAMPP এ)

#### 1. Host ফাইল এডিট করুন
`C:\Windows\System32\drivers\etc\hosts` খুলুন এবং নিম্নলিখিত যোগ করুন:

```
127.0.0.1  demo.school.local
127.0.0.1  school1.school.local
127.0.0.1  school2.school.local
127.0.0.1  yourschool.school.local
```

#### 2. Apache Virtual Host সেটআপ
`D:\xampp\apache\conf\extra\httpd-vhosts.conf` তে যোগ করুন:

```apache
<VirtualHost *:80>
    ServerName *.school.local
    DocumentRoot "D:/xampp/htdocs/e-school-management/public"
    <Directory "D:/xampp/htdocs/e-school-management/public">
        AllowOverride All
        Require all granted
        <IfModule mod_rewrite.c>
            RewriteEngine On
            RewriteBase /
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteCond %{REQUEST_FILENAME} !-d
            RewriteRule ^(.*)$ index.php [L]
        </IfModule>
    </Directory>
</VirtualHost>
```

#### 3. Apache পুনরায় শুরু করুন
XAMPP Control Panel থেকে Apache পুনরায় শুরু করুন।

#### 4. ব্রাউজারে পরীক্ষা করুন
- http://demo.school.local
- http://school1.school.local

### Linux/Mac

#### 1. /etc/hosts এডিট করুন
```bash
sudo nano /etc/hosts
```

যোগ করুন:
```
127.0.0.1  demo.school.local
127.0.0.1  school1.school.local
127.0.0.1  school2.school.local
```

#### 2. Apache/Nginx Virtual Host সেটআপ

**Apache:**
```bash
sudo nano /etc/apache2/sites-available/school-management.conf
```

```apache
<VirtualHost *:80>
    ServerName *.school.local
    DocumentRoot /var/www/e-school-management/public
    <Directory /var/www/e-school-management/public>
        AllowOverride All
        Require all granted
        <IfModule mod_rewrite.c>
            RewriteEngine On
            RewriteBase /
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteCond %{REQUEST_FILENAME} !-d
            RewriteRule ^(.*)$ index.php [L]
        </IfModule>
    </Directory>
</VirtualHost>
```

সক্ষম করুন:
```bash
sudo a2ensite school-management
sudo systemctl restart apache2
```

**Nginx:**
```bash
sudo nano /etc/nginx/sites-available/school-management
```

```nginx
server {
    listen 80;
    server_name *.school.local;
    
    root /var/www/e-school-management/public;
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcript_name;
        include fastcgi_params;
    }
}
```

সক্ষম করুন:
```bash
sudo ln -s /etc/nginx/sites-available/school-management /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

## 🔑 পারমিশন এবং সিকিউরিটি

### Laravel ডিরেক্টরি পারমিশন

```bash
# Linux/Mac
chmod -R 755 storage bootstrap/cache
chmod -R 777 storage bootstrap/cache

# Windows (PowerShell)
# সাধারণত ডিফল্ট পারমিশন ঠিক আছে
```

## 🔐 SSL/HTTPS সেটআপ (প্রোডাকশনে)

### Let's Encrypt সার্টিফিকেট ব্যবহার করুন

```bash
# Certbot ইনস্টল করুন
sudo apt-get install certbot python3-certbot-apache

# সার্টিফিকেট জেনারেট করুন
sudo certbot certonly --apache -d demo.school.local -d school1.school.local
```

### .env এ আপডেট করুন
```env
APP_URL=https://demo.school.local
```

## 📦 প্যাকেজ কনফিগারেশন

### 1. Spatie Laravel Permission

সেটআপ করুন:
```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
```

### 2. Stancl Tenancy

সেটআপ করুন:
```bash
php artisan tenancy:install
php artisan migrate --path=database/migrations/tenant
```

### 3. DOMPDF (PDF জেনারেশন)

সেটআপ করুন:
```bash
php artisan vendor:publish --tag=dompdf
```

## 🗂️ ফাইল আপলোড সেটআপ

### সিম্বলিক লিঙ্ক তৈরি করুন

```bash
php artisan storage:link
```

এটি `public/storage` থেকে `storage/app/public` এ একটি সিম্বলিক লিঙ্ক তৈরি করে।

### ফাইল পারমিশন (Linux)

```bash
sudo chown -R www-data:www-data storage
sudo chmod -R 775 storage
sudo chmod -R 775 public/storage
```

## 📝 কাস্টম কনফিগারেশন ফাইল

### config/school.php তৈরি করুন

```php
<?php

return [
    // স্কুল সেটিংস
    'default_timezone' => 'Asia/Dhaka',
    'academic_year' => 2024,
    
    // হাজিরা সেটিংস
    'attendance' => [
        'minimum_percentage' => 75,
        'warning_percentage' => 80,
    ],
    
    // ফি সেটিংস
    'fees' => [
        'late_fee_percentage' => 5,
        'due_date_notification_days' => 7,
    ],
    
    // পরীক্ষা সেটিংস
    'exam' => [
        'min_marks' => 0,
        'max_marks' => 100,
        'passing_percentage' => 50,
    ],
    
    // গ্রেডিং সেটিংস
    'grading' => [
        'A+' => [90, 100],
        'A' => [80, 89],
        'B' => [70, 79],
        'C' => [60, 69],
        'D' => [50, 59],
        'F' => [0, 49],
    ],
];
```

## 🧪 টেস্টিং সেটআপ

### PHPUnit কনফিগারেশন

`phpunit.xml` তে:
```xml
<env name="DB_CONNECTION" value="sqlite"/>
<env name="DB_DATABASE" value=":memory:"/>
```

### টেস্ট চালান

```bash
php artisan test
```

## 🚀 প্রোডাকশন ডিপ্লয়মেন্ট

### Optimizations

```bash
# কনফিগ ক্যাশ করুন
php artisan config:cache

# রুট ক্যাশ করুন
php artisan route:cache

# ভিউ কম্পাইল করুন
php artisan view:cache

# অটোলোডার অপটিমাইজ করুন
composer install --optimize-autoloader --no-dev
```

### সুপারভাইজার সেটআপ (Queue এর জন্য)

```bash
# Supervisor ইনস্টল করুন
sudo apt-get install supervisor

# কনফিগারেশন ফাইল তৈরি করুন
sudo nano /etc/supervisor/conf.d/school-queue.conf
```

```ini
[program:school-queue]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/app/artisan queue:work
autostart=true
autorestart=true
numprocs=1
redirect_stderr=true
stdout_logfile=/var/log/school-queue.log
```

## 🔍 Debugging এবং Logging

### .env এ লগিং সেটআপ করুন

```env
LOG_CHANNEL=stack
LOG_STACK=single,daily
LOG_DAILY_PATH=storage/logs/laravel-%Y-%m-%d.log
LOG_LEVEL=debug
```

### Laravel Telescope (Development)

ইনস্টল করুন:
```bash
composer require laravel/telescope --dev
php artisan telescope:install
php artisan migrate
```

অ্যাক্সেস করুন: `http://localhost:8000/telescope`

## 📞 সমস্যা সমাধান

### অনুমতি সমস্যা
```bash
sudo chown -R $USER:$USER /path/to/project
chmod -R 755 storage bootstrap/cache
chmod -R 777 storage bootstrap/cache
```

### মাইগ্রেশন ত্রুটি
```bash
php artisan migrate:reset
php artisan migrate
php artisan db:seed
```

### ক্যাশ সমস্যা
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

**আরও সহায়তার জন্য Laravel ডকুমেন্টেশন দেখুন: https://laravel.com/docs**
