<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class MealDbService
{
    private string $base = 'https://www.themealdb.com/api/json/v1/1';

    public function search(string $name): array
    {
        return Http::get("{$this->base}/search.php", ['s' => $name])->json('meals') ?? [];
    }

    public function find(string $id): ?array
    {
        return Http::get("{$this->base}/lookup.php", ['i' => $id])->json('meals.0');
    }

    public function categories(): array
    {
        return Cache::remember('mealdb_categories', 3600, fn () =>
            collect(Http::get("{$this->base}/categories.php")->json('categories') ?? [])
                ->pluck('strCategory')->all()
        );
    }

    public static function ingredients(array $meal): array
    {
        $list = [];
        for ($i = 1; $i <= 20; $i++) {
            $name = trim($meal["strIngredient$i"] ?? '');
            if ($name !== '') {
                $list[] = ['name' => $name, 'measure' => trim($meal["strMeasure$i"] ?? '')];
            }
        }
        return $list;
    }
}
