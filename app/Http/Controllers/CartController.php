<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;
use App\Wallet;
use App\Report;
use Auth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
	{
		
	}
	
	public function add_to_cart(Request $request)
	{
	    $arr = [];
	    $get_wallets = Wallet::where('user_id',Auth::user()->id)->where('amount','>=',$request->pr_price)->get();
	    if(count($get_wallets) > 0) {
    	    foreach($get_wallets as $item) {
    	        array_push($arr, "<a href='#' class='pay' data-pr_id='".$request->id."' data-pay_id='".$item->id."'>".$item->title." ".$item->amount." $"."</a>");
            }
            return response()->json(['view' => $arr]);
	    } else {
	        return response()->json(['view' => 'Please add amount']);
	    }
	}
	
	public function store(Request $request)
	{
	    // pay_id
	    // pr_id
	    // for security get product price :))
	    $pr_info = Product::select('title','price')->where('id',$request->pr_id)->first();
	    $selected_wallet = Wallet::select('title','amount')->where('id',$request->pay_id)->first();
	    $minus = $selected_wallet->amount - $pr_info->price;
	    $res_wal = Wallet::where('user_id',Auth::user()->id)
	                    ->where('id',$request->pay_id)
	                    ->update(['amount' => $minus]);
	    $total_sum = Wallet::where('user_id',Auth::user()->id)->sum('amount');
	    if($res_wal) {
	        $transfer = new Report();
            $transfer->description = 'payed '.$pr_info->title;
            $transfer->user_id = Auth::user()->id;
            $transfer->wallet_id_from = $request->pay_id;
            $transfer->wallet_id_to = 0;
            $transfer->amount = $pr_info->price;
            $transfer->save();
	        return response()->json(['success' => $pr_info->title.' successfuly payed!','total_sum' => $total_sum.' $', 'sel_wal' => $minus.' $']);
	    }
	}
}
