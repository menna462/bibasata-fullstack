@extends('welcome')
@section('content')
    <div class="shop">
        <div class="shop-contan">
            <h1>PAYMENT</h1>
            <p>
                Home <span><i class="fas fa-chevron-left"></i></span> payment
            </p>
        </div>
    </div>

    <div class="container">
        <div class="payment-container">
            <h3 class="section-title">Payment Method</h3>
            <div class="payment-card-logos">
                <img src="{{ asset('frontend/image/Mastercard.png') }}" alt="Mastercard Logo">
                <img src="{{ asset('frontend/image/Visa.png') }}" alt="Visa Logo">
            </div>

            <h3 class="section-title">Payment Details</h3>
            <form action="#" method="post">
                <div class="mb-3">
                    <input type="text" class="form-control input-bottom-border" placeholder="Enter Name on Card" required>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control input-bottom-border" placeholder="Card Number" required>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control input-bottom-border" placeholder="Expire Date" required>
                </div>
                <div class="row mb-5">
                    <div class="col-12 col-md-4">
                        <button type="button" class="btn btn-back w-50">Back</button>
                    </div>
                    <div class="col-12 col-md-8 btn-confirm">
                        <p>Confirm payment</p>
                        <p>RS 16000</p>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="green-line">
        <div class="container-fluid">
            <div class="row gx-0">
                <div class="col-lg-3 col-md-6 col-6 part">
                    <div class="img-inderline">
                        <img src="{{ asset('frontend/image/trophy.png') }}" alt="Trophy icon" />
                    </div>
                    <div>
                        <h5>High Quality</h5>
                        <p>Official subscriptions</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-6 part">
                    <div class="img-inderline">
                        <img src="{{ asset('frontend/image/Vector1.png') }}" alt="Warranty icon" />
                    </div>
                    <div>
                        <h5>Warranty Protection</h5>
                        <p>For the entire subscription period</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-6 part">
                    <div class="img-inderline">
                        <img src="{{ asset('frontend/image/Vector2.png') }}" alt="Exclusive Deals icon" />
                    </div>
                    <div>
                        <h5>Exclusive Deals</h5>
                        <p>Special discounts for you</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-6 part">
                    <div class="img-inderline">
                        <img src="{{ asset('frontend/image/Vector3.png') }}" alt="Support icon" />
                    </div>
                    <div>
                        <h5>24 / 7 Support</h5>
                        <p>Dedicated support</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
