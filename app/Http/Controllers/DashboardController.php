<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        // Mock data for dashboard
        $stats = [
            'total_players' => 45,
            'active_teams' => 8,
            'upcoming_matches' => 3,
            'total_matches' => 127,
        ];

        $recent_activities = [
            [
                'id' => 1,
                'type' => 'match',
                'description' => 'Nuevo partido programado: Equipo A vs Equipo B',
                'date' => '2024-01-15 10:30',
            ],
            [
                'id' => 2,
                'type' => 'player',
                'description' => 'Nuevo jugador registrado: Juan Pérez',
                'date' => '2024-01-14 15:20',
            ],
            [
                'id' => 3,
                'type' => 'team',
                'description' => 'Equipo actualizado: Los Leones',
                'date' => '2024-01-14 09:15',
            ],
        ];

        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'recentActivities' => $recent_activities,
        ]);
    }
}

