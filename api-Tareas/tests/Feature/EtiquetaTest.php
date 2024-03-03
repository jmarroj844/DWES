<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Etiqueta;

class EtiquetaTest extends TestCase
{
    use RefreshDatabase;
    public function testEtiquetas()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test_token');

        $header = [
            'Authorization' => 'Bearer ' . $token->plainTextToken
        ];
        
        $response = $this->withHeaders($header)->get('/api/etiquetas');
    
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'nombre',
                        'tareas'
                    ],
                ],
            ]);
    }

    public function testEtiqueta()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test_token');
    
        $header = [
            'Authorization' => 'Bearer ' . $token->plainTextToken
        ];
    
        $etiqueta = Etiqueta::factory()->create();
        
        $response = $this->withHeaders($header)->get('/api/etiquetas/' . $etiqueta->id);
    
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'nombre',
                    'tareas'
                ],
            ]);
    }

    public function testEtiquetaNueva()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test_token');

        $header = [
            'Authorization' => 'Bearer ' . $token->plainTextToken
        ];

        $nuevaEtiqueta = [
            'nombre' => 'Etiqueta nueva'
        ];

        $response = $this->withHeaders($header)->post('/api/etiquetas', $nuevaEtiqueta);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'nombre',
                    'tareas'
                ],
            ]);

    }

    public function testEtiquetaActualizada(){
        $user = User::factory()->create();
        $token = $user->createToken('test_token');

        $header = [
            'Authorization' => 'Bearer ' . $token->plainTextToken
        ];

        $etiquetaOriginal = Etiqueta::factory()->create();

        $etiquetaCambiada = [
            'nombre' => 'Nombre nuevo'
        ];

        $response = $this->withHeaders($header)->put('/api/etiquetas/' . $etiquetaOriginal->id, $etiquetaCambiada);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'nombre',
                    'tareas'
                ],
            ]);
    }

    public function testEtiquetaBorrada(){
        $user = User::factory()->create();
        $token = $user->createToken('test_token');

        $header = [
            'Authorization' => 'Bearer ' . $token->plainTextToken
        ];

        $etiquetaBorrar = Etiqueta::factory()->create();

        $response = $this->withHeaders($header)->delete('/api/etiquetas/' . $etiquetaBorrar->id);

        $response->assertStatus(200) 
        ->assertJsonStructure([
            'success'
        ]);
    }

}