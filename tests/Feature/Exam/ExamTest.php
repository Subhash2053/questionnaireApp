<?php

namespace Tests\Feature\Exam;

use App\Mail\ExamMail;
use App\Models\Exam;
use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ExamTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create(['role_id'=>1]);
        $this->actingAs($user);
        $this->seed();
    }
    public function test_exam_page_is_displayed(): void
    {

        $response = $this
            ->get('/exam');

        $response->assertOk();
        $response->assertInertia(
            fn (Assert $page) => $page
            ->component('Exam/List')
            ->has('exams')
        );
    }

    public function test_exam_create_page_is_displayed(): void
    {

        $response = $this
            ->get('/exam/create');

        $response->assertOk();
        $response->assertInertia(
            fn (Assert $page) => $page
            ->component('Exam/Create')
        );
    }

    public function test_admin_can_store_exam(): void
    {
        $data =  [
            'title' => 'Test Exam',
            'expiry_date' => '2023-08-02',
        ];

        $response = $this
            ->post('/exam', $data);


        $response->assertRedirectToRoute('exam.index');
        $this->assertDatabaseHas('exams', $data);
        $this->assertDatabaseCount('exam_questions', 10);
    }

    public function test_admin_can_send_invitation(): void
    {
        Mail::fake();
        $this
            ->post('/exam', [
                'title' => 'Test Exam',
                'expiry_date' => '2023-08-02',
            ]);

        $exam= Exam::first();
        $response = $this
        ->get('/exam/send/'.$exam->id);

        //$response->assertRedirectToRoute('exam.index');
        $response->assertSessionHas('success', 'Invitation sent successfully');
        Mail::assertSent(ExamMail::class);
    }

    public function test_user_exam_fill_page_is_displayed(): void
    {
        $this
        ->post('/exam', [
            'title' => 'Test Exam',
            'expiry_date' => '2023-08-02',
        ]);

        $user = User::factory()->create(['role_id'=>2]);

        $exam= Exam::first();
        $invitationBody =['email'=>$user->email,'exam_id'=>$exam->id];
        $invitationBodyencoded = base64_encode(json_encode($invitationBody));

        $uniqueUrl = URL::signedRoute('exam.fill', ['token'=>$invitationBodyencoded]);
        Link::updateOrCreate(['url'=> $uniqueUrl,'user_id'=>$user->id,'exam_id'=>$exam->id]);

       auth()->logout();

        $response = $this
           ->get($uniqueUrl);

        $response->assertOk();

        $response->assertInertia(
            fn (Assert $page) => $page
            ->component('Exam/Fill')
            ->hasAll(['questions','user','exam'])
        );
    }


}
