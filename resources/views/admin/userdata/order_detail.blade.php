<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .spinner-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .spinner-border {
            width: 10rem;
            height: 10rem;
        }
    </style>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Shop :: Administrative Panel</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="css/adminlte.min.css">
    <link rel="stylesheet" href="css/custom.css">
</head>
@extends('admin.layouts.app')


@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <body class="hold-transition sidebar-mini">
        <!-- Site wrapper -->
        <div class="wrapper">
            <!-- Navbar -->

            <!-- /.navbar -->
            {{-- @dd($order); --}}
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid my-2">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Order: #{{ $order_item->order_id }}</h1>
                            </div>
                            <div class="col-sm-6 text-right">
                                <a href="{{ route('admin.orders') }}" class="btn btn-primary">Back</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.container-fluid -->
                </section>
                {{-- @dd($order_item) --}}
                <!-- Main content -->
                <section class="content">
                    <!-- Default box -->
                    <div class="overlay">
                        <div class="spinner-container">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden" style="color: hsl(134, 100%, 50%)"><h1>Processing...</h1></span>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-header pt-3">
                                        <div class="row invoice-info">
                                            <div class="col-sm-4 invoice-col">
                                                <h1 class="h5 mb-3">Shipping Address</h1>
                                                <address>
                                                    <strong>{{ $order_item->order->user->name }}</strong><br>
                                                    {{ $order_item->order->address }},{{ $order_item->order->apartment }},{{ $order_item->order->pincode }}<br>
                                                    {{ $order_item->order->state }},{{ $order_item->order->city }}<br>
                                                    <b>Phone:</b> {{ $order_item->order->mobile }}<br>
                                                    <b>Email:</b> {{ $order_item->order->email }}
                                                </address>
                                            </div>



                                            <div class="col-sm-4 invoice-col">

                                                <b>Order ID:</b> {{ $order_item->order_id }}<br>
                                                <b>Total:</b><i class="fa fa-inr" aria-hidden="true"></i>
                                                {{ $order_item->order->grand_total }}<br>
                                                <b>Status: @if ($order_item->order->status == 'pending')
                                                        <button type="button" class="btn btn-info"><span class="fa fa-bars"
                                                                aria-hidden="true"></span> Pending</button>
                                                    @elseif($order_item->order->status == 'shipped')
                                                        <button type="button" class="btn btn-primary"><span
                                                                class="fa fa-cog fa-spin" aria-hidden="true"></span>
                                                            Shipped!</button>
                                                    @elseif($order_item->order->status == 'out for delivery')
                                                        <button type="button" class="btn btn-warning"><span
                                                                class="fa fa-cog fa-spin" aria-hidden="true"></span> Out For
                                                            Delivery!</button>
                                                    @elseif($order_item->order->status == 'delivered')
                                                        <button type="button" class="btn btn-success"><span
                                                                class="fa fa-check-circle" aria-hidden="true"></span>
                                                            Delivered</button>
                                                    @elseif($order_item->order->status == 'cancelled')
                                                        <button type="button" class="btn btn-danger"> <i
                                                                class="fa fa-close"></i> Cancelled</button>
                                                    @elseif($order_item->order->status == 'refunded')
                                                        <button type="button" class="btn btn-secondary"> <i
                                                                class="fa fa-coins"></i>
                                                            Refunded</button>
                                                    @endif
                                                    <br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body table-responsive p-3">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th width="100">Price</th>
                                                    <th width="100">Qty</th>
                                                    <th width="100">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- @dd($order_item_det) --}}
                                                @foreach ($order_item_det as $order_items)
                                                    <tr>
                                                        <td> {{ $order_items->name }}</td>
                                                        <td> <i class="fa fa-inr" aria-hidden="true"> </i>
                                                            {{ $order_items->price }}</td>
                                                        <td> {{ $order_items->qty }}</td>
                                                        <td> {{ $order_items->price * $order_items->qty }}</td>
                                                @endforeach

                                                <tr>
                                                    <th colspan="3" class="text-right">Subtotal:</th>
                                                    <td><i class="fa fa-inr" aria-hidden="true"></i>
                                                        {{ $order_items->order->subtotal }}</td>
                                                </tr>
                                                <tr>
                                                    <th colspan="3" class="text-right">Discount:</th>
                                                    <td><i class="fa fa-inr" aria-hidden="true"></i>
                                                        {{ $order_items->order->discount ?? '0.00' }}</td>
                                                </tr>
                                                <tr>
                                                    <th colspan="3" class="text-right">Coupon Code: </th>
                                                    <td><i class="fa"
                                                            aria-hidden="true"></i>{{ $order_items->order->coupon_code ?? 'null' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th colspan="3" class="text-right">Shipping:</th>
                                                    <td>Free</td>
                                                </tr>
                                                <tr>
                                                    <th colspan="3" class="text-right">Grand Total:</th>
                                                    <td><i class="fa fa-inr" aria-hidden="true"></i>
                                                        {{ $order_items->order->grand_total }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-body">
                                        @if ($order_item->order->status == 'delivered')
                                            <button type="button" class="btn btn-success"><span class="fa fa-check-circle"
                                                    aria-hidden="true"></span>
                                                Delivered</button>
                                        @elseif($order_item->order->status == 'cancelled')
                                            <button type="button" class="btn btn-danger"><span class="fa fa-close"
                                                    aria-hidden="true"></span>
                                                Cancelled</button>
                                        @elseif($order_item->order->status == 'refunded')
                                            <button type="button" class="btn btn-secondary"> <span class="fa fa-coins"
                                                    aria-hidden="true"></span>
                                                Refunded</button>
                                        @else
                                            <h2 class="h4 mb-3">Order Status</h2>
                                            <form method="POST"
                                                action="{{ route('admin.updateorderdetail', $order_item->order_id) }}">
                                                @csrf
                                                @method('put')
                                                <div class="mb-3">
                                                    <select name="status" id="status" class="form-control">
                                                        <option value="pending">Pending</option>
                                                        <option value="shipped">Shipped</option>
                                                        <option value="out for delivery">Out For Delivery</option>
                                                        <option value="delivered">Delivered</option>
                                                        <option value="cancelled">Cancelled</option>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <button type="submit" id="submit" name="submit"
                                                        class="btn btn-primary">Update</button>
                                                </div>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                                <div class="card">
                                    <form action="{{ route('admin.sendInvoiceEmail', $order_item->order->id) }}"
                                        method="POST" id="sendInvoiceEmail" name="sendInvoiceEmail">
                                        @csrf
                                        <div class="card-body">
                                            <h2 class="h4 mb-3">Send Inovice Email</h2>
                                            <div class="mb-3">
                                                <select name="user" id="user" class="form-control">
                                                    <option value="">Customer</option>
                                                    {{-- <option value="">Admin</option> --}}
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <button type="submit" id="submit" name="submit"
                                                    class="btn btn-primary">Send</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <footer class="main-footer">

            </footer>
        </div>
        <!-- ./wrapper -->
        <!-- jQuery -->
        <script src="plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="js/adminlte.min.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="js/demo.js"></script>
    </body>
   <script>
        document.getElementById("sendInvoiceEmail").addEventListener("submit", function() {
            document.querySelector(".overlay").style.display = "flex";
        });
   </script>
@endsection

</html>
