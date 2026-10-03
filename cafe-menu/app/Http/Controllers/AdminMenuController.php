<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Services\MealDbService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminMenuController extends Controller
{
    public function search(Request $r, MealDbService $api)
    {
        $meals = $r->filled('q') ? $api->search($r->q) : [];
        $existing = $meals
            ? MenuItem::whereIn('meal_id', collect($meals)->pluck('idMeal')->all())->pluck('meal_id')->all()
            : [];
        return view('admin.search', compact('meals', 'existing'));
    }

    public function store(Request $r, MealDbService $api)
    {
        $data = $r->validate([
            'meal_id' => 'required|string',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:ada,habis',
        ]);

        if (MenuItem::where('meal_id', $data['meal_id'])->exists()) {
            return back()->withErrors(['meal_id' => 'Resipi ini sudah ada dalam menu.']);
        }

        $meal = $api->find($data['meal_id']);
        abort_if(! $meal, 404);

        MenuItem::create([
            'meal_id' => $meal['idMeal'],
            'name' => $meal['strMeal'],
            'image' => $meal['strMealThumb'],
            'category' => $meal['strCategory'],
            'area' => $meal['strArea'],
            'instructions' => Str::limit($meal['strInstructions'] ?? '', 3900, ''),
            'ingredients' => MealDbService::ingredients($meal),
            'price' => $data['price'],
            'status' => $data['status'],
        ]);

        return redirect()->route('menu.index')->with('ok', 'Ditambah ke menu.');
    }

    public function edit(MenuItem $menu)
    {
        return view('admin.edit', ['item' => $menu]);
    }

    public function update(Request $r, MenuItem $menu)
    {
        $menu->update($r->validate([
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:ada,habis',
        ]));
        return redirect()->route('menu.index')->with('ok', 'Dikemas kini.');
    }

    public function destroy(MenuItem $menu)
    {
        $menu->delete();
        return back()->with('ok', 'Dipadam.');
    }

    public function export()
    {
        return response()->streamDownload(function () {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Meal ID', 'Nama', 'Kategori', 'Harga', 'Status']);
            foreach (MenuItem::orderBy('name')->get() as $m) {
                fputcsv($out, [$m->meal_id, $m->name, $m->category, $m->price, $m->status]);
            }
            fclose($out);
        }, 'menu.csv', ['Content-Type' => 'text/csv']);
    }
}
