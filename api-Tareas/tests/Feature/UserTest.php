<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{

    use RefreshDatabase;
    public function testRegistrarUsuario(){
        $nuevoUsuario = [
            'name' => 'josemi',
            'email' => 'josemi@gmail.com',
            'password' => 'password'
        ];

        $response = $this->post('/api/register', $nuevoUsuario);

        $response->assertStatus(200) 
        ->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email'
            ],
        ]);
    }

    public function testLogin(){
        $usuarioLogin = User::factory()->create(['password' => 'password']);

        $credenciales = [
            'email' => $usuarioLogin->email,
            'password' => 'password'
        ];

        $response = $this->post('/api/login', $credenciales);

        $response->assertStatus(200)
        ->assertJsonStructure([
            'message',
            'access_token',
            'token_type',
        ])
        ->assertJson([
            'message' => 'Eeeeeeeeeeeih ' . $usuarioLogin->name,
            'token_type' => 'Bearer'
        ]);

    }

    public function testLogout(){
        $usuarioConectado = User::factory()->create();
        $token = $usuarioConectado->createToken('test_token');

        $header = [
            'Authorization' => 'Bearer ' . $token->plainTextToken
        ];

        $response = $this->withHeaders($header)->get('/api/logout');

        $response->assertStatus(200)
        ->assertJson([
            'message' => 'Sesión cerrada'
        ]);
    }

}