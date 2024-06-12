<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createMember();
    }
    public function createMember()
    {
        return Member::create([
            'email' => 'member@member.com',
            'name' => 'Member',
            'email_verified_at' => now(),
            'password' => createPassword('password')
        ]);
    }
}
