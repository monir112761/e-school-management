<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\User;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Guardian;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SchoolSeeder extends Seeder
{
    public function run(): void
    {
        // Create Super Admin
        User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'phone' => '01700000001',
                'role' => 'super_admin',
                'is_active' => true,
            ]
        );

        // Create Sample School
        $school = School::firstOrCreate(
            ['domain_name' => 'demo.school.local'],
            [
                'name' => 'Demo School',
                'slug' => 'demo-school',
                'email' => 'admin@demoschool.com',
                'phone' => '01711111111',
                'address' => '123 Main Street',
                'city' => 'Dhaka',
                'state' => 'Dhaka',
                'postal_code' => '1100',
                'country' => 'Bangladesh',
                'principal_name' => 'Md. Kamal Hossain',
                'principal_email' => 'principal@demoschool.com',
                'principal_phone' => '01711111110',
                'subscription_plan' => 'premium',
                'subscription_start_date' => now(),
                'subscription_end_date' => now()->addYear(),
                'is_active' => true,
            ]
        );

        // Create Admin User for School
        $admin = User::firstOrCreate(
            ['email' => 'admin@demoschool.com'],
            [
                'school_id' => $school->id,
                'name' => 'School Admin',
                'password' => Hash::make('password'),
                'phone' => '01700000002',
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        // Create Classes
        $classesData = [
            ['name' => 'Class 1', 'numeric_value' => '1'],
            ['name' => 'Class 2', 'numeric_value' => '2'],
            ['name' => 'Class 3', 'numeric_value' => '3'],
            ['name' => 'Class 6', 'numeric_value' => '6'],
            ['name' => 'Class 9', 'numeric_value' => '9'],
            ['name' => 'Class 10', 'numeric_value' => '10'],
        ];

        $classes = [];
        foreach ($classesData as $classData) {
            $classes[] = SchoolClass::firstOrCreate(
                ['school_id' => $school->id, 'numeric_value' => $classData['numeric_value']],
                ['name' => $classData['name'], 'is_active' => true]
            );
        }

        // Create Sections
        foreach ($classes as $class) {
            $sections = ['A', 'B', 'C'];
            foreach ($sections as $sectionName) {
                Section::firstOrCreate(
                    ['class_id' => $class->id, 'name' => "Section $sectionName"],
                    [
                        'school_id' => $school->id,
                        'capacity' => 50,
                        'is_active' => true,
                    ]
                );
            }
        }

        // Create Subjects for Class 6 and 9
        $classesToAddSubjects = $classes->filter(fn($c) => in_array($c->numeric_value, ['6', '9']))->take(2);
        $subjectNames = ['Mathematics', 'English', 'Bengali', 'Science', 'Social Studies', 'Islam'];
        $subjectCodes = ['MATH', 'ENG', 'BNG', 'SCI', 'SOC', 'ISLAM'];

        foreach ($classesToAddSubjects as $class) {
            foreach ($subjectNames as $index => $name) {
                Subject::firstOrCreate(
                    ['school_id' => $school->id, 'class_id' => $class->id, 'code' => $subjectCodes[$index] . $class->numeric_value],
                    [
                        'name' => $name,
                        'is_active' => true,
                    ]
                );
            }
        }

        // Create Teachers
        $teacherNames = [
            'Fatima Akhter',
            'Md. Rahim Ahmed',
            'Nasrin Sultana',
            'Abdul Kader Khan',
        ];

        $teachers = [];
        foreach ($teacherNames as $index => $name) {
            $user = User::firstOrCreate(
                ['email' => 'teacher' . ($index + 1) . '@demoschool.com'],
                [
                    'school_id' => $school->id,
                    'name' => $name,
                    'password' => Hash::make('password'),
                    'phone' => '0170000000' . (3 + $index),
                    'role' => 'teacher',
                    'is_active' => true,
                ]
            );

            $teacher = Teacher::firstOrCreate(
                ['school_id' => $school->id, 'user_id' => $user->id],
                [
                    'employee_no' => 'EMP00' . (1001 + $index),
                    'qualification' => 'B.A., B.Ed',
                    'joining_date' => now()->subYears(2),
                    'salary' => 25000 + ($index * 5000),
                    'is_active' => true,
                ]
            );

            $teachers[] = $teacher;
        }

        // Create Students
        $studentNames = [
            'Rakibul Islam',
            'Farida Khan',
            'Akiful Hasan',
            'Mina Rani',
            'Karim Uddin',
            'Sima Roy',
            'Ariful Islam',
            'Tamim Ahmed',
        ];

        $selectedClass = $classes->where('numeric_value', '6')->first();
        $selectedSection = $selectedClass->sections()->first();

        foreach ($studentNames as $index => $name) {
            $user = User::firstOrCreate(
                ['email' => 'student' . ($index + 1) . '@demoschool.com'],
                [
                    'school_id' => $school->id,
                    'name' => $name,
                    'password' => Hash::make('password'),
                    'phone' => '0170000010' . $index,
                    'role' => 'student',
                    'date_of_birth' => now()->subYears(12)->subDays($index * 10),
                    'gender' => $index % 2 == 0 ? 'male' : 'female',
                    'is_active' => true,
                ]
            );

            Student::firstOrCreate(
                ['school_id' => $school->id, 'user_id' => $user->id],
                [
                    'class_id' => $selectedClass->id,
                    'section_id' => $selectedSection->id,
                    'admission_no' => 'ADM' . date('Y') . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                    'roll_no' => $index + 1,
                    'admission_date' => now()->subYear(),
                    'blood_group' => ['A+', 'B+', 'O+', 'AB+'][$index % 4],
                    'nationality' => 'Bangladeshi',
                    'religion' => ['Islam', 'Hindu', 'Christian', 'Buddhist'][$index % 4],
                    'is_active' => true,
                ]
            );
        }

        // Create Guardians
        $guardianNames = [
            'Jamal Uddin',
            'Habiba Begum',
            'Rafique Ahmed',
            'Yasmin Akhter',
        ];

        $guardians = [];
        foreach ($guardianNames as $index => $name) {
            $user = User::firstOrCreate(
                ['email' => 'guardian' . ($index + 1) . '@demoschool.com'],
                [
                    'school_id' => $school->id,
                    'name' => $name,
                    'password' => Hash::make('password'),
                    'phone' => '0170000020' . $index,
                    'role' => 'guardian',
                    'is_active' => true,
                ]
            );

            $guardian = Guardian::firstOrCreate(
                ['school_id' => $school->id, 'user_id' => $user->id],
                [
                    'relation' => $index % 2 == 0 ? 'Father' : 'Mother',
                    'occupation' => 'Business',
                    'annual_income' => '500000',
                ]
            );

            $guardians[] = $guardian;
        }

        // Link guardians to students
        $students = Student::where('school_id', $school->id)->get();
        foreach ($students as $index => $student) {
            $student->guardians()->sync([$guardians[$index % count($guardians)]->id]);
        }

        $this->command->info('✅ School and sample data created successfully!');
        $this->command->info('Login credentials:');
        $this->command->info('Super Admin - superadmin@example.com / password');
        $this->command->info('School Admin - admin@demoschool.com / password');
        $this->command->info('Teachers - teacher1-4@demoschool.com / password');
        $this->command->info('Students - student1-8@demoschool.com / password');
        $this->command->info('Guardians - guardian1-4@demoschool.com / password');
    }
}
