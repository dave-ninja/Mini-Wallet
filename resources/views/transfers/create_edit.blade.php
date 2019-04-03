@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Transfers</h3>
                    <a href="{{ url('transfers') }}">Transfers</a>
                    <br />
                    <h3>Total <span id="total_sum">{{ $total_sum }} $</span></h3>
                    @foreach($wallets as $wallet)
                    <p>{{ $wallet->title }} - {{ $wallet->amount }} $<p>
                    @endforeach
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
                    @if( $countWallets > 1 )
                    <form action="{{ URL::to('transfers') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <textarea name="description" required></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="from">From</label>
                                    <select name="from" id="from" class="form-control" required>
                                        <option value="0">Choose Type</option>
                                        <option value="1">Credit Card</option>
                                        <option value="2">Cash</option>
                                    </select>
                                    <select name="from_type" id="from_type" class="form-control" required>
                                    </select>
                                </div>
                                <div class="col-md-6" id="toContent">
                                    <label for="to">To</label>
                                    <select name="to" id="to" class="form-control" required>
                                        <option value="0">Choose Type</option>
                                        <option value="1">Credit Card</option>
                                        <option value="2">Cash</option>
                                    </select>
                                    <select name="to_type" id="to_type" class="form-control" required>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="number" name="amount" id="amount" class="form-control dNone" required>    
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-8 ">
                                    <input class="btn btn-primary" type="submit" value="Add Transfer">
                                </div>
                            </div>
                        </div>
                    </form>
                    @else
                    <h3>Wallets  count <= 1</h3>
                    <br />
                    <a href="{{ url('/wallets/create') }}">Create Wallet</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
