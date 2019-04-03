@extends('layouts.app')

@section('content')

    <!-- Main content -->
    <div class="container">
        <!-- Default box -->
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="box-title">Product List</h3>
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
                        <div>
                            <a href="{{ url('wallets') }}">Wallets</a>
                            <br />
                            <h3>Total <span id="total_sum">{{ $total_sum }} $</span></h3>
                        </div>
                        <p><a href="{{ url('products') }}">Shop</a></p>
                    </div>
                    <div class="card-body">
                        <h2 id="status"></h2>
                        <table id="data_table_pr" class="table datatable dt-responsive" style="width:100%;">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $product)
                            <tr role="row" class="odd">
                                <td tabindex="0"><b>{{ $product->title }}</b></td>
                                <td>{{ $product->price }} $</td>
                                <td>
                                    <a href="#" class="add_to_card" data-price="{{ $product->price }}" data-pr="{{ $product->id }}">Add to card</a>
                                    <p class="res"></p>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $products->links() }}
                    </div><!-- /.box-body -->
                </div><!-- /.card -->
            </div><!-- /.col-md-8 -->
        </div><!-- /.row justify-content-center -->
    </div><!-- /.container -->

@endsection