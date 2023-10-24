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

        return view('home', compact('products'));
    }

    public function clothes()
    {
        $transactionsKeranjang = Transaction::with("products")->where("users_id", Auth::user()->id)->where("status", "dikeranjang")->get();
        $transactionsBayar = Transaction::with("products")->where("users_id", Auth::user()->id)->where("status", "dibayar")->get();
        $wallet = Wallet::where("users_id", Auth::user()->id)->where("status", "selesai")->get();
        $creditTotal = $wallet->sum('credit');
        $debitTotal = $wallet->sum('debit');
        $difference = $creditTotal - $debitTotal;

        $clots = Category::where("name", "pakaian")->with("products")->get();
        return view('clothing', compact('clots', 'transactionsKeranjang', 'transactionsBayar', 'difference'));
    }

    public function drinks()
    {
        $transactionsKeranjang = Transaction::with("products")->where("users_id", Auth::user()->id)->where("status", "dikeranjang")->get();
        $transactionsBayar = Transaction::with("products")->where("users_id", Auth::user()->id)->where("status", "dibayar")->get();
        $wallet = Wallet::where("users_id", Auth::user()->id)->where("status", "selesai")->get();
        $creditTotal = $wallet->sum('credit');
        $debitTotal = $wallet->sum('debit');
        $difference = $creditTotal - $debitTotal;

        $drinks = Category::where("name", "minuman")->with("products")->get();
        return view('drink', compact('drinks', 'transactionsKeranjang', 'transactionsBayar', 'difference'));
    }

    public function foods()
    {
        $transactionsKeranjang = Transaction::with("products")->where("users_id", Auth::user()->id)->where("status", "dikeranjang")->get();
        $transactionsBayar = Transaction::with("products")->where("users_id", Auth::user()->id)->where("status", "dibayar")->get();
        $wallet = Wallet::where("users_id", Auth::user()->id)->where("status", "selesai")->get();
        $creditTotal = $wallet->sum('credit');
        $debitTotal = $wallet->sum('debit');
        $difference = $creditTotal - $debitTotal;

        $foods = Category::where("name", "makanan")->with("products")->get();
        return view('food', compact('foods', 'transactionsKeranjang', 'transactionsBayar', 'difference'));
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


        return redirect("/admin");
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
    public function edit($id)
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

        if ($request->hasFile('photo')) {
            $request->file('photo')->move("photos/", "$request->name.png");
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

        return to_route("/kantin");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $productToDelete = Product::find($id);

        $productImagePath = $productToDelete->photo;

        if (!unlink(public_path($productImagePath))) {
            $productToDelete->delete();
        } else {
            $productToDelete->delete();
            Storage::delete($productToDelete->photo);
        }

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
