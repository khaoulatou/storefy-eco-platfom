<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\ProduitCommande;
use Illuminate\Http\Request;

class ProduitCommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        // 'produit_id',
        // 'commande_id',
        // 'upsell',
        // 'quantite',
        // 'totale' => null,
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProduitCommande  $produitCommande
     * @return \Illuminate\Http\Response
     */
    public function show(ProduitCommande $produitCommande)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProduitCommande  $produitCommande
     * @return \Illuminate\Http\Response
     */
    public function edit(ProduitCommande $produitCommande)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProduitCommande  $produitCommande
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProduitCommande $produitCommande)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProduitCommande  $produitCommande
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProduitCommande $produitCommande)
    {
        //
    }

    //checkout
    public function checkout($products, $idCommande)
    {
        $array = [];
        foreach ($products as  $product) {
            $product['id'];
            $productUp = Produit::find($product['id']);
            if ($productUp->prix_promotion === 0) {
                $totale = $productUp->prix * $product['quantity'];
            } else {
                $totale = $productUp->prix_promotion * $product['quantity'];
            }
            $proco = ProduitCommande::create([
                'produit_id' => $product['id'],
                'commande_id' => $idCommande,
                'upsell' => $product['upsell'],
                'quantite' => $product['quantity'],
                'totale' => $totale,
            ]);
            array_push($array, [
                'produit_id' => $product['id'],
                'commande_id' => $idCommande,
                'upsell' => $product['upsell'],
                'quantite' => $product['quantity'],
                'totale' => $totale,
                'ProduitCommande' => $proco->commande_id,
            ]);
        }
        return response([
            "success" => true,
            "message" => "List of commandes .",
            "data" => $array,
        ]);
    }
}
