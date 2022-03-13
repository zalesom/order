<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{

    public function index(): Response
    {
        $paginator = Product::latest()
            ->paginate()
            ->withQueryString()
            ->through(fn ($product) => [
                'id' => $product->id,
                'title' => $product->title,
                'price' => $product->price
            ]);

        return Inertia::render('Products/Index', compact('paginator'));
    }


    public function create(): Response
    {
        return Inertia::render('Products/Create', []);
    }


    public function store(StoreProductRequest $request): RedirectResponse
    {
        $attributes = $request->validated();
        Product::create($attributes);

        return Redirect::route('admin.products.index')->with('success', __('products.created'));
    }


    public function edit(Product $product): Response
    {
        return Inertia::render('Products/Edit', compact('product'));
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $attributes = $request->validated();
        $product->update($attributes);

        return Redirect::route('admin.products.index')->with('success', __('products.updated'));
    }


    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return Redirect::route('admin.products.index')->with('success', __('products.deleted'));
    }
}
