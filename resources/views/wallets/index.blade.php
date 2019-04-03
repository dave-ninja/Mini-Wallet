@extends('layouts.app')

@section('content')

    <!-- Main content -->
    <div class="container">
        <!-- Default box -->
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="box-title">Wallet List</h3>
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
                        @if(session('error'))
                        <div class="noti-alert pad no-print">
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                                <h4><i class="icon fa fa-check"></i> Error</h4>
                                <ul>
                                    <li>{{ session('error') }}</li>
                                </ul>
                            </div>
                        </div>
                        @endif
                        <div>
                            <a href="{{ url('wallets/create') }}">Create Wallet</a>
                            <br />
                            <h3>Total <span id="total_sum">{{ $total_sum }} $</span></h3>
                        </div>
                        <p><a href="{{ url('products') }}">Shop</a></p>
                    </div>
                    <div class="card-body">
                        <table id="data_table" class="table datatable dt-responsive" style="width:100%;">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($wallets as $wallet)
                            <tr role="row" class="odd">
                                <td tabindex="0"><b>{{ $wallet->title }}</b></td>
                                <td>@if($wallet->type == 1) Credit Card @else Cash @endif</td>
                                <td class="amount">@if(!is_null($wallet->amount)) {{ $wallet->amount }} $ @else 0 $ @endif</td>
                                <td style="">
                                    @if(is_null($wallet->amount) || $wallet->amount == 0)
                                    <a href="#" class="add" data-wallet="{{ $wallet->id }}">Add money</a>
                                    @endif
                                    <a style="margin-right: 0.1em;" href="{{ url('wallets/'.$wallet->id.'/edit') }}" title="Edit">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.card -->
            </div><!-- /.col-md-8 -->
        </div><!-- /.row justify-content-center -->
    </div><!-- /.container -->

@endsection