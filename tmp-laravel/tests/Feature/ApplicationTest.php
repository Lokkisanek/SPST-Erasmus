<?php

namespace Tests\Feature;

use App\Models\Application;
use App\Models\Classes;
use App\Models\Mobility;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApplicationTest extends TestCase
{
    use RefreshDatabase;

    private function makeStudentUser(): User
    {
        Model::unguard();

        $user = User::factory()->create([
            'email' => 'zak@spst.eu',
            'role' => 'zak',
        ]);

        $class = Classes::create([
            'name' => 'TLA3',
            'year' => 3,
            'program_type' => 'maturitni',
            'field' => 'IT',
        ]);

        Student::create([
            'user_id' => $user->id,
            'class_id' => $class->id,
            'first_name' => 'Jan',
            'last_name' => 'Novák',
        ]);

        return $user;
    }

    public function test_teacher_cannot_open_application_form(): void
    {
        $teacher = User::factory()->create(['role' => 'ucitel']);

        $this->actingAs($teacher)
            ->get('/prihlaska')
            ->assertForbidden();
    }

    public function test_student_can_open_application_form(): void
    {
        $user = $this->makeStudentUser();

        $this->actingAs($user)
            ->get('/prihlaska')
            ->assertOk();
    }

    public function test_gmail_cannot_register(): void
    {
        $this->post('/register', [
            'name' => 'Test',
            'email' => 'ahoj@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertSessionHasErrors('email');
    }
}