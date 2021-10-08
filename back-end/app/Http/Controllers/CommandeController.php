<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
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
    public function store(Request $request, $id)
    {
        dd($request);
        $couponController = new CouponController();
        $coupon = $couponController->incrementNumber($id, $request->CouponName);

        return response($coupon, 201);
        // return Commande::create($request->all());
    }

    public function createCommande(Request $request, $id)
    {
        // dd($request);
        $input = $request->all();
        $validator = Validator::make($input, [
            'destinataire' => 'required',
            'phone1' => 'required',
            'phone2' => 'required',
            'ville_customer' => 'required',
            'addresse' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $commande = new Commande();
        $commande->destinataire = $request->destinataire;
        $commande->phone1 = $request->phone1;
        $commande->phone2 = $request->phone2;
        $commande->ville_customer = $request->ville_customer;
        $commande->addresse = $request->addresse;
        $commande->save();

        if ($request->couponName != null) {
            $couponController = new CouponController();
            $couponController->incrementNumber($id, $request->CouponName);
        }
        
        return response([
            "success" => true,
            "message" => "List of products to order.",
            "data" => $commande->id,
        ], 201);
        // return response($coupon, 201);
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
