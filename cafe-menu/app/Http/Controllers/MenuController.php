<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Services\MealDbService;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $r, MealDbService $api)
    {
        $query = MenuItem::query()
            ->when($r->q, fn ($q, $v) => $q->whereRaw('LOWER(name) LIKE ?', ['%' . mb_strtolower($v) . '%']))
            ->when($r->category, fn ($q, $v) => $q->where('category', $v))
            ->orderBy('name');

        $items = $query->paginate(10)->withQueryString();
        $isGrouped = false;

        return view('menu.index', [
            'items' => $items, 
            'categories' => $api->categories(),
            'isGrouped' => $isGrouped
        ]);
    }

    public function show(MenuItem $menu)
    {
        return view('menu.show', ['item' => $menu]);
    }
}
