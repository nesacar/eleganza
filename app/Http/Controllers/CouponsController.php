<?php

namespace App\Http\Controllers;

use App\Coupon;
use App\Http\Requests\CreateCouponRequest;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
    public function __construct(){
        $this->middleware('menager');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $slug = 'products';
        $coupons = Coupon::orderBy('publish_at', 'ASC')->paginate(50);
        return view('admin.coupons.index', compact('coupons','slug'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $slug = 'products';
        return view('admin.coupons.create', compact('slug'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateCouponRequest $request)
    {
        $coupon = Coupon::create(request()->all());
        $coupon->code = request('code')? request('code') : str_random(8);
        $coupon->publish = request('publish')? 1 : 0;
        $coupon->forever = request('forever')? 1 : 0;
        $coupon->update();
        return redirect('admin/coupons')->with('done', 'Kupon je kreiran.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $coupon = Coupon::find($id);
        $slug = 'products';
        return view('admin.coupons.edit', compact('slug', 'coupon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(CreateCouponRequest $request, $id)
    {
        $coupon = Coupon::find($id);
        $coupon->update(request()->all());
        $coupon->code = request('code')? request('code') : str_random(8);
        $coupon->publish = request('publish')? 1 : 0;
        $coupon->forever = request('forever')? 1 : 0;
        $coupon->update();
        return redirect('admin/coupons/'.$coupon->id.'/edit')->with('done', 'Kupon je izmenjen');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function delete($id)
    {
        Coupon::find($id)->delete();
        return redirect('admin/coupons')->with('done', 'Kupon je obrisan.');
    }

    public function publish($id){
        $val = request('val');
        if($val == 'true'){ $publish = 1; }else{ $publish = 0; }
        $coupon = Coupon::find($id)->update(array('publish' => $publish));
        if(isset($coupon)){ return 'da'; }else{ return 'ne'; }
    }
}
