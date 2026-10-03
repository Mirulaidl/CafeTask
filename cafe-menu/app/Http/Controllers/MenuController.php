<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Services\MealDbService;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $r, MealDbService $api)
    {
        $items = MenuItem::query()
            ->when($r->q, fn ($q, $v) => $q->whereRaw('LOWER(name) LIKE ?', ['%' . mb_strtolower($v) . '%']))
            ->when($r->category, fn ($q, $v) => $q->where('category', $v))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('menu.index', ['items' => $items, 'categories' => $api->categories()]);
    }

    public function show(MenuItem $menu)
    {
        return view('menu.show', ['item' => $menu]);
    }
}
