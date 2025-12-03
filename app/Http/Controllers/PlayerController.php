<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class PlayerController extends Controller
{
    public function index(): Response
    {
        // Mock data for players with complete technical files
        $players = [
            [
                'id' => 1,
                'name' => 'Juan Pérez',
                'email' => 'juan.perez@example.com',
                'phone' => '+598 99 123 456',
                'position' => 'Delantero',
                'team' => 'Club Atlético Nacional',
                'age' => 25,
                'birth_date' => '1999-03-15',
                'nationality' => 'Uruguayo',
                'height' => '178 cm',
                'weight' => '75 kg',
                'status' => 'activo',
                'contract_status' => 'activo',
                'contract_expires' => '2025-01-14',
                'total_investment' => 13000,
                'documents_count' => 3,
            ],
            [
                'id' => 2,
                'name' => 'María González',
                'email' => 'maria.gonzalez@example.com',
                'phone' => '+598 98 234 567',
                'position' => 'Portero',
                'team' => 'Club Deportivo Los Leones',
                'age' => 23,
                'birth_date' => '2001-07-22',
                'nationality' => 'Uruguayo',
                'height' => '170 cm',
                'weight' => '65 kg',
                'status' => 'activo',
                'contract_status' => 'activo',
                'contract_expires' => '2024-12-31',
                'total_investment' => 5500,
                'documents_count' => 2,
            ],
            [
                'id' => 3,
                'name' => 'Carlos Rodríguez',
                'email' => 'carlos.rodriguez@example.com',
                'phone' => '+598 97 345 678',
                'position' => 'Defensa',
                'team' => 'Club Atlético Nacional',
                'age' => 28,
                'birth_date' => '1996-11-08',
                'nationality' => 'Uruguayo',
                'height' => '185 cm',
                'weight' => '82 kg',
                'status' => 'activo',
                'contract_status' => 'activo',
                'contract_expires' => '2026-02-28',
                'total_investment' => 6000,
                'documents_count' => 4,
            ],
            [
                'id' => 4,
                'name' => 'Ana Martínez',
                'email' => 'ana.martinez@example.com',
                'phone' => '+598 96 456 789',
                'position' => 'Mediocampista',
                'team' => 'Club Deportivo Los Leones',
                'age' => 22,
                'birth_date' => '2002-05-12',
                'nationality' => 'Uruguayo',
                'height' => '165 cm',
                'weight' => '60 kg',
                'status' => 'activo',
                'contract_status' => 'vencido',
                'contract_expires' => '2024-12-31',
                'total_investment' => 4500,
                'documents_count' => 2,
            ],
            [
                'id' => 5,
                'name' => 'Luis Sánchez',
                'email' => 'luis.sanchez@example.com',
                'phone' => '+598 95 567 890',
                'position' => 'Delantero',
                'team' => 'Club Deportivo Central',
                'age' => 26,
                'birth_date' => '1998-09-30',
                'nationality' => 'Uruguayo',
                'height' => '180 cm',
                'weight' => '78 kg',
                'status' => 'lesionado',
                'contract_status' => 'activo',
                'contract_expires' => '2025-06-30',
                'total_investment' => 0,
                'documents_count' => 1,
            ],
        ];

        $stats = [
            'total_players' => count($players),
            'active_players' => count(array_filter($players, fn($p) => $p['status'] === 'activo')),
            'injured_players' => count(array_filter($players, fn($p) => $p['status'] === 'lesionado')),
            'contracts_expiring_soon' => count(array_filter($players, fn($p) => 
                $p['contract_status'] === 'activo' && 
                strtotime($p['contract_expires']) <= strtotime('+30 days')
            )),
        ];

        return Inertia::render('Players/Index', [
            'players' => $players,
            'stats' => $stats,
        ]);
    }

    public function show($id): Response
    {
        // Mock investments data by player ID
        $investmentsByPlayer = [
            1 => [
                [
                    'id' => 1,
                    'type' => 'Marketing',
                    'description' => 'Campaña publicitaria redes sociales',
                    'amount' => 5000,
                    'date' => '2024-01-20',
                    'status' => 'completado',
                ],
                [
                    'id' => 2,
                    'type' => 'Entrenamiento',
                    'description' => 'Preparador físico personalizado',
                    'amount' => 8000,
                    'date' => '2024-02-15',
                    'status' => 'completado',
                ],
            ],
            2 => [
                [
                    'id' => 3,
                    'type' => 'Marketing',
                    'description' => 'Fotografía profesional',
                    'amount' => 3000,
                    'date' => '2024-03-10',
                    'status' => 'completado',
                ],
                [
                    'id' => 4,
                    'type' => 'Viajes',
                    'description' => 'Traslado para prueba en club',
                    'amount' => 2500,
                    'date' => '2024-04-05',
                    'status' => 'completado',
                ],
            ],
            3 => [
                [
                    'id' => 5,
                    'type' => 'Entrenamiento',
                    'description' => 'Programa de recuperación física',
                    'amount' => 6000,
                    'date' => '2024-03-20',
                    'status' => 'completado',
                ],
            ],
            4 => [
                [
                    'id' => 6,
                    'type' => 'Marketing',
                    'description' => 'Video promocional',
                    'amount' => 4500,
                    'date' => '2024-02-28',
                    'status' => 'completado',
                ],
            ],
            5 => [],
        ];

        // Mock detailed player data
        $player = [
            'id' => $id,
            'name' => 'Juan Pérez',
            'email' => 'juan.perez@example.com',
            'phone' => '+598 99 123 456',
            'position' => 'Delantero',
            'team' => 'Club Atlético Nacional',
            'age' => 25,
            'birth_date' => '1999-03-15',
            'birth_place' => 'Montevideo, Uruguay',
            'nationality' => 'Uruguayo',
            'height' => '178 cm',
            'weight' => '75 kg',
            'status' => 'activo',
            'contract_history' => [
                [
                    'club' => 'Club Atlético Nacional',
                    'start_date' => '2024-01-15',
                    'end_date' => '2025-01-14',
                    'status' => 'activo',
                ],
                [
                    'club' => 'Club Deportivo Central',
                    'start_date' => '2022-06-01',
                    'end_date' => '2023-12-31',
                    'status' => 'finalizado',
                ],
            ],
            'documents' => [
                ['name' => 'DNI', 'type' => 'Identificación', 'uploaded_at' => '2024-01-10'],
                ['name' => 'Contrato Actual', 'type' => 'Contrato', 'uploaded_at' => '2024-01-15'],
                ['name' => 'Certificado Médico', 'type' => 'Médico', 'uploaded_at' => '2024-01-12'],
            ],
            'total_investment' => 13000,
            'investments' => $investmentsByPlayer[$id] ?? [],
        ];

        return Inertia::render('Players/Show', [
            'player' => $player,
        ]);
    }
}


