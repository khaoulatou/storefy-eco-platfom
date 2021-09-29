<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\TextUI\XmlConfiguration\Group;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Commande::all();
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
        return Commande::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function show(Commande $commande)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function edit(Commande $commande)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commande $commande)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commande $commande)
    {
        //
    }

    public function showCommandes()
    {
        // return DB::table('commandes')->where('phone1','0606060606 4')->value('addresse');
        // return DB::table('commandes')->select()->where('phone1', '0606060606 4')->value('addresse');
        return DB::table('commandes')
            ->select(
                'commandes.id',
                'commandes.destinataire',
                'commandes.phone1 as phone 1',
                'commandes.phone2 as phone 2',
                'commandes.ville_customer as ville',
                'commandes.addresse',
                DB::raw('SUM(produit_commandes.totale * produit_commandes.quantite) as totale')
            )
            ->groupBy(
                'commandes.id',
                'commandes.destinataire',
                'commandes.phone1',
                'commandes.phone2',
                'commandes.ville_customer',
                'commandes.addresse'
            )->join(
                'produit_commandes',
                'commandes.id',
                '=',
                'produit_commandes.commande_id'
            )->get();
    }
}
