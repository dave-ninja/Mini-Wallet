@extends('layouts.app')

@section('content')

    <!-- Main content -->
    <div class="container">
        <!-- Default box -->
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="box-title">Transfer List</h3>
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
                        @elseif(session('error'))
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
                            <a href="{{ url('transfers/create') }}">Create Transfer</a>
                            <br />
                            <h3>Total <span id="total_sum">{{ $total_sum }} $</span></h3>
                        </div>
                        <p><a href="{{ url('products') }}">Shop</a></p>
                    </div>
                    <div class="card-body">
                        @if(count($transfers)>0)
                        <table id="data_table" class="table datatable dt-responsive" style="width:100%;">
                            <thead>
                            <tr>
                                <th>Description</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Amount</th>
                                <th>Created</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($transfers as $key => $transfer)
                            <tr role="row" class="odd">
                                <td tabindex="0"><b>{{ $transfer->description }}</b></td>
                                <td>@if(isset($from[$key])) {{ $from[$key] }} @endif</td>
                                <td>@if(isset($to[$key]))   {{ $to[$key] }} @endif</td>
                                <td class="amount">@if(!is_null($transfer->amount)) {{ $transfer->amount }} $ @else Empty @endif</td>
                                <td>{{ $transfer->created_at }}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $transfers->links() }}
                        @else
                        <h3>Empty</h3>
                        @endif
                    </div><!-- /.box-body -->
                </div><!-- /.card -->
            </div><!-- /.col-md-8 -->
        </div><!-- /.row justify-content-center -->
    </div><!-- /.container -->

@endsection