<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class PlayerController extends Controller
{
    public function index(): Response
    {
        // Mock data for players
        $players = [
            [
                'id' => 1,
                'name' => 'Juan Pérez',
                'email' => 'juan.perez@example.com',
                'position' => 'Delantero',
                'team' => 'Los Leones',
                'age' => 25,
                'status' => 'activo',
            ],
            [
                'id' => 2,
                'name' => 'María González',
                'email' => 'maria.gonzalez@example.com',
                'position' => 'Portero',
                'team' => 'Las Águilas',
                'age' => 23,
                'status' => 'activo',
            ],
            [
                'id' => 3,
                'name' => 'Carlos Rodríguez',
                'email' => 'carlos.rodriguez@example.com',
                'position' => 'Defensa',
                'team' => 'Los Leones',
                'age' => 28,
                'status' => 'activo',
            ],
            [
                'id' => 4,
                'name' => 'Ana Martínez',
                'email' => 'ana.martinez@example.com',
                'position' => 'Mediocampista',
                'team' => 'Las Águilas',
                'age' => 22,
                'status' => 'activo',
            ],
            [
                'id' => 5,
                'name' => 'Luis Sánchez',
                'email' => 'luis.sanchez@example.com',
                'position' => 'Delantero',
                'team' => 'Los Tigres',
                'age' => 26,
                'status' => 'lesionado',
            ],
        ];

        return Inertia::render('Players/Index', [
            'players' => $players,
        ]);
    }
}

