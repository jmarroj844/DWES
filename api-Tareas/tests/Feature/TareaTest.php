<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Tarea;
class TareaTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function testTareas()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test_token');

        $header = [
            'Authorization' => 'Bearer ' . $token->plainTextToken
        ];
        
        $response = $this->withHeaders($header)->get('/api/tareas');
    
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'titulo',
                        'descripcion',
                        'etiquetas'
                    ],
                ],
            ]);
    }

    public function testTarea()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test_token');
    
        $header = [
            'Authorization' => 'Bearer ' . $token->plainTextToken
        ];
    
        $tarea = Tarea::factory()->create();
        
        $response = $this->withHeaders($header)->get('/api/tareas/' . $tarea->id);
    
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'titulo',
                    'descripcion'
                ],
            ]);
    }

    public function testTareaNueva()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test_token');

        $header = [
            'Authorization' => 'Bearer ' . $token->plainTextToken
        ];

        $nuevaTarea = [
            'titulo' => 'Tarea Nueva',
            'descripcion' => 'Descripción de la tarea'
        ];

        $response = $this->withHeaders($header)->post('/api/tareas', $nuevaTarea);

        $response->assertStatus(201)
        ->assertJsonStructure([
            'data' => [
                'id',
                'titulo',
                'descripcion'
            ],
        ]);

    }

    public function testTareaCambiada(){
        $user = User::factory()->create();
        $token = $user->createToken('test_token');

        $header = [
            'Authorization' => 'Bearer ' . $token->plainTextToken
        ];

        $tareaOriginal = Tarea::factory()->create();

        $tareaModif = [
            'titulo' => 'Título nuevo',
            'descripcion' => 'Descripción nueva'
        ];

        $response = $this->withHeaders($header)->put('/api/tareas/' . $tareaOriginal->id, $tareaModif);

        $response->assertStatus(200) 
        ->assertJsonStructure([
            'data' => [
                'id',
                'titulo',
                'descripcion'
            ],
        ]);
    }

    public function testTareaBorrada(){
        $user = User::factory()->create();
        $token = $user->createToken('test_token');

        $header = [
            'Authorization' => 'Bearer ' . $token->plainTextToken
        ];

        $tareaBorrar = Tarea::factory()->create();

        $response = $this->withHeaders($header)->delete('/api/tareas/' . $tareaBorrar->id);

        $response->assertStatus(200) 
        ->assertJsonStructure([
            'success'
        ]);
    }
}