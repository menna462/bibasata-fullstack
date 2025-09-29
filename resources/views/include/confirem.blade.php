@extends('welcome')

@section('content')

    <div class="confirem">
      <h1>Subscription Confirmed</h1>
      <img src="{{ asset('frontend/image/check1.png') }}"  alt="" />
      <p>
        Thank you for your purchase. Your subscription has been successfully <br>
        activated. Check your email for the activation details or visit the My <br>
        Subscriptions page to manage and track your plan.
      </p>
      <button>Back to Home Page</button>
    </div>
@endsection
