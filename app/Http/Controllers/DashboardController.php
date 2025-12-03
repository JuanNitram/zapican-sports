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
            'total_players' => 5,
            'active_contracts' => 4,
            'contracts_expiring_soon' => 2,
            'total_investment' => 29000,
        ];

        $alerts = [
            [
                'id' => 1,
                'type' => 'contract_expiring',
                'priority' => 'high',
                'title' => 'Contrato próximo a vencer',
                'description' => 'El contrato de María González vence en 15 días',
                'player_name' => 'María González',
                'date' => '2024-12-16',
            ],
            [
                'id' => 2,
                'type' => 'contract_expired',
                'priority' => 'critical',
                'title' => 'Contrato vencido',
                'description' => 'El contrato de Ana Martínez ha vencido',
                'player_name' => 'Ana Martínez',
                'date' => '2024-12-01',
            ],
            [
                'id' => 3,
                'type' => 'contract_expiring',
                'priority' => 'medium',
                'title' => 'Contrato próximo a vencer',
                'description' => 'El contrato de Juan Pérez vence en 45 días',
                'player_name' => 'Juan Pérez',
                'date' => '2025-01-14',
            ],
        ];

        $recent_activities = [
            [
                'id' => 1,
                'type' => 'contract',
                'description' => 'Nuevo contrato registrado: Carlos Rodríguez',
                'date' => '2024-12-10 10:30',
            ],
            [
                'id' => 2,
                'type' => 'investment',
                'description' => 'Nueva inversión registrada: $6,000 - Carlos Rodríguez',
                'date' => '2024-12-08 15:20',
            ],
            [
                'id' => 3,
                'type' => 'player',
                'description' => 'Jugador actualizado: Luis Sánchez',
                'date' => '2024-12-05 09:15',
            ],
        ];

        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'alerts' => $alerts,
            'recentActivities' => $recent_activities,
        ]);
    }
}


