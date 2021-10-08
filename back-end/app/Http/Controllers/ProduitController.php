<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Produit::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Produit::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function show(Produit $produit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function edit(Produit $produit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produit $produit)
    {
       
        // return response(['success' => true, 'message' => 'update product succesfuly !', 'data' => $produit]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produit $produit)
    {
        return Produit::destroy($produit);
    }
    //get Produits By Commande
    public function getProduitsByCommande($id)
    {
        $produit = DB::table('produits')->distinct()
            ->join('produit_commandes', 'produits.id', '=', 'produit_commandes.produit_id')
            ->join('commandes', 'commandes.id', '=', 'produit_commandes.commande_id')
            ->select('produit_commandes.*')->where('commandes.id', '=', $id)
            ->get();
        if (is_null($produit)) {
            return $this->sendError('Products not found.');
        }
        return response([
            "success" => true,
            "message" => "List of products to order.",
            "data" => $produit
        ], 201);
    }
}
