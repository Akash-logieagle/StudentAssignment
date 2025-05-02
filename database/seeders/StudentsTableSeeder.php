<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class StudentsTableSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        DB::table('parents')->delete();
        DB::table('students')->delete();

        for ($i = 1; $i <= 50; $i++) {
            $profileUrl = 'https://i.pravatar.cc/150?img=' . rand(1, 70); // Random avatar

            $studentId = DB::table('students')->insertGetId([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'student_id' => 'STU-2025-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'class' => 'Class ' . rand(6, 10) . chr(rand(65, 67)),
                'performance' => rand(70, 100) . '%',
                'attendance' => rand(70, 100) . '%',
                'contact' => $faker->phoneNumber,
                'status' => $faker->randomElement(['Active', 'Inactive']),
                'date_of_birth' => $faker->date('Y-m-d', '-10 years'),
                'gender' => $faker->randomElement(['Male', 'Female', 'Other']),
                'enrollment_date' => $faker->date('Y-m-d', '-3 years'),
                'address' => $faker->address,
                'profile_image' => $profileUrl, // <-- Add profile image
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('parents')->insert([
                'student_id' => $studentId,
                'name' => $faker->name,
                'relationship' => $faker->randomElement(['Father', 'Mother', 'Guardian']),
                'email' => $faker->unique()->safeEmail,
                'phone_number' => $faker->phoneNumber,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
