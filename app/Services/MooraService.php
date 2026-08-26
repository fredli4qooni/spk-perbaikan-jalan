<?php

namespace App\Services;

use App\Models\Criterion;
use App\Models\Road;

class MooraService
{
    public function calculate(): array
    {
        $roads = Road::with(['scores.criterion'])->orderBy('id')->get();
        $criteria = Criterion::orderBy('code')->orderBy('id')->get();

        $weights = $this->normalizeWeights($criteria);
        $denominators = $this->calculateDenominators($roads, $criteria);

        $rows = [];

        foreach ($roads as $road) {
            $benefitTotal = 0;
            $costTotal = 0;
            $normalized = [];
            $weighted = [];

            foreach ($criteria as $criterion) {
                $score = $this->getRoadCriterionValue($road, $criterion);
                $denominator = $denominators[$criterion->id] ?? 0;
                $normalizedValue = $denominator > 0 ? $score / $denominator : 0;
                $weightedValue = $normalizedValue * ($weights[$criterion->id] ?? 0);

                $normalized[$criterion->id] = $normalizedValue;
                $weighted[$criterion->id] = $weightedValue;

                if (strtolower($criterion->type) === 'cost') {
                    $costTotal += $weightedValue;
                } else {
                    $benefitTotal += $weightedValue;
                }
            }

            $rows[] = [
                'road' => $road,
                'scores' => $this->mapScores($road, $criteria),
                'normalized' => $normalized,
                'weighted' => $weighted,
                'benefit_total' => $benefitTotal,
                'cost_total' => $costTotal,
                'result' => $benefitTotal - $costTotal,
            ];
        }

        // Sort descending by MOORA result (Yi)
        usort($rows, fn ($a, $b) => $b['result'] <=> $a['result']);

        foreach ($rows as $index => &$row) {
            $row['rank'] = $index + 1;
        }

        return [
            'criteria' => $criteria,
            'weights' => $weights,
            'denominators' => $denominators,
            'results' => $rows,
        ];
    }

    private function normalizeWeights($criteria): array
    {
        $sum = max($criteria->sum('weight'), 0.000001);
        $weights = [];

        foreach ($criteria as $criterion) {
            $weights[$criterion->id] = $criterion->weight / $sum;
        }

        return $weights;
    }

    private function calculateDenominators($roads, $criteria): array
    {
        $denominators = [];

        foreach ($criteria as $criterion) {
            $sumSquares = 0;

            foreach ($roads as $road) {
                $value = $this->getRoadCriterionValue($road, $criterion);
                $sumSquares += pow($value, 2);
            }

            $denominators[$criterion->id] = sqrt($sumSquares);
        }

        return $denominators;
    }

    public function getRoadCriterionValue(Road $road, Criterion $criterion): float
    {
        // Prefer explicit RoadScore if present
        $score = $road->scores->firstWhere('criterion_id', $criterion->id);
        if ($score && $score->value !== null) {
            return (float) $score->value;
        }

        // Map scale values 1-5 directly from road attributes
        $code = strtoupper($criterion->code ?? '');

        switch ($code) {
            case 'C1': // Panjang Kerusakan Jalan (Skala 1 - 5)
                return (float) ($road->c1_panjang ?: 1);
            case 'C2': // Lebar Jalan (Skala 1 - 5)
                return (float) ($road->c2_lebar ?: 1);
            case 'C3': // Kedalaman Lubang (Skala 1 - 5)
                return (float) ($road->c3_kedalaman ?: 1);
            case 'C4': // Banyaknya Lubang (Skala 1 - 5)
                return (float) ($road->c4_lubang ?: 1);
            case 'C5': // Tingkat Kepentingan Jalan (Skala 1 - 5)
                return (float) ($road->c5_kepentingan ?: 1);
            default:
                return 1.0;
        }
    }

    private function mapScores(Road $road, $criteria): array
    {
        $values = [];

        foreach ($criteria as $criterion) {
            $values[$criterion->id] = $this->getRoadCriterionValue($road, $criterion);
        }

        return $values;
    }
}
