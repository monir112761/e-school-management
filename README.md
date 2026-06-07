# 📚 স্কুল ম্যানেজমেন্ট সিস্টেম - Laravel 12

একটি সম্পূর্ণ স্কুল ম্যানেজমেন্ট সিস্টেম যা মাল্টি-টেন্যান্সি সাপোর্ট করে এবং পাঁচটি আলাদা ভূমিকার প্যানেল রয়েছে।

## ✨ ফিচার

### 👥 পাঁচটি প্যানেল
- **Super Admin**: সকল স্কুল পরিচালনা, ডোমেইন কনফিগারেশন
- **Admin**: স্কুল-স্পেসিফিক সমস্ত অপারেশন
- **Teacher**: ক্লাস পরিচালনা, হাজিরা ও মার্কস এন্ট্রি
- **Student**: নিজের রেজাল্ট, হাজিরা, ফি স্ট্যাটাস দেখা
- **Guardian**: সন্তানের তথ্য পর্যবেক্ষণ

### 📋 মূল ফিচার
- ✅ মাল্টি-টেন্যান্সি (একাধিক স্কুল, আলাদা ডোমেইন)
- ✅ ভর্তি ম্যানেজমেন্ট
- ✅ শিক্ষার্থী/শিক্ষক পরিচালনা
- ✅ ক্লাস, সেকশন, বিষয় সেটআপ
- ✅ হাজিরা ট্র্যাকিং
- ✅ পরীক্ষা ও রেজাল্ট ম্যানেজমেন্ট
- ✅ ফি ম্যানেজমেন্ট
- ✅ এডমিট কার্ড জেনারেশন (PDF)
- ✅ ক্লাস রুটিন
- ✅ নোটিশ ও সার্কুলার
- ✅ শিক্ষকদের বেতন পরিচালনা
- ✅ রোল ম্যানেজমেন্ট

## 🚀 ইনস্টলেশন

### প্রয়োজনীয়তা
- PHP 8.3+
- MySQL 8.0+
- Composer
- Node.js (optional, for frontend)

### ধাপে ধাপে সেটআপ

```bash
# ১. প্রজেক্ট ডিরেক্টরিতে যান
cd d:\xampp\htdocs\e-school-management

# ২. কম্পোজার ডিপেন্ডেন্সি ইনস্টল করুন
composer install

# ৩. .env ফাইল তৈরি করুন
copy .env.example .env

# ৪. অ্যাপ কী জেনারেট করুন
php artisan key:generate

# ৫. ডাটাবেস মাইগ্রেশন চালান
php artisan migrate

# ৬. সিডার চালান (নমুনা ডেটা)
php artisan db:seed --class=SchoolSeeder

# ৭. ডেভেলপমেন্ট সার্ভার চালান
php artisan serve
```

## 📝 লগইন ক্রেডেনশিয়াল

সিডার চালানোর পর নিম্নলিখিত ক্রেডেনশিয়াল ব্যবহার করুন:

### Super Admin
- Email: `superadmin@example.com`
- Password: `password`
- URL: `http://localhost:8000/super-admin/dashboard`

### School Admin
- Email: `admin@demoschool.com`
- Password: `password`
- URL: `http://localhost:8000/admin/dashboard`

### Teachers (4 users)
- Email: `teacher1@demoschool.com` - `teacher4@demoschool.com`
- Password: `password` (all)
- URL: `http://localhost:8000/teacher/dashboard`

### Students (8 users)
- Email: `student1@demoschool.com` - `student8@demoschool.com`
- Password: `password` (all)
- URL: `http://localhost:8000/student/dashboard`

### Guardians (4 users)
- Email: `guardian1@demoschool.com` - `guardian4@demoschool.com`
- Password: `password` (all)
- URL: `http://localhost:8000/guardian/dashboard`

## 📂 প্রজেক্ট স্ট্রাকচার

```
app/
├── Models/              # ডাটাবেস মডেল
├── Http/
│   ├── Controllers/
│   │   ├── SuperAdmin/  # সুপার এডমিন কন্ট্রোলার
│   │   ├── Admin/       # এডমিন কন্ট্রোলার
│   │   ├── Teacher/     # শিক্ষক কন্ট্রোলার
│   │   ├── Student/     # শিক্ষার্থী কন্ট্রোলার
│   │   └── Guardian/    # অভিভাবক কন্ট্রোলার
│   └── Middleware/      # এক্সেস কন্ট্রোল মিডলওয়্যার
├── Traits/              # শেয়ারড ট্রেইট
└── Enums/               # এনাম ক্লাস

database/
├── migrations/          # ডাটাবেস স্কিমা
└── seeders/            # স্যাম্পল ডেটা

resources/
└── views/              # ব্লেড টেমপ্লেট
    ├── super-admin/    # সুপার এডমিন ভিউ
    ├── admin/          # এডমিন ভিউ
    ├── teacher/        # শিক্ষক ভিউ
    ├── student/        # শিক্ষার্থী ভিউ
    └── guardian/       # অভিভাবক ভিউ
```

## 🔧 কনফিগারেশন

### মাল্টি-টেন্যান্সি সেটআপ

প্রতিটি স্কুলের জন্য আলাদা ডোমেইন সেটআপ করুন:

1. হোস্ট ফাইল এডিট করুন (`C:\Windows\System32\drivers\etc\hosts`):
```
127.0.0.1  demo.school.local
127.0.0.1  yourschool.school.local
```

2. Apache vhost কনফিগার করুন (XAMPP):
```apache
<VirtualHost *:80>
    ServerName demo.school.local
    DocumentRoot "D:/xampp/htdocs/e-school-management/public"
    <Directory "D:/xampp/htdocs/e-school-management/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

## 🗄️ ডাটাবেস স্কিমা

### প্রধান টেবিল
- `schools` - স্কুল তথ্য
- `users` - সমস্ত ব্যবহারকারী (ভূমিকা সহ)
- `classes` - ক্লাস
- `sections` - সেকশন
- `subjects` - বিষয়
- `students` - শিক্ষার্থী
- `teachers` - শিক্ষক
- `guardians` - অভিভাবক
- `attendances` - হাজিরা রেকর্ড
- `exams` - পরীক্ষা
- `results` - ফলাফল
- `fees` - ফি কাঠামো
- `fee_payments` - ফি পেমেন্ট
- `admit_cards` - এডমিট কার্ড
- `class_routines` - ক্লাস রুটিন
- `salary_records` - শিক্ষকদের বেতন
- `notices` - নোটিশ
- `admissions` - ভর্তি আবেদন

## 🔐 সিকিউরিটি

- ✅ CSRF প্রোটেকশন
- ✅ রোল-বেসড এক্সেস কন্ট্রোল (RBAC)
- ✅ স্কুল-লেভেল ডেটা আইসোলেশন
- ✅ প্যাসওয়ার্ড হ্যাশিং (bcrypt)
- ✅ SQL ইনজেকশন প্রোটেকশন

## 📦 প্যাকেজ

এই প্রজেক্ট ব্যবহার করে:
- `stancl/tenancy` - মাল্টি-টেন্যান্সি
- `spatie/laravel-permission` - পারমিশন ম্যানেজমেন্ট
- `barryvdh/laravel-dompdf` - PDF জেনারেশন
- `intervention/image` - ইমেজ প্রসেসিং

## 🚀 এক্সটেনশন ও উন্নতি

### পরবর্তী ধাপে যোগ করুন:
- [ ] এসএমএস নোটিফিকেশন (Twilio/Nexmo)
- [ ] ইমেইল নোটিফিকেশন
- [ ] API এন্ডপয়েন্ট (Mobile App এর জন্য)
- [ ] অনলাইন পেমেন্ট গেটওয়ে
- [ ] অনলাইন পরীক্ষা (Exam System)
- [ ] ভিডিও ক্লাস ইন্টিগ্রেশন
- [ ] লাইভ হোমওয়ার্ক ট্র্যাকিং
- [ ] পেরেন্ট-টিচার কমিউনিকেশন

## 🐛 ট্রাবলশুটিং

### লগইন সমস্যা
```bash
# ক্যাশ ক্লিয়ার করুন
php artisan cache:clear
php artisan config:clear
```

### মাইগ্রেশন ত্রুটি
```bash
# রোলব্যাক এবং পুনরায় চালান
php artisan migrate:reset
php artisan migrate
php artisan db:seed --class=SchoolSeeder
```

## 📞 সাপোর্ট

প্রশ্ন বা সমস্যার জন্য রিপোর্ট করুন।

## 📄 লাইসেন্স

এই প্রজেক্ট সম্পূর্ণভাবে উন্মুক্ত এবং ব্যবহারের জন্য স্বাধীন।

---

**শুভ কোডিং! 🎉**
