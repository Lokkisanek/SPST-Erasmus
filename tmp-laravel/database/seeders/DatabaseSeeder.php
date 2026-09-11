<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Classes;
use App\Models\Mobility;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Model::unguard();

        $admin = User::create([
            'name' => 'Admin Koordinátor',
            'email' => 'admin@spst.cz',
            'password' => 'password',
            'role' => 'admin',
            'is_active' => true,
        ]);

        $tuUser = User::create([
            'name' => 'Jana Nováková',
            'email' => 'novakova@spst.cz',
            'password' => 'password',
            'role' => 'ucitel',
            'is_active' => true,
        ]);

        $ajUser = User::create([
            'name' => 'Petr Svoboda',
            'email' => 'svoboda@spst.cz',
            'password' => 'password',
            'role' => 'ucitel',
            'is_active' => true,
        ]);

        $studentUser = User::create([
            'name' => 'Jan Novák',
            'email' => 'novak@spst.eu',
            'password' => 'password',
            'role' => 'zak',
            'is_active' => true,
        ]);

        $class = Classes::create([
            'name' => 'TLA3',
            'year' => 3,
            'program_type' => 'maturitni',
            'field' => 'IT',
        ]);

        $classTeacher = Teacher::create([
            'user_id' => $tuUser->id,
            'first_name' => 'Jana',
            'last_name' => 'Nováková',
        ]);

        $englishTeacher = Teacher::create([
            'user_id' => $ajUser->id,
            'first_name' => 'Petr',
            'last_name' => 'Svoboda',
        ]);

        $student = Student::create([
            'user_id' => $studentUser->id,
            'class_id' => $class->id,
            'first_name' => 'Jan',
            'last_name' => 'Novák',
            'birth_date' => '2008-05-12',
            'address' => 'Třebíč, Znojemská 1',
            'phone' => '777123456',
        ]);

        $mobility = Mobility::create([
            'class_id' => $class->id, // máš to v migraci; později by mobilita neměla viset na jedné třídě
            'destination' => 'Finsko',
            'type' => 'dvoutydenni',
            'season' => 'jaro',
            'eligible_maturita_year' => 2,
            'eligible_vocational_year' => 1,
            'starts_on' => '2027-03-15',
            'ends_on' => '2027-03-29',
            'deadline_application' => '2027-02-13',
            'deadline_documents' => '2027-02-22',
            'deadline_class_teacher' => '2027-02-28',
            'deadline_english_teacher' => '2027-03-22',
            'test_opens_on' => '2027-04-01',
            'test_closes_on' => '2027-05-31',
            'quota' => 16,
            'status' => 'active',
        ]);

        Application::create([
            'student_id' => $student->id,
            'mobility_id' => $mobility->id,
            'class_teacher_id' => $classTeacher->id,
            'english_teacher_id' => $englishTeacher->id,
            'preferred_type' => 'kratkodoba',
            'status' => 'draft',
            'gdpr_consent' => true,
            'submitted_at' => now(),
        ]);
    }
}