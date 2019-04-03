@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Wallet</h3>
                    <a href="{{ url('wallets') }}">Wallets</a>
                </div>

                <div class="card-body">
                    
                    @if(session('success'))
                        <div class="noti-alert pad no-print">
                            <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                                <h4><i class="icon fa fa-check"></i> Success</h4>
                                <ul>
                                    <li>{{ session('success') }}</li>
                                </ul>
                            </div>
                        </div>
                    @endif
                    
                    <form action="{{ isset($wallet) ? URL::to('wallets/'.$wallet->id.'/update' ) :  URL::to('wallets') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                
                                    <input type="text" name="title" id="title" placeholder="Take Wallet Name" class="form-control" value="{{ isset($wallet) ? $wallet->title: null }}">
                                </div>
                                <div class="col-md-6">
                                    <select name="type" id="type" class="form-control">
                                        <option>Choose Type</option>
                                        <option value="1" @if( isset($wallet) && $wallet->type == 1 ) selected @endif >Credit Card</option>
                                        <option value="2" @if( isset($wallet) && $wallet->type == 2 ) selected @endif >Cash</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-8 ">
                                    <input class="btn btn-primary" type="submit" value="{{ (isset($wallet) ? 'Update': 'Add') }} Wallet">
                                </div>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
