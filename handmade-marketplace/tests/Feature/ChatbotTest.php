<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChatbotTest extends TestCase
{
    use RefreshDatabase;

    public function test_chatbot_returns_json_reply(): void
    {
        $response = $this->postJson(route('chatbot.reply'), [
            'message' => 'How do I track my order?',
        ]);

        $response->assertOk()
            ->assertJsonStructure(['reply', 'suggestions'])
            ->assertJsonFragment(['suggestions' => ['Shipping info', 'Payment methods', 'Returns']]);
    }

    public function test_chatbot_requires_message(): void
    {
        $this->postJson(route('chatbot.reply'), [])
            ->assertUnprocessable();
    }

    public function test_public_pages_include_chatbot(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('cn-chatbot', false);
    }
}
