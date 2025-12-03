<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class InvestmentController extends Controller
{
    public function index(): Response
    {
        // Mock data for investments
        $investments = [
            [
                'id' => 1,
                'player_id' => 1,
                'player_name' => 'Juan Pérez',
                'type' => 'Marketing',
                'description' => 'Campaña publicitaria redes sociales',
                'amount' => 5000,
                'date' => '2024-01-20',
                'status' => 'completado',
            ],
            [
                'id' => 2,
                'player_id' => 1,
                'player_name' => 'Juan Pérez',
                'type' => 'Entrenamiento',
                'description' => 'Preparador físico personalizado',
                'amount' => 8000,
                'date' => '2024-02-15',
                'status' => 'completado',
            ],
            [
                'id' => 3,
                'player_id' => 2,
                'player_name' => 'María González',
                'type' => 'Marketing',
                'description' => 'Fotografía profesional',
                'amount' => 3000,
                'date' => '2024-03-10',
                'status' => 'completado',
            ],
            [
                'id' => 4,
                'player_id' => 2,
                'player_name' => 'María González',
                'type' => 'Viajes',
                'description' => 'Traslado para prueba en club',
                'amount' => 2500,
                'date' => '2024-04-05',
                'status' => 'completado',
            ],
            [
                'id' => 5,
                'player_id' => 3,
                'player_name' => 'Carlos Rodríguez',
                'type' => 'Entrenamiento',
                'description' => 'Programa de recuperación física',
                'amount' => 6000,
                'date' => '2024-03-20',
                'status' => 'completado',
            ],
            [
                'id' => 6,
                'player_id' => 4,
                'player_name' => 'Ana Martínez',
                'type' => 'Marketing',
                'description' => 'Video promocional',
                'amount' => 4500,
                'date' => '2024-02-28',
                'status' => 'completado',
            ],
        ];

        // Calculate totals by player
        $totals_by_player = [];
        foreach ($investments as $investment) {
            if (!isset($totals_by_player[$investment['player_id']])) {
                $totals_by_player[$investment['player_id']] = [
                    'player_id' => $investment['player_id'],
                    'player_name' => $investment['player_name'],
                    'total' => 0,
                    'count' => 0,
                ];
            }
            $totals_by_player[$investment['player_id']]['total'] += $investment['amount'];
            $totals_by_player[$investment['player_id']]['count']++;
        }

        $stats = [
            'total_investment' => array_sum(array_column($investments, 'amount')),
            'total_investments' => count($investments),
            'players_with_investments' => count($totals_by_player),
            'average_per_player' => count($totals_by_player) > 0 
                ? array_sum(array_column($totals_by_player, 'total')) / count($totals_by_player) 
                : 0,
        ];

        return Inertia::render('Investments/Index', [
            'investments' => $investments,
            'totalsByPlayer' => array_values($totals_by_player),
            'stats' => $stats,
        ]);
    }

    public function show($playerId): Response
    {
        // Mock data for a specific player's investments
        $playerInvestments = [
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
        ];

        $playerTotal = array_sum(array_column($playerInvestments, 'amount'));

        return Inertia::render('Investments/Show', [
            'playerId' => $playerId,
            'investments' => $playerInvestments,
            'total' => $playerTotal,
        ]);
    }
}

