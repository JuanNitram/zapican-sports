<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class ContractController extends Controller
{
    public function index(): Response
    {
        // Mock data for contracts
        $contracts = [
            [
                'id' => 1,
                'player_id' => 1,
                'player_name' => 'Juan Pérez',
                'club' => 'Club Atlético Nacional',
                'start_date' => '2024-01-15',
                'end_date' => '2025-01-14',
                'status' => 'activo',
                'type' => 'Profesional',
                'salary' => 50000,
                'renewal_count' => 0,
                'days_until_expiry' => 45,
            ],
            [
                'id' => 2,
                'player_id' => 2,
                'player_name' => 'María González',
                'club' => 'Club Deportivo Los Leones',
                'start_date' => '2023-06-01',
                'end_date' => '2024-12-31',
                'status' => 'activo',
                'type' => 'Profesional',
                'salary' => 45000,
                'renewal_count' => 1,
                'days_until_expiry' => 15,
            ],
            [
                'id' => 3,
                'player_id' => 3,
                'player_name' => 'Carlos Rodríguez',
                'club' => 'Club Atlético Nacional',
                'start_date' => '2024-03-01',
                'end_date' => '2026-02-28',
                'status' => 'activo',
                'type' => 'Profesional',
                'salary' => 60000,
                'renewal_count' => 0,
                'days_until_expiry' => 425,
            ],
            [
                'id' => 4,
                'player_id' => 4,
                'player_name' => 'Ana Martínez',
                'club' => 'Club Deportivo Los Leones',
                'start_date' => '2022-01-10',
                'end_date' => '2024-12-31',
                'status' => 'vencido',
                'type' => 'Profesional',
                'salary' => 40000,
                'renewal_count' => 2,
                'days_until_expiry' => -15,
            ],
            [
                'id' => 5,
                'player_id' => 5,
                'player_name' => 'Luis Sánchez',
                'club' => 'Club Deportivo Central',
                'start_date' => '2024-07-01',
                'end_date' => '2025-06-30',
                'status' => 'activo',
                'type' => 'Profesional',
                'salary' => 55000,
                'renewal_count' => 0,
                'days_until_expiry' => 182,
            ],
        ];

        $stats = [
            'total_contracts' => count($contracts),
            'active_contracts' => count(array_filter($contracts, fn($c) => $c['status'] === 'activo')),
            'expiring_soon' => count(array_filter($contracts, fn($c) => $c['days_until_expiry'] > 0 && $c['days_until_expiry'] <= 30)),
            'expired' => count(array_filter($contracts, fn($c) => $c['days_until_expiry'] < 0)),
        ];

        return Inertia::render('Contracts/Index', [
            'contracts' => $contracts,
            'stats' => $stats,
        ]);
    }

    public function show($id): Response
    {
        // Mock documents data by contract ID
        $documentsByContract = [
            1 => [
                [
                    'id' => 1,
                    'name' => 'Contrato Original',
                    'type' => 'Contrato',
                    'uploaded_at' => '2024-01-15',
                    'size' => '2.5 MB',
                    'format' => 'PDF',
                ],
                [
                    'id' => 2,
                    'name' => 'Anexo de Cláusulas',
                    'type' => 'Contrato',
                    'uploaded_at' => '2024-01-16',
                    'size' => '1.2 MB',
                    'format' => 'PDF',
                ],
                [
                    'id' => 3,
                    'name' => 'Certificado Médico Pre-Contrato',
                    'type' => 'Médico',
                    'uploaded_at' => '2024-01-10',
                    'size' => '850 KB',
                    'format' => 'PDF',
                ],
            ],
            2 => [
                [
                    'id' => 4,
                    'name' => 'Contrato Renovado',
                    'type' => 'Contrato',
                    'uploaded_at' => '2023-06-01',
                    'size' => '2.1 MB',
                    'format' => 'PDF',
                ],
                [
                    'id' => 5,
                    'name' => 'Acta de Renovación',
                    'type' => 'Contrato',
                    'uploaded_at' => '2023-05-28',
                    'size' => '950 KB',
                    'format' => 'PDF',
                ],
            ],
            3 => [
                [
                    'id' => 6,
                    'name' => 'Contrato Profesional',
                    'type' => 'Contrato',
                    'uploaded_at' => '2024-03-01',
                    'size' => '3.2 MB',
                    'format' => 'PDF',
                ],
                [
                    'id' => 7,
                    'name' => 'Certificado de Transferencia',
                    'type' => 'Transferencia',
                    'uploaded_at' => '2024-02-25',
                    'size' => '1.5 MB',
                    'format' => 'PDF',
                ],
            ],
            4 => [
                [
                    'id' => 8,
                    'name' => 'Contrato Vencido',
                    'type' => 'Contrato',
                    'uploaded_at' => '2022-01-10',
                    'size' => '2.0 MB',
                    'format' => 'PDF',
                ],
            ],
            5 => [
                [
                    'id' => 9,
                    'name' => 'Contrato Actual',
                    'type' => 'Contrato',
                    'uploaded_at' => '2024-07-01',
                    'size' => '2.8 MB',
                    'format' => 'PDF',
                ],
            ],
        ];

        // Mock detailed contract data
        $contracts = [
            1 => [
                'id' => 1,
                'player_id' => 1,
                'player_name' => 'Juan Pérez',
                'club' => 'Club Atlético Nacional',
                'start_date' => '2024-01-15',
                'end_date' => '2025-01-14',
                'status' => 'activo',
                'type' => 'Profesional',
                'salary' => 50000,
                'renewal_count' => 0,
                'days_until_expiry' => 45,
                'duration_days' => 365,
                'bonus' => 10000,
                'clauses' => 'Cláusula de rescisión: $500,000',
            ],
            2 => [
                'id' => 2,
                'player_id' => 2,
                'player_name' => 'María González',
                'club' => 'Club Deportivo Los Leones',
                'start_date' => '2023-06-01',
                'end_date' => '2024-12-31',
                'status' => 'activo',
                'type' => 'Profesional',
                'salary' => 45000,
                'renewal_count' => 1,
                'days_until_expiry' => 15,
                'duration_days' => 579,
                'bonus' => 8000,
                'clauses' => 'Cláusula de rescisión: $400,000',
            ],
            3 => [
                'id' => 3,
                'player_id' => 3,
                'player_name' => 'Carlos Rodríguez',
                'club' => 'Club Atlético Nacional',
                'start_date' => '2024-03-01',
                'end_date' => '2026-02-28',
                'status' => 'activo',
                'type' => 'Profesional',
                'salary' => 60000,
                'renewal_count' => 0,
                'duration_days' => 730,
                'days_until_expiry' => 425,
                'bonus' => 15000,
                'clauses' => 'Cláusula de rescisión: $800,000',
            ],
            4 => [
                'id' => 4,
                'player_id' => 4,
                'player_name' => 'Ana Martínez',
                'club' => 'Club Deportivo Los Leones',
                'start_date' => '2022-01-10',
                'end_date' => '2024-12-31',
                'status' => 'vencido',
                'type' => 'Profesional',
                'salary' => 40000,
                'renewal_count' => 2,
                'days_until_expiry' => -15,
                'duration_days' => 1085,
                'bonus' => 5000,
                'clauses' => 'Cláusula de rescisión: $300,000',
            ],
            5 => [
                'id' => 5,
                'player_id' => 5,
                'player_name' => 'Luis Sánchez',
                'club' => 'Club Deportivo Central',
                'start_date' => '2024-07-01',
                'end_date' => '2025-06-30',
                'status' => 'activo',
                'type' => 'Profesional',
                'salary' => 55000,
                'renewal_count' => 0,
                'days_until_expiry' => 182,
                'duration_days' => 365,
                'bonus' => 12000,
                'clauses' => 'Cláusula de rescisión: $600,000',
            ],
        ];

        $contract = $contracts[$id] ?? $contracts[1];
        $contract['documents'] = $documentsByContract[$id] ?? [];

        return Inertia::render('Contracts/Show', [
            'contract' => $contract,
        ]);
    }
}

