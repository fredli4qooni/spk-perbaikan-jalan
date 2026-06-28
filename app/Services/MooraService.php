<?php

namespace App\Services;

use App\Models\Criterion;
use App\Models\Road;

class MooraService
{
    public function calculate(): array
    {
        $roads = Road::with(['scores.criterion'])->orderBy('name')->get();
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

    private function getRoadCriterionValue(Road $road, Criterion $criterion): float
    {
        // Prefer explicit RoadScore if present
        $score = $road->scores->firstWhere('criterion_id', $criterion->id);
        if ($score && $score->value !== null) {
            return (float) $score->value;
        }

        // Fallback: derive values from Road attributes for known criteria codes
        $code = strtoupper($criterion->code ?? '');

        switch ($code) {
            case 'C1': // Panjang Jalan (m)
                return (float) ($road->length ?? 0);
            case 'C2': // Lebar Jalan (m)
                return (float) ($road->width ?? 0);
            case 'C3': // Banyaknya Lubang (buah)
                return (float) ($road->holes_count ?? 0);
            case 'C4': // Kedalaman Lubang (cm)
                return (float) ($road->hole_depth ?? 0);
            case 'C6': // Kepentingan Jalan (kategori)
                $map = [
                    'SEKOLAH' => 5,
                    'PASAR' => 4,
                    'KANTOR' => 3,
                    'LAINNYA' => 1,
                ];
                $imp = strtoupper((string) ($road->importance ?? ''));
                return (float) ($map[$imp] ?? 1);
            case 'C5': // Tingkat Kerusakan (perkiraan): gunakan lubang * kedalaman
                $holes = (float) ($road->holes_count ?? 0);
                $depth = (float) ($road->hole_depth ?? 0);
                // jika panjang tersedia, hitung intensitas per 100m sebagai proxy
                $length = (float) ($road->length ?? 0);
                $intensity = $holes * $depth;
                if ($length > 0) {
                    $intensity = $intensity / max(0.1, ($length / 100.0));
                }
                return $intensity;
            case 'C7': // Biaya Perbaikan (perkiraan): fungsi sederhana
                $len = (float) ($road->length ?? 0);
                $wid = (float) ($road->width ?? 0);
                $holes = (float) ($road->holes_count ?? 0);
                $depth = (float) ($road->hole_depth ?? 0);
                // biaya = area * unit_cost + lubang * depth * factor
                $areaCost = ($len * $wid) * 50000; // asumsi biaya per m2
                $holeCost = ($holes * $depth) * 1000; // asumsi
                return $areaCost + $holeCost;
            default:
                return 0.0;
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
