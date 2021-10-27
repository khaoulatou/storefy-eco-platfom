<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Coupon;
use App\Models\Produit;
use App\Models\ProduitCommande;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CheckOutController extends Controller
{
    private $coupon;

    // function for find coupon
    public function findCoupon($id, $nom)
    {
        // $operation = ['coupons.user_id'=> $id,'coupons.nom'=> $nom];
        $coupon = DB::table('coupons')
            ->join('users', 'users.id', '=', 'coupons.user_id')
            ->select('coupons.*')
            ->where('coupons.user_id', $id)->where('coupons.nom', $nom)
            ->first();
        return $coupon;
    }

    //function for Verify that the coupon is effective
    public function getCoupon($id)
    {
        //short writing ==> $operation = ['coupons.user_id'=> $id,'coupons.nom'=> $nom];
        $coupon = $this->findCoupon(1, $id);
        if (is_null($coupon)) {
            return response(['success' => false, 'message' => "This Coupon not found."]);
        } else if ($coupon->active == false) {
            return response(['success' => false, 'message' => "This coupon is not activated"]);
        } else if ($coupon->active == true) {
            if ($coupon->type_expiration === 'nombre_utilisateur') {
                if ($coupon->nombre_utilisateur === $coupon->capacity) {
                    return response(['success' => false, 'message' => "You cannot take advantage of this coupon because it has exceeded the maximum usage limit"]);
                } else {
                    return response(['success' => true, 'message' => "Successfully reduced", "data" => $coupon], 201);
                }
            } else {
                $date = new Carbon();
                if ($date > $coupon->dateFin) {
                    return response(['success' => false, 'message' => "This coupon . has expired"]);
                } else {
                    return response(['success' => true, 'message' => "Successfully reduced", "data" => $coupon], 201);
                }
            }
        }
    }

    // function for increment Number of use the coupon
    public function incrementNumber($coupon)
    {
        // if (is_null($coupon)) {
        //     return response(['success' => false, 'message' => "This Coupon not found."]);
        // } else
        return response(['coupon :' => $coupon]);
        if ($coupon->nombre_utilisateur < $coupon->capacity) {
            $cou = Coupon::find($coupon->id);
            $cou->nombre_utilisateur++;
            $cou->save();
            return response(['success' => true, "message" => "The number of uses for the coupon has been modified.", "data" => $cou]);
        } else {
            return response(['success' => false, "message" => "The number of uses has reached the maximum.",]);
        }
    }

    public function createCommande(Request $request)
    {
        $data = $request->all();
        $commandeData = $data['commande'];
        $products = $data['products'];
        $couponData = $data['coupon'];
        return $couponData;
        $validator = Validator::make($commandeData, [
            'destinataire' => 'required',
            'phone1' => 'required',
            // 'phone2' => 'required',
            'ville_customer' => 'required',
            'address' => 'required',
        ]);

        //validate data request
        if ($validator->fails()) {
            return response($validator->errors());
        }

        //create new commane
        $commande = new Commande();
        $commande->destinataire = $commandeData['destinataire'];
        $commande->phone1 = $commandeData['phone1'];
        $commande->phone2 = $commandeData['phone2'];
        $commande->ville_customer = $commandeData['ville_customer'];
        $commande->addresse = $commandeData['address'];
        $commande->status = 2;

        //inserer new commande in database
        $commande->save();
        $couponExist = trim($couponData) ? 1 : 0;

        if ($couponExist) {
            $this->incrementNumber(trim($couponData));
        }

        return $this->checkout($products, $commande->id);
        return response([
            "success" => true,
            "message" => "List of products to order.",
            "data" => $commande->id,
        ], 201);
    }

    //checkout
    public function checkout($products, $idCommande)
    {
        // $array = [];
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
            // array_push($array, [
            //     'produit_id' => $product['id'],
            //     'commande_id' => $idCommande,
            //     'upsell' => $product['upsell'],
            //     'quantite' => $product['quantity'],
            //     'totale' => $totale,
            //     'ProduitCommande' => $proco->commande_id,
            // ]);
        }
        return response([
            "success" => true,
            "message" => " command create successful .",
            "data" => $proco,
        ]);
    }
}
