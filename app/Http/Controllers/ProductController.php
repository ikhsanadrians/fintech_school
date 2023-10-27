<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        $categories = Category::all();

        return view('home', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view("tambahProduct", compact("categories"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        if ($request->hasFile('photo')) {
            $request->file('photo')->move("photos/", "$request->name.png");
        }

        Product::create([
            "name" => $request->name,
            "price" => $request->price,
            "stock" => $request->stock,
            "photo" => "/photos/$request->name.png",
            "desc" => $request->desc,
            "categories_id" => $request->categories_id,
            "stand" => $request->stand,
        ]);


        return redirect("/kantin");
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        $wallet = Wallet::where("users_id", Auth::user()->id)->where("status", "selesai")->get();
        $creditTotal = $wallet->sum('credit');
        $debitTotal = $wallet->sum('debit');
        $difference = $creditTotal - $debitTotal;
        $transactionsKeranjang = Transaction::with("products")->where("users_id", Auth::user()->id)->where("status", "dikeranjang")->get();

        return view("detail", compact("product", "transactionsKeranjang", "difference"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $product = Product::find($id);
        $categories = Category::all();
        return view('editProduct', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        $productImagePath = $product->photo;

        if ($request->hasFile('photo')) {
            $request->file('photo')->move("photos/", "$request->name.png");
            if (!unlink(public_path($productImagePath))) {
                Storage::delete($product->photo);
            } else {
                Storage::delete($product->photo);
            }
        }

        $product->update([
            "name" => $request->name,
            "price" => $request->price,
            "stock" => $request->stock,
            "photo" => "/photos/$request->name.png",
            "desc" => $request->desc,
            "categories_id" => $request->categories_id,
            "stand" => $request->stand
        ]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $productToDelete = Product::withTrashed()->find($id);

        $productImagePath = $productToDelete->photo;

        if ($request->hasFile('photo')) {
            $request->file('photo')->move("photos/", "$request->name.png");
            if (!unlink(public_path($productImagePath))) {
                Storage::delete($productToDelete->photo);
            } else {
                Storage::delete($productToDelete->photo);
            }
        }

        $productToDelete->delete();

        return redirect()->back();
    }

    public function allProduct(Request $request)
    {
        $transactionsKeranjang = Transaction::with("products")->where("users_id", Auth::user()->id)->where("status", "dikeranjang")->get();
        $transactionsBayar = Transaction::with("products")->where("users_id", Auth::user()->id)->where("status", "dibayar")->get();
        $wallet = Wallet::where("users_id", Auth::user()->id)->where("status", "selesai")->get();
        $creditTotal = $wallet->sum('credit');
        $debitTotal = $wallet->sum('debit');
        $difference = $creditTotal - $debitTotal;

        $products = null;
        $category = $request->index;
        $category_id = Category::where("name", $category)->first();

        if ($category == "") {
            $products = Product::all();
        } else {
            $products = Product::where("categories_id", $category_id->id)->get();
        }

        return view("category_product", compact("products", "difference", "transactionsKeranjang"));
    }
}
