<?php

namespace Tests\Feature;

use App\Models\Ballot;
use App\Models\Election;
use App\Models\User;
use App\Models\Voter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_admin_can_login_with_identity_number_and_password(): void
    {
        $this->seed();

        $response = $this->post('/admin/login', [
            'identity_number' => 'F1D02410053',
            'password' => 'admin12345',
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticated();
    }

    public function test_authenticated_admin_is_redirected_away_from_login_page(): void
    {
        $this->seed();

        $admin = User::where('identity_number', 'F1D02410053')->firstOrFail();

        $this->actingAs($admin)
            ->get('/admin/login')
            ->assertRedirect('/admin/dashboard');
    }

    public function test_vote_is_stored_as_anonymous_encrypted_ballot(): void
    {
        $this->seed();

        $voter = Voter::where('identity_number', 'F1D02410036')->firstOrFail();

        $this->post('/lookup', [
            'identity_number' => $voter->identity_number,
        ])->assertRedirect('/vote');

        $this->post('/vote', [
            'candidate_id' => 1,
        ])->assertRedirect('/success');

        $voter->refresh();
        $ballot = Ballot::firstOrFail();

        $this->assertTrue($voter->has_voted);
        $this->assertStringNotContainsString($voter->identity_number, $ballot->encrypted_vote);
        $this->assertDatabaseMissing('ballots', ['anonymous_token_hash' => $voter->identity_number]);
    }

    public function test_live_monitor_can_show_closed_election_results(): void
    {
        $this->seed();

        $admin = User::where('identity_number', 'F1D02410053')->firstOrFail();
        $voter = Voter::where('identity_number', 'F1D02410036')->firstOrFail();

        $this->post('/lookup', [
            'identity_number' => $voter->identity_number,
        ]);

        $this->post('/vote', [
            'candidate_id' => 1,
        ]);

        Election::firstOrFail()->update([
            'status' => 'closed',
            'ended_at' => now(),
        ]);

        $this->actingAs($admin)
            ->get('/admin/live')
            ->assertOk()
            ->assertSee('Peringkat Suara Terbanyak');
    }

    public function test_admin_can_lookup_voter_when_adding_candidate(): void
    {
        $this->seed();

        $admin = User::where('identity_number', 'F1D02410053')->firstOrFail();

        $this->actingAs($admin)
            ->getJson('/admin/voters/lookup?identity_number=F1D02410036')
            ->assertOk()
            ->assertJson([
                'identity_number' => 'F1D02410036',
                'full_name' => 'ANDRA ATHAR RIZQA',
            ]);
    }
}
