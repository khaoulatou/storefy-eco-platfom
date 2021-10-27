<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
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

    //Get all coupons
    public function getAllCoupon()
    {
        return response([
            "success" => true,
            "message" => "Coupon List",
            "data" => Coupon::all()
        ]);
    }
    //dashboard Admin
    //Create a coupon
    public function createCoupon(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'nom' => 'required',
            'capacity' => 'required',
            'active' => 'required',
            'dateDebut' => 'required',
            'dateFin' => 'required',
            'type_prix' => 'required',
            'type_expiration' => 'required',
            'subdomain' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $coupon = Coupon::create($input);
        return response(["success" => true, 'message' => 'Coupon created successfully', 'data' => $coupon]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //Coupon update
    public function updateCoupon(Request $request, Coupon $coupon)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'nom' => 'required',
            'active' => 'required',
            'dateDebut' => 'required',
            'dateFin' => 'required',
            'nombre_utilisateur' => 'required',
            'type_prix' => 'required',
            'type_expiration' => 'required',
            'subdomain' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $coupon->nom = $input['nom'];
        $coupon->active = $input['active'];
        $coupon->dateDebut = $input['dateDebut'];
        $coupon->dateFin = $input['dateFin'];
        $coupon->nombre_utilisateur = $input['nombre_utilisateur'];
        $coupon->type_prix = $input['type_prix'];
        $coupon->type_expiration = $input['type_expiration'];
        $coupon->subdomain = $input['subdomain'];
        $coupon->save();
        return response([
            "success" => true,
            "message" => "Coupon details have been modified successfully.",
            "data" => $coupon
        ], 201);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteCoupon(Coupon $coupon)
    {
        $coupon->delete();
        return response([
            "success" => true,
            "message" => "Coupon deleted successfully.",
            "data" => $coupon
        ]);
    }
}
