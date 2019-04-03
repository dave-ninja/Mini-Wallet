<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Wallet;
use Auth;

class WalletController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
	{
		$wallets = Wallet::where('user_id',Auth::user()->id)->get();
		$total_sum = Wallet::where('user_id',Auth::user()->id)->sum('amount');
		return view('wallets.index')->with(compact('wallets','total_sum'));
	}
	
	public function create()
	{
		return view('wallets.create_edit');
	}
	
	public function store(Request $request)
	{
	    $wallet = new Wallet();
	    $wallet->title = $request->title;
	    $wallet->type = $request->type;
	    $wallet->user_id = Auth::user()->id;
        $wallet->save();
        return redirect('/wallets')->with('success', $wallet->title.' has been added Successfully!');
	}
    
    public function show(Wallet $wallet)
	{
		
	}
	
	public function edit(Wallet $wallet)
	{
		return view('wallets.create_edit', compact('wallet'));
	}
	
	public function update(Request $request, Wallet $wallet)
	{
		$wallet->title = $request->input('title');
		$wallet->type = $request->input('type');
		$wallet->save();
		return redirect('wallets')->with('success', $wallet->title . ' has been Updated Successfully');
	}
	
	public function destroy(Request $request, Wallet $wallet)
	{
	    
	}
	
	public function amount(Request $request, Wallet $wallet)
	{
	    $amount = rand(10, 150);
	    $getCurrentAmount = Wallet::select('amount')->where('id',$request->id)->first();
	    if( is_null($getCurrentAmount->amount) ) {
    	    $wallet->amount = $amount;
    	    $wallet->save();
	    } else {
	        $current = $getCurrentAmount->amount;
	        $wallet->amount += $amount;
	        $wallet->save();
	    }
	    $total_sum = Wallet::where('user_id',Auth::user()->id)->sum('amount');
	    return response()->json(['success'=>$wallet->amount.' $','total_sum'=>$total_sum.' $']);
	}
}
