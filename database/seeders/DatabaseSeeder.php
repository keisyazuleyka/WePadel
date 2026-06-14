<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Membership;
use App\Models\Court;
use App\Models\CourtImage;
use App\Models\Tournament;
use App\Models\Review;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Roles
        $superAdminRole = Role::create([
            'name' => 'super_admin',
            'display_name' => 'Super Admin',
        ]);

        $adminRole = Role::create([
            'name' => 'admin',
            'display_name' => 'Admin',
        ]);

        $userRole = Role::create([
            'name' => 'user',
            'display_name' => 'User',
        ]);

        // 2. Seed Users
        User::create([
            'role_id' => $superAdminRole->id,
            'name' => 'Super Admin',
            'email' => 'superadmin@wepadel.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        User::create([
            'role_id' => $adminRole->id,
            'name' => 'Admin User',
            'email' => 'admin@wepadel.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $regularUser = User::create([
            'role_id' => $userRole->id,
            'name' => 'Regular User',
            'email' => 'user@wepadel.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // 3. Seed Memberships
        $silver = Membership::create([
            'name' => 'Silver Plan',
            'price' => 250000.00,
            'discount_percentage' => 10.00,
            'benefits' => [
                '10% discount on all court bookings',
                'Book up to 7 days in advance',
                'Access to standard locker rooms'
            ],
            'duration_in_days' => 30,
        ]);

        $gold = Membership::create([
            'name' => 'Gold Plan',
            'price' => 600000.00,
            'discount_percentage' => 20.00,
            'benefits' => [
                '20% discount on all court bookings',
                'Book up to 14 days in advance',
                'Free towel service',
                'Access to priority courts'
            ],
            'duration_in_days' => 30,
        ]);

        $platinum = Membership::create([
            'name' => 'Elite Pro Plan',
            'price' => 1200000.00,
            'discount_percentage' => 30.00,
            'benefits' => [
                '30% discount on all court bookings',
                'Book up to 30 days in advance',
                'Free towel & racket rental',
                'Access to VIP lounge',
                'Priority tournament registration'
            ],
            'duration_in_days' => 30,
        ]);

        // 4. Seed Courts
        $skyTerrace = Court::create([
            'name' => 'WePadel Sky Terrace',
            'description' => 'Premium rooftop padel court with a breathtaking view of Kuningan skyline. Floodlit for night sessions. Features ultra-smooth turf and high-grade glass.',
            'location' => 'Kuningan, Jakarta',
            'price_per_hour' => 300000.00,
            'is_available' => true,
        ]);

        $dome = Court::create([
            'name' => 'The Dome (Indoor)',
            'description' => 'State-of-the-art indoor dome. Temperature controlled to beat the heat. Ideal for professional play with top-tier indoor acoustics.',
            'location' => 'Sentul, Bogor',
            'price_per_hour' => 250000.00,
            'is_available' => true,
        ]);

        $sunsetDunes = Court::create([
            'name' => 'Sunset Dunes',
            'description' => 'Scenic outdoor court positioned by the beachfront. Perfect for sunset games and social matches in a breezy natural environment.',
            'location' => 'BSD City, Tangerang',
            'price_per_hour' => 180000.00,
            'is_available' => true,
        ]);

        $sportsClub = Court::create([
            'name' => 'Marina Sports Club',
            'description' => 'Elite court inside the sports club. Features professional synthetic turf, premium lighting, and nearby training facilities.',
            'location' => 'Senayan, Jakarta',
            'price_per_hour' => 220000.00,
            'is_available' => true,
        ]);

        // 5. Seed Court Images (Direct URLs to resolve broken images)
        CourtImage::create([
            'court_id' => $skyTerrace->id,
            'image_path' => 'https://images.unsplash.com/photo-1709587825415-814c2d7cfce7?q=80&w=600&auto=format&fit=crop',
            'is_primary' => true,
        ]);

        CourtImage::create([
            'court_id' => $dome->id,
            'image_path' => 'https://images.unsplash.com/photo-1709587824751-dd30420f5cf3?q=80&w=600&auto=format&fit=crop',
            'is_primary' => true,
        ]);

        CourtImage::create([
            'court_id' => $sunsetDunes->id,
            'image_path' => 'https://images.unsplash.com/photo-1526888935184-a82d2a4b7e67?q=80&w=600&auto=format&fit=crop',
            'is_primary' => true,
        ]);

        CourtImage::create([
            'court_id' => $sportsClub->id,
            'image_path' => 'https://images.unsplash.com/photo-1657704358775-ed705c7388d2?q=80&w=600&auto=format&fit=crop',
            'is_primary' => true,
        ]);

        // 6. Seed Tournaments
        Tournament::create([
            'name' => 'Winter Smash Cup 2026',
            'description' => 'Join the ultimate winter showdown in Jakarta. Open to all registered users. Premium trophy and cash prize for the winning team.',
            'start_date' => '2026-12-15',
            'end_date' => '2026-12-18',
            'max_teams' => 32,
            'registration_fee' => 150000.00,
            'status' => 'upcoming',
        ]);

        Tournament::create([
            'name' => 'Pro Members Series',
            'description' => 'An exclusive tournament series for Gold and Platinum members. Competitive play with ranked seeding.',
            'start_date' => '2026-12-20',
            'end_date' => '2026-12-22',
            'max_teams' => 16,
            'registration_fee' => 100000.00,
            'status' => 'upcoming',
        ]);

        Tournament::create([
            'name' => 'Mixed Doubles Open',
            'description' => 'Social mixed doubles tournament in Sentul. Perfect for meeting other padel enthusiasts. Inclusive registration fee with dinner included.',
            'start_date' => '2026-12-25',
            'end_date' => '2026-12-27',
            'max_teams' => 24,
            'registration_fee' => 80000.00,
            'status' => 'upcoming',
        ]);

        // 7. Seed Reviews
        Review::create([
            'court_id' => $skyTerrace->id,
            'user_id' => $regularUser->id,
            'rating' => 5,
            'comment' => 'Unbelievable skyline view! Clean court and excellent premium lighting.',
        ]);

        Review::create([
            'court_id' => $dome->id,
            'user_id' => $regularUser->id,
            'rating' => 5,
            'comment' => 'A/C is powerful and turf is in pristine condition. Highly recommend for hot afternoons.',
        ]);

        Review::create([
            'court_id' => $sunsetDunes->id,
            'user_id' => $regularUser->id,
            'rating' => 4,
            'comment' => 'Great beach breeze but wind can affect the ball slightly. Sunset play is gorgeous.',
        ]);

        Review::create([
            'court_id' => $sportsClub->id,
            'user_id' => $regularUser->id,
            'rating' => 5,
            'comment' => 'Professional setup. Convenient parking and friendly staff.',
        ]);
    }
}
