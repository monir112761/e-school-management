# 🔌 API ডকুমেন্টেশন

এই ডকুমেন্ট সম্পূর্ণ API এন্ডপয়েন্ট এবং ব্যবহারের নির্দেশনা প্রদান করে।

## 🎯 বেস URL

```
http://localhost:8000
```

## 🔐 অথেন্টিকেশন

সমস্ত রক্ষিত রুট এর জন্য প্রথমে লগইন করুন। সিস্টেম সেশন-ভিত্তিক অথেন্টিকেশন ব্যবহার করে।

## 📊 এন্ডপয়েন্ট

### 👤 অথেন্টিকেশন
```
POST   /login                  # লগইন
POST   /logout                 # লগআউট
POST   /register              # রেজিস্টার (উপলব্ধ থাকলে)
GET    /dashboard             # রোল অনুযায়ী ড্যাশবোর্ড রিডিরেক্ট
```

### 🏢 Super Admin Routes

#### স্কুল ম্যানেজমেন্ট
```
GET    /super-admin/schools              # সকল স্কুল দেখুন
POST   /super-admin/schools              # নতুন স্কুল তৈরি করুন
GET    /super-admin/schools/{id}         # স্কুল বিস্তারিত দেখুন
GET    /super-admin/schools/{id}/edit    # স্কুল এডিট ফর্ম
PUT    /super-admin/schools/{id}         # স্কুল আপডেট করুন
DELETE /super-admin/schools/{id}         # স্কুল ডিলিট করুন
```

### 🎓 Admin Routes

#### ড্যাশবোর্ড
```
GET    /admin/dashboard        # এডমিন ড্যাশবোর্ড
```

#### ক্লাস ম্যানেজমেন্ট
```
GET    /admin/classes              # সকল ক্লাস
POST   /admin/classes              # নতুন ক্লাস তৈরি
GET    /admin/classes/{id}         # ক্লাস বিস্তারিত
GET    /admin/classes/{id}/edit    # ক্লাস এডিট ফর্ম
PUT    /admin/classes/{id}         # ক্লাস আপডেট
DELETE /admin/classes/{id}         # ক্লাস ডিলিট
```

#### বিষয় ম্যানেজমেন্ট
```
GET    /admin/subjects              # সকল বিষয়
POST   /admin/subjects              # নতুন বিষয় তৈরি
GET    /admin/subjects/{id}         # বিষয় বিস্তারিত
GET    /admin/subjects/{id}/edit    # বিষয় এডিট ফর্ম
PUT    /admin/subjects/{id}         # বিষয় আপডেট
DELETE /admin/subjects/{id}         # বিষয় ডিলিট
```

#### শিক্ষার্থী ম্যানেজমেন্ট
```
GET    /admin/students              # সকল শিক্ষার্থী
POST   /admin/students              # নতুন শিক্ষার্থী তৈরি
GET    /admin/students/{id}         # শিক্ষার্থী বিস্তারিত
GET    /admin/students/{id}/edit    # শিক্ষার্থী এডিট ফর্ম
PUT    /admin/students/{id}         # শিক্ষার্থী আপডেট
DELETE /admin/students/{id}         # শিক্ষার্থী ডিলিট
```

#### হাজিরা ম্যানেজমেন্ট
```
GET    /admin/attendance                 # হাজিরা ইন্ডেক্স
GET    /admin/attendance/create          # হাজিরা ফর্ম (ক্লাস, সেকশন, তারিখ পরামিতি)
POST   /admin/attendance                 # হাজিরা সংরক্ষণ
```

**প্রয়োজনীয় পরামিতি:**
```
class_id=1&section_id=1&date=2024-01-01
```

**পোস্ট ডেটা:**
```json
{
  "class_id": 1,
  "section_id": 1,
  "attendance_date": "2024-01-01",
  "attendance": [
    {
      "student_id": 1,
      "status": "present",
      "remarks": "ঠিক আছে"
    },
    {
      "student_id": 2,
      "status": "absent",
      "remarks": "অনুমতি ছাড়া"
    }
  ]
}
```

#### পরীক্ষা ম্যানেজমেন্ট
```
GET    /admin/exams              # সকল পরীক্ষা
POST   /admin/exams              # নতুন পরীক্ষা তৈরি
GET    /admin/exams/{id}         # পরীক্ষা বিস্তারিত
GET    /admin/exams/{id}/edit    # পরীক্ষা এডিট ফর্ম
PUT    /admin/exams/{id}         # পরীক্ষা আপডেট
DELETE /admin/exams/{id}         # পরীক্ষা ডিলিট
```

**পোস্ট/পুট ডেটা:**
```json
{
  "name": "বার্ষিক পরীক্ষা ২০২৪",
  "description": "বার্ষিক পরীক্ষা",
  "start_date": "2024-02-01",
  "end_date": "2024-02-15"
}
```

#### ফলাফল ম্যানেজমেন্ট
```
GET    /admin/results           # সকল ফলাফল
GET    /admin/results/create    # ফলাফল এন্ট্রি ফর্ম
POST   /admin/results           # ফলাফল সংরক্ষণ
```

**পোস্ট ডেটা:**
```json
{
  "exam_id": 1,
  "student_id": 1,
  "results": [
    {
      "subject_id": 1,
      "marks_obtained": 85
    },
    {
      "subject_id": 2,
      "marks_obtained": 92
    }
  ]
}
```

#### ফি ম্যানেজমেন্ট
```
GET    /admin/fees              # সকল ফি
POST   /admin/fees              # নতুন ফি তৈরি
GET    /admin/fees/{id}         # ফি বিস্তারিত
GET    /admin/fees/{id}/edit    # ফি এডিট ফর্ম
PUT    /admin/fees/{id}         # ফি আপডেট
DELETE /admin/fees/{id}         # ফি ডিলিট
GET    /admin/fees-payments     # ফি পেমেন্ট তালিকা
```

**পোস্ট/পুট ডেটা:**
```json
{
  "class_id": 1,
  "fee_type": "মাসিক ফি",
  "amount": 1500,
  "due_day_of_month": 15
}
```

### 👨‍🏫 Teacher Routes

#### ড্যাশবোর্ড
```
GET    /teacher/dashboard       # শিক্ষক ড্যাশবোর্ড
```

এই প্যানেল শিক্ষকদের:
- তাদের ক্লাস এবং সেকশন দেখতে দেয়
- হাজিরা নিতে
- মার্কস এন্ট্রি করতে
- ক্লাস রুটিন দেখতে

### 👨‍🎓 Student Routes

#### ড্যাশবোর্ড
```
GET    /student/dashboard       # শিক্ষার্থী ড্যাশবোর্ড
```

এই প্যানেল শিক্ষার্থীদের:
- নিজের ক্লাস এবং সেকশন তথ্য দেখতে
- উপস্থিতি স্ট্যাটাস দেখতে
- ক্লাস রুটিন দেখতে
- রেজাল্ট দেখতে

### 👨‍👩‍👧 Guardian Routes

#### ড্যাশবোর্ড
```
GET    /guardian/dashboard      # অভিভাবক ড্যাশবোর্ড
```

এই প্যানেল অভিভাবকদের:
- একাধিক সন্তানের তথ্য দেখতে
- সন্তানদের উপস্থিতি এবং রেজাল্ট দেখতে
- বকেয়া ফি দেখতে
- স্কুল নোটিস পেতে

## 📊 রেসপন্স ফর্ম্যাট

### সফল প্রতিক্রিয়া
```json
{
  "success": true,
  "message": "অপারেশন সফল",
  "data": {}
}
```

### ত্রুটি প্রতিক্রিয়া
```json
{
  "success": false,
  "message": "অনুমতি অস্বীকৃত",
  "errors": {}
}
```

## ⚙️ HTTP স্ট্যাটাস কোড

| কোড | বিবরণ |
|-----|--------|
| 200 | সফল |
| 201 | তৈরি সফল |
| 400 | খারাপ অনুরোধ |
| 401 | অনুমোদন প্রয়োজন |
| 403 | অনুমতি অস্বীকৃত |
| 404 | পাওয়া যায়নি |
| 422 | যাচাইকরণ ব্যর্থ |
| 500 | সার্ভার ত্রুটি |

## 🔄 ডেটা মডেল

### User
```json
{
  "id": 1,
  "school_id": 1,
  "name": "Md. Kamal",
  "email": "user@example.com",
  "role": "admin",
  "phone": "01700000001",
  "is_active": true,
  "created_at": "2024-01-01T00:00:00Z"
}
```

### Student
```json
{
  "id": 1,
  "school_id": 1,
  "user_id": 5,
  "class_id": 1,
  "section_id": 1,
  "admission_no": "ADM2024001",
  "roll_no": 1,
  "admission_date": "2024-01-01",
  "blood_group": "A+",
  "is_active": true
}
```

### Exam
```json
{
  "id": 1,
  "school_id": 1,
  "name": "বার্ষিক পরীক্ষা ২০২৪",
  "start_date": "2024-02-01",
  "end_date": "2024-02-15",
  "is_active": true
}
```

## 🧪 টেস্টিং

Postman বা অনুরূপ টুল ব্যবহার করে টেস্ট করুন।

### শিক্ষার্থী লিস্ট টেস্ট
```
GET /admin/students
Headers: Accept: application/json
```

---

আরও প্রশ্নের জন্য যোগাযোগ করুন।
