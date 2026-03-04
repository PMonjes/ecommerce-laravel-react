<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $q = Product::query()
            ->with(['category', 'images'])
            ->where('is_active', true);

        if ($request->filled('category')) {
            $q->whereHas('category', fn($c) => $c->where('slug', $request->string('category')));
        }

        if ($request->filled('search')) {
            $term = $request->string('search');
            $q->where('name', 'like', "%{$term}%");
        }

        return $q->orderBy('sort_order')
            ->orderByDesc('id')
            ->paginate(12);
    }

    public function show(string $slug)
    {
        return Product::query()
            ->with(['category', 'images'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
    }
}