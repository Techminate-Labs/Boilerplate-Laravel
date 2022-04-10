<?php
namespace App\Utilities;

class PaymentUtilities{
    public function subTotal($cartItems)
    {
        $subTotal = 0;
        foreach($cartItems as $cartItem){
            $subTotal = $subTotal + $cartItem['total'];
        }
        return $subTotal;
    }

    public function percToAmount($percentage, $subTotal)
    {
        return ($percentage/100) * $subTotal;
    }

    public function calPayment($cartItems,  $discountRate, $taxRate)
    {
        $subTotal = $this->subTotal($cartItems);
        $discount = $this->percToAmount($discountRate, $subTotal);
        $total = $subTotal - $discount;
        $tax = $this->percToAmount($taxRate, $subTotal);
        $total = $total + $tax;
        
        return [
            'subTotal' => $subTotal,
            'discount' => $discount,
            'tax' => $tax,
            'total' => $total,
        ];
    }

    public function applyCoupon($coupon)
    {
        $today = Carbon::today();
        $startDate = $coupon->start_date; // start: 14 oct, 
        $endDate = $coupon->end_date;     //end: 20 oct

        //valid dates: 14, 15, 16, 17, 18, 19, 20;    
        //active coupon based on start and end date
        //Active : 14 <= today; 20 >= today
        if($startDate <= $today && $endDate >= $today){
            $coupon->active = 1;
            $coupon->save();
        }
        //if date is expired, inactive coupon
        //Invalid: 20 < today ; 20<17=false, 20<21=true
        if($endDate < $today){
            $coupon->active = 0;
            $coupon->save();
        }

        if($coupon->active){
            $discountRate = $coupon->discount;
        }else{
            $discountRate = 0;
        }
        return $discountRate;
    }
}