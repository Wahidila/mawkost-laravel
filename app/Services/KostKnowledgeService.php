<?php

namespace App\Services;

use App\Models\City;
use App\Models\Kost;
use App\Models\KostType;
use Illuminate\Support\Facades\Cache;

class KostKnowledgeService
{
    /**
     * Cache duration in seconds (5 minutes).
     */
    protected int $cacheTtl = 300;

    /**
     * Build the full knowledge base text for AI system prompt.
     * Cached for performance.
     */
    public function buildKnowledgeBase(): string
    {
        return Cache::remember('ai_kost_knowledge_base', $this->cacheTtl, function () {
            $summary = $this->getKostSummary();
            $listings = $this->getKostListings();

            return $this->formatKnowledgeText($summary, $listings);
        });
    }

    /**
     * Get summary statistics of all kost data.
     */
    public function getKostSummary(): array
    {
        return Cache::remember('ai_kost_summary', $this->cacheTtl, function () {
            $totalKost = Kost::count();
            $cities = City::withCount('kosts')->orderBy('name')->get();
            $kostTypes = KostType::withCount('kosts')->orderBy('name')->get();
            $priceMin = Kost::min('price');
            $priceMax = Kost::max('price');
            $featuredCount = Kost::where('is_featured', true)->count();
            $recommendedCount = Kost::where('is_recommended', true)->count();

            return [
                'total_kost' => $totalKost,
                'cities' => $cities->map(fn($c) => [
                    'name' => $c->name,
                    'slug' => $c->slug,
                    'kost_count' => $c->kosts_count,
                ])->toArray(),
                'kost_types' => $kostTypes->map(fn($t) => [
                    'name' => $t->name,
                    'slug' => $t->slug,
                    'kost_count' => $t->kosts_count,
                ])->toArray(),
                'price_range' => [
                    'min' => $priceMin,
                    'max' => $priceMax,
                ],
                'featured_count' => $featuredCount,
                'recommended_count' => $recommendedCount,
            ];
        });
    }

    /**
     * Get all kost listings with compact fields for AI knowledge.
     * Excluded: alamat (berbayar), total_kamar, total_kamar_mandi, lantai, harga_unlock.
     */
    public function getKostListings(): array
    {
        return Cache::remember('ai_kost_listings', $this->cacheTtl, function () {
            return Kost::with(['city', 'kostType', 'facilities', 'nearbyPlaces'])
                ->orderBy('city_id')
                ->orderByDesc('is_featured')
                ->orderByDesc('is_recommended')
                ->get()
                ->map(function ($kost) {
                    $facilities = $kost->facilities->pluck('name')->implode(',');
                    $nearbyPlaces = $kost->nearbyPlaces->pluck('description')->implode(',');

                    // Labels
                    $labels = [];
                    if ($kost->is_featured) $labels[] = 'UNGGULAN';
                    if ($kost->is_recommended) $labels[] = 'REKOMENDASI';

                    // Price in thousands (800 = Rp 800.000)
                    $priceK = round($kost->price / 1000);

                    return [
                        'kode' => $kost->kode,
                        'nama' => $kost->title,
                        'kota' => $kost->city->name ?? '-',
                        'tipe' => $kost->kostType->name ?? $kost->type ?? '-',
                        'harga_rb' => $priceK,
                        'area' => $kost->area_label ?: '',
                        'parkir' => $kost->parking_type ?: '',
                        'fasilitas' => $facilities,
                        'dekat' => $nearbyPlaces,
                        'label' => implode(',', $labels),
                        'url' => "/kost/" . ($kost->city->slug ?? '') . "/{$kost->slug}",
                    ];
                })
                ->toArray();
        });
    }

    /**
     * Format knowledge data into compact CSV-like text for AI system prompt.
     * ~70% smaller than verbose format.
     */
    protected function formatKnowledgeText(array $summary, array $listings): string
    {
        $text = "=== DATA KOST MAWKOST ===\n";
        $text .= "Total:{$summary['total_kost']}";
        $text .= " Harga:" . round($summary['price_range']['min'] / 1000) . "rb-" . round($summary['price_range']['max'] / 1000) . "rb/bln";
        $text .= " Unggulan:{$summary['featured_count']} Rekomendasi:{$summary['recommended_count']}\n";

        // Cities compact
        $cityParts = [];
        foreach ($summary['cities'] as $city) {
            $cityParts[] = "{$city['name']}({$city['kost_count']})";
        }
        $text .= "Kota: " . implode(', ', $cityParts) . "\n";

        // Types compact
        $typeParts = [];
        foreach ($summary['kost_types'] as $type) {
            $typeParts[] = "{$type['name']}({$type['kost_count']})";
        }
        $text .= "Tipe: " . implode(', ', $typeParts) . "\n\n";

        // CSV header
        $text .= "KODE|NAMA|KOTA|TIPE|HARGA_RB|AREA|PARKIR|FASILITAS|DEKAT|LABEL|URL\n";

        // CSV rows
        foreach ($listings as $kost) {
            $text .= implode('|', [
                $kost['kode'],
                $kost['nama'],
                $kost['kota'],
                $kost['tipe'],
                $kost['harga_rb'],
                $kost['area'],
                $kost['parkir'],
                $kost['fasilitas'],
                $kost['dekat'],
                $kost['label'],
                $kost['url'],
            ]) . "\n";
        }

        return $text;
    }

    /**
     * Clear the knowledge cache (call when kost data is updated).
     */
    public function clearCache(): void
    {
        Cache::forget('ai_kost_knowledge_base');
        Cache::forget('ai_kost_summary');
        Cache::forget('ai_kost_listings');
    }
}
