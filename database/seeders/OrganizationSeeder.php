<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrganizationSeeder extends Seeder
{
    public function run(): void
    {
        $rngpit = Organization::updateOrCreate(
            ['slug' => 'rngpit'],
            [
                'name' => 'RNGPIT',
                'type' => 'College',
                'logo' => null,
                'cover_image' => null,
                'description' => 'RNGPIT is an educational organization offering various academic, technical and cultural activities.',
                'email' => 'info@rngpit.ac.in',
                'phone' => null,
                'address' => 'Bardoli, Gujarat',
                'city' => 'Bardoli',
                'state' => 'Gujarat',
                'website' => null,
                'status' => 'approved',
            ]
        );

        Event::updateOrCreate(
            ['slug' => 'tech-fest-2026'],
            [
                'organization_id' => $rngpit->id,
                'title' => 'Tech Fest 2026',
                'category' => 'Technical',
                'description' => 'A technical event featuring coding, technology and innovation activities.',
                'banner' => null,
                'event_date' => '2026-10-25',
                'event_time' => '10:00:00',
                'venue' => 'RNGPIT Campus',
                'city' => 'Bardoli',
                'ticket_price' => 100,
                'total_seats' => 200,
                'available_seats' => 200,
                'status' => 'approved',
            ]
        );

        Event::updateOrCreate(
            ['slug' => 'coding-competition-2026'],
            [
                'organization_id' => $rngpit->id,
                'title' => 'Coding Competition 2026',
                'category' => 'Coding',
                'description' => 'A coding competition for students interested in programming and problem solving.',
                'banner' => null,
                'event_date' => '2026-11-10',
                'event_time' => '11:00:00',
                'venue' => 'Computer Department',
                'city' => 'Bardoli',
                'ticket_price' => 50,
                'total_seats' => 100,
                'available_seats' => 100,
                'status' => 'approved',
            ]
        );

        Event::updateOrCreate(
            ['slug' => 'cultural-fest-2026'],
            [
                'organization_id' => $rngpit->id,
                'title' => 'Cultural Fest 2026',
                'category' => 'Cultural',
                'description' => 'A cultural event with music, dance and creative activities.',
                'banner' => null,
                'event_date' => '2026-11-20',
                'event_time' => '09:30:00',
                'venue' => 'RNGPIT Auditorium',
                'city' => 'Bardoli',
                'ticket_price' => 0,
                'total_seats' => 300,
                'available_seats' => 300,
                'status' => 'approved',
            ]
        );
    }
}