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
        $categories = $api->categories();
        $meals = [];
        
        if ($r->filled('q')) {
            $meals = $api->search($r->q);
        } elseif ($r->filled('c')) {
            $meals = $api->byCategory($r->c);
            if ($meals) {
                foreach ($meals as &$meal) {
                    $meal['strCategory'] = $r->c;
                }
            }
        }

        $existing = $meals
            ? MenuItem::whereIn('meal_id', collect($meals)->pluck('idMeal')->all())->pluck('meal_id')->all()
            : [];
            
        return view('admin.search', compact('meals', 'existing', 'categories'));
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

    public function import(Request $r, MealDbService $api)
    {
        $r->validate([
            'csv_file' => 'required|file|mimes:csv,txt'
        ]);

        $file = $r->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');
        
        $header = fgetcsv($handle);
        if (!$header || !in_array('Meal ID', $header)) {
            fclose($handle);
            return back()->withErrors(['csv_file' => 'Format CSV tidak sah. Pastikan diexport dari sistem.']);
        }
        
        $colMealId = array_search('Meal ID', $header);
        $colPrice = array_search('Harga', $header);
        $colStatus = array_search('Status', $header);

        if ($colMealId === false || $colPrice === false || $colStatus === false) {
            fclose($handle);
            return back()->withErrors(['csv_file' => 'Kolum yang diperlukan (Meal ID, Harga, Status) tidak dijumpai.']);
        }

        $count = 0;
        while (($row = fgetcsv($handle)) !== false) {
            if (!isset($row[$colMealId])) continue;
            
            $mealId = $row[$colMealId];
            $price = floatval($row[$colPrice] ?? 0);
            $status = trim(strtolower($row[$colStatus] ?? ''));
            if (!in_array($status, ['ada', 'habis'])) {
                $status = 'ada';
            }
            
            $existing = MenuItem::where('meal_id', $mealId)->first();
            if ($existing) {
                $existing->update(['price' => $price, 'status' => $status]);
                $count++;
            } else {
                $meal = $api->find($mealId);
                if ($meal) {
                    MenuItem::create([
                        'meal_id' => $meal['idMeal'],
                        'name' => $meal['strMeal'],
                        'image' => $meal['strMealThumb'],
                        'category' => $meal['strCategory'],
                        'area' => $meal['strArea'],
                        'instructions' => Str::limit($meal['strInstructions'] ?? '', 3900, ''),
                        'ingredients' => MealDbService::ingredients($meal),
                        'price' => $price,
                        'status' => $status,
                    ]);
                    $count++;
                }
            }
        }
        fclose($handle);

        return back()->with('ok', "$count menu berjaya diimport/dikemaskini.");
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
