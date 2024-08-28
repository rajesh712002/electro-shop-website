@include('user.includes.header')
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('userindex') }}">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('usershop') }}">Shop</a></li>
                    <li class="breadcrumb-item">Checkout</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-9 pt-4">
        <div class="container">
            <form id="CheckoutForm" method="post" action="{{route('user.storecheckout')}}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="sub-title">
                            <h2>Shipping Address</h2>
                        </div>
                        <div class="card shadow-lg border-0">
                            <div class="card-body checkout-form">
                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="first_name" id="first_name" class="form-control"
                                                placeholder="First Name"  value="{{(!empty($CustomerAddress)) ? $CustomerAddress->first_name : ''}}">
                                                <p></p>
                                        <h6 style="color: rgb(255, 0,0)" class="error"></h6>

                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="last_name" id="last_name" class="form-control"
                                                placeholder="Last Name"  value="{{(!empty($CustomerAddress)) ? $CustomerAddress->last_name : ''}}">
                                                <p></p>
                                        <h6 style="color: rgb(255, 0,0)" class="error"></h6>

                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="email" id="email" class="form-control"
                                                placeholder="Email"  value="{{(!empty($CustomerAddress)) ? $CustomerAddress->email : ''}}">
                                                <p></p>
                                        <h6 style="color: rgb(255, 0,0)" class="error"></h6>

                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <select name="country" id="country" class="form-control"  value="{{(!empty($CustomerAddress)) ? $CustomerAddress->country : ''}}">
                                                <option value="">Select a Country</option>
                                                <option value="india">India</option>
                                                {{-- <option value="2">UK</option> --}}
                                            </select>
                                            <p></p>
                                        <h6 style="color: rgb(255, 0,0)" class="error"></h6>

                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <textarea name="address" id="address" cols="30" rows="3" placeholder="Address" class="form-control"  value="">{{(!empty($CustomerAddress)) ? $CustomerAddress->address : ''}}</textarea>
                                       <p></p>
                                            <h6 style="color: rgb(255, 0,0)" class="error"></h6>

                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="appartment" id="appartment" class="form-control"
                                                placeholder="Apartment, suite, unit, etc. (optional)"  value="{{(!empty($CustomerAddress)) ? $CustomerAddress->apartment : ''}}">
                                                <p></p>
                                            <h6 style="color: rgb(255, 0,0)" class="error"></h6>

                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="text" name="city" id="city" class="form-control"
                                                placeholder="City"  value="{{(!empty($CustomerAddress)) ? $CustomerAddress->city : ''}}">
                                                <p></p>
                                        <h6 style="color: rgb(255, 0,0)" class="error"></h6>

                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="text" name="state" id="state" class="form-control"
                                                placeholder="State"  value="{{(!empty($CustomerAddress)) ? $CustomerAddress->state : ''}}"><p></p>
                                        <h6 style="color: rgb(255, 0,0)" class="error"></h6>

                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="text" name="zip" id="zip" class="form-control"
                                                placeholder="Zip"  value="{{(!empty($CustomerAddress)) ? $CustomerAddress->pincode : ''}}">
                                                <p></p>
                                        <h6 style="color: rgb(255, 0,0)" class="error"></h6>

                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="mobile" id="mobile" class="form-control"
                                                placeholder="Mobile No."  value="{{(!empty($CustomerAddress)) ? $CustomerAddress->mobile : ''}}">
                                                <p></p>
                                        <h6 style="color: rgb(255, 0,0)" class="error"></h6>

                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <textarea name="order_notes" id="order_notes" cols="30" rows="2" placeholder="Order Notes (optional)"
                                                class="form-control"  value="">{{(!empty($CustomerAddress)) ? $CustomerAddress->order_notes : ''}}</textarea>
                                                
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="sub-title">
                            <h2>Order Summery</h3>
                        </div>
                        <div class="card cart-summery">
                            <div class="card-body">
                              
                                @foreach ( $product as $products )
                                    
                                <div class="d-flex justify-content-between pb-2">
                                    <div class="h6">{{$products->prod_name}} X <b><u><i>{{$products->cqty}}</i></u></b></div>
                                    <div class="h6"><i class="fa fa-inr" aria-hidden="true">{{ $products->price * $products->cqty }}
                                    </i></div>
                                </div>
                                @endforeach
                                <div class="d-flex justify-content-between summery-end">
                                    <div class="h6"><strong>Subtotal</strong></div>
                                    <div class="h6"><strong><i class="fa fa-inr" aria-hidden="true">{{$totalSum}}</i></strong></div>
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <div class="h6"><strong>Shipping</strong></div>
                                    <div class="h6"><strong>Free</strong></div>
                                </div>
                                <div class="d-flex justify-content-between mt-2 summery-end">
                                    <div class="h5"><strong>Total</strong></div>
                                    <div class="h5"><strong><i class="fa fa-inr" aria-hidden="true">{{$totalSum}} </i></strong></div>
                                </div>
                            </div>
                        </div>

                        <div class="card payment-form ">
                            <h3 class="card-title h5 mb-3">Payment Details</h3>
                             <div class="">
                                <input checked type="radio" name="payment_method" value="cod" id="payment_method_one">
                                <label for="payment_method_one" class="form-check-label">COD</label>
                             </div>

                             <div class="">
                                <input type="radio" name="payment_method" value="card" id="payment_method_two">
                                <label for="payment_method_two" class="form-check-label">Card</label>
                             </div>
                            <div class="card-body p-0 d-none" id="CardPaymentForm">
                                <div class="mb-3">
                                    <label for="card_number" class="mb-2">Card Number</label>
                                    <input type="text" name="card_number" id="card_number"
                                        placeholder="Valid Card Number" class="form-control" value="{{old('card_number')}}">
                                        <p></p>
                                        <h6 style="color: rgb(255, 0,0)" class="error"></h6>

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="expiry_date" class="mb-2">Expiry Date</label>
                                        <input type="text" name="expiry_date" id="expiry_date"
                                            placeholder="MM/YYYY" class="form-control" value="{{old('expiry_date')}}">
                                            <p></p>
                                        <h6 style="color: rgb(255, 0,0)" class="error"></h6>

                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="cvv" class="mb-2">CVV Code</label>
                                        <input type="text" name="cvv" id="cvv" placeholder="123"
                                            class="form-control" value="{{old('cvv')}}">
                                            <p></p>
                                        <h6 style="color: rgb(255, 0,0)" class="error"></h6>

                                    </div>
                                </div>
                               
                            </div>
                            <div class="pt-4">
                                <button type="submit" class="btn-dark btn btn-block w-100">Pay Now</button>
                            </div>
                        </div>



                    </div>
                </div>
            </form>
        </div>
    </section>
</main>
<script src="{{ asset('user_assets/js/ajx.js') }}"></script>


@include('user.includes.footer')
