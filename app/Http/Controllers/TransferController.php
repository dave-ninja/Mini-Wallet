<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Wallet;
use App\Report;
use Auth;

class TransferController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        /*$transfers = Report::select('reports.*','wallet.title as from_title','wallet.title as to_title')
                            ->leftJoin('wallet',function($join){
                                $join->on('wallet.id','=','reports.wallet_id_from');
                                $join->orOn('wallet.id','=','reports.wallet_id_to');
                            })
                            ->where('reports.user_id',Auth::user()->id)->orderby('reports.id','desc')->paginate(5);*/
        $transfers = Report::where('user_id',Auth::user()->id)->orderby('id','desc')->paginate(5);
        $from = [];
        $to = [];
        
        foreach($transfers as $item) {
            
            if( !is_null($item->wallet_id_to) && !is_null($item->wallet_id_from) ) {
                $wallet_from = Wallet::select('title')->where('user_id',Auth::user()->id)->where('id',$item->wallet_id_from)->first();
                if( $item->wallet_id_to == 0 ) {
                    $wallet_to = new Wallet();
                    $wallet_to->title = 'product';
                } else {
                    $wallet_to = Wallet::select('title')->where('user_id',Auth::user()->id)->where('id',$item->wallet_id_to)->first();
                }
                if(!is_null($wallet_from)) array_push($from, $wallet_from->title);
                if(!is_null($wallet_to)) array_push($to, $wallet_to->title);
            }
        }
        $total_sum = Wallet::where('user_id',Auth::user()->id)->sum('amount');
        return view('transfers.index')->with(compact('transfers','total_sum','from','to'));
    }
    
    public function create()
    {
        $countWallets = Wallet::where('user_id',Auth::user()->id)->count();
        $wallets = Wallet::select('title','amount')->where('user_id',Auth::user()->id)->get();
        $total_sum = Wallet::where('user_id',Auth::user()->id)->sum('amount');
        return view('transfers.create_edit')->with(compact('countWallets','total_sum','wallets'));
    }
    
    public function store(Request $request)
    {
        $countWallets = Wallet::where('user_id',Auth::user()->id)->count();
        if( $countWallets > 1 ) {
            $get_from_current_amount = Wallet::select('amount')->where('user_id', Auth::user()->id)->where('id', $request->from_type)->first();
            $get_to_current_amount = Wallet::select('amount')->where('user_id', Auth::user()->id)->where('id', $request->to_type)->first();
            if( !is_null($get_from_current_amount) && !is_null($get_to_current_amount) ) {
                if( $get_from_current_amount->amount >= $request->amount ) {
                    $transfer = new Report();
                    $transfer->description = $request->description;
                    $transfer->user_id = Auth::user()->id;
                    $transfer->wallet_id_from = $request->from_type;
                    $transfer->wallet_id_to = $request->to_type;
                    $transfer->amount = $request->amount;
                    $transfer->save();
                    
                    $minus = $get_from_current_amount->amount - $request->amount;
                    $plus = $get_to_current_amount->amount + $request->amount;
                    $upt_wallet_minus = Wallet::where('user_id', Auth::user()->id)
                                    ->where('id', $request->from_type)
                                    ->update(['amount' => $minus]);
                    $upt_wallet_plus = Wallet::where('user_id', Auth::user()->id)
                                        ->where('id', $request->to_type)
                                        ->update(['amount' => $plus]);
                    
                    if($upt_wallet_minus && $upt_wallet_plus) {
                        return redirect('/transfers')->with('success', $transfer->description.' has been added Successfully!');
                    }
                } else {
                    return redirect('/transfers')->with('error', 'not equal amounts :)');
                }
            } else {
                return redirect('/transfers')->with('error', 'Error');
            }
        } else {
            return redirect('/');
        }
    }
    
    public function getExistsTypes(Request $request)
    {
        $res = Wallet::where('user_id',Auth::user()->id)->where('type',$request->id)->get();
        if(!is_null($res)) {
            $arr = [];
            foreach($res as $item) {
                array_push($arr, '<option value="'.$item->id.'">'.$item->title.'</option>');
            }
            return response()->json(['success' => $arr]);
        }
        
    }
}