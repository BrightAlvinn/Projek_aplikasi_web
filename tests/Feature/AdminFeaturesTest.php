<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\DefaultCategory;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminFeaturesTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_displays_kpi_and_analytics_sections(): void
    {
        $admin = User::factory()->admin()->create();

        $user1 = User::factory()->create(['created_at' => now()]);
        $cat1 = Category::create([
            'user_id' => $user1->id,
            'name' => 'Makanan & Minuman',
            'type' => 'expense',
            'color' => '#ef4444',
            'icon' => 'utensils',
        ]);

        Transaction::create([
            'user_id' => $user1->id,
            'category_id' => $cat1->id,
            'type' => 'expense',
            'amount' => 50000,
            'transaction_date' => now()->toDateString(),
            'description' => 'Makan siang',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertSeeText('Ringkasan Statistik Utama');
        $response->assertSeeText('Grafik & Analitik Platform');
        $response->assertSeeText('Manajemen Pengguna');
        $response->assertSeeText('Master Kategori Default');
        $response->assertSeeText('Monitoring AI Chatbot');
        $response->assertSeeText('Makanan & Minuman');
    }

    public function test_admin_can_search_and_filter_users(): void
    {
        $admin = User::factory()->admin()->create(['name' => 'Admin Boss', 'email' => 'admin@catatuang.com']);
        $userA = User::factory()->create(['name' => 'Budi Santoso', 'email' => 'budi@gmail.com', 'is_active' => true, 'role' => 'user']);
        $userB = User::factory()->suspended()->create(['name' => 'Siti Rahma', 'email' => 'siti@gmail.com', 'role' => 'user']);

        // Search by name
        $responseSearch = $this->actingAs($admin)->get(route('admin.dashboard', ['search' => 'Budi']));
        $responseSearch->assertOk();
        $usersResult = $responseSearch->viewData('users');
        $this->assertTrue($usersResult->contains($userA));
        $this->assertFalse($usersResult->contains($userB));

        // Filter by status suspended
        $responseFilter = $this->actingAs($admin)->get(route('admin.dashboard', ['status' => 'suspended']));
        $responseFilter->assertOk();
        $usersFilterResult = $responseFilter->viewData('users');
        $this->assertTrue($usersFilterResult->contains($userB));
        $this->assertFalse($usersFilterResult->contains($userA));
    }

    public function test_admin_can_toggle_user_status_and_suspended_user_cannot_login(): void
    {
        $admin = User::factory()->admin()->create();
        $user = User::factory()->create(['password' => 'secret123', 'is_active' => true]);

        // Admin suspends user
        $response = $this->actingAs($admin)->patch(route('admin.users.toggle-status', $user));
        $response->assertRedirect();
        $this->assertFalse($user->fresh()->isActive());

        // Logout admin so test client is guest
        auth()->logout();

        // Suspended user tries to login
        $loginResponse = $this->post(route('login.post'), [
            'email' => $user->email,
            'password' => 'secret123',
        ]);

        $loginResponse->assertSessionHas('error');
        $this->assertGuest();

        // Admin logs back in and reactivates user
        $reactivateResponse = $this->actingAs($admin)->patch(route('admin.users.toggle-status', $user));
        $reactivateResponse->assertRedirect();
        $this->assertTrue($user->fresh()->isActive());
    }

    public function test_admin_cannot_suspend_themselves(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->patch(route('admin.users.toggle-status', $admin));
        $response->assertSessionHas('error');
        $this->assertTrue($admin->fresh()->isActive());
    }

    public function test_admin_can_update_user_role(): void
    {
        $admin = User::factory()->admin()->create();
        $targetUser = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($admin)->patch(route('admin.users.update-role', $targetUser), [
            'role' => 'admin',
        ]);

        $response->assertRedirect();
        $this->assertTrue($targetUser->fresh()->isAdmin());
    }

    public function test_admin_can_delete_user(): void
    {
        $admin = User::factory()->admin()->create();
        $userToDelete = User::factory()->create();

        $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $userToDelete));
        $response->assertRedirect();
        $this->assertDatabaseMissing('users', ['id' => $userToDelete->id]);
    }

    public function test_admin_can_manage_default_categories(): void
    {
        $admin = User::factory()->admin()->create();

        // 1. Create Default Category Template
        $storeResponse = $this->actingAs($admin)->post(route('admin.default-categories.store'), [
            'name' => 'Freelance / Sampingan',
            'type' => 'income',
            'color' => '#14b8a6',
            'icon' => 'wallet',
        ]);

        $storeResponse->assertRedirect();
        $this->assertDatabaseHas('default_categories', [
            'name' => 'Freelance / Sampingan',
            'type' => 'income',
        ]);

        $category = DefaultCategory::where('name', 'Freelance / Sampingan')->firstOrFail();

        // 2. Update Default Category
        $updateResponse = $this->actingAs($admin)->put(route('admin.default-categories.update', $category), [
            'name' => 'Pendapatan Freelance',
            'type' => 'income',
            'color' => '#0d9488',
            'icon' => 'trending-up',
        ]);

        $updateResponse->assertRedirect();
        $this->assertDatabaseHas('default_categories', [
            'id' => $category->id,
            'name' => 'Pendapatan Freelance',
        ]);

        // 3. New registered user inherits default category
        $this->post(route('register.post'), [
            'name' => 'Pengguna Baru',
            'email' => 'penggunabaru@gmail.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $newUser = User::where('email', 'penggunabaru@gmail.com')->firstOrFail();
        $this->assertTrue($newUser->categories()->where('name', 'Pendapatan Freelance')->exists());

        // 4. Delete Default Category
        $deleteResponse = $this->actingAs($admin)->delete(route('admin.default-categories.destroy', $category));
        $deleteResponse->assertRedirect();
        $this->assertDatabaseMissing('default_categories', ['id' => $category->id]);
    }

    public function test_admin_can_check_ai_status_endpoint(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->getJson(route('admin.monitoring.check-ai'));

        $response->assertOk();
        $response->assertJsonStructure([
            'status',
            'online',
            'message',
            'latency_ms',
            'model',
            'base_url',
        ]);
    }

    public function test_admin_can_clear_system_log(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post(route('admin.monitoring.clear-log'));

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }
}
