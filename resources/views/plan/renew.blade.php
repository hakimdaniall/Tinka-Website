@extends('layouts.master')

@section('title')
Package Renewal
@endsection

@section('content')

@include('header')
  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">
        <ol>
          <li><a href="index">Home</a></li>
          <li>Tuition Fees</li>
        </ol>
        <h2>Renewal</h2>
      </div>
    </section><!-- End Breadcrumbs -->

    <section id="about" class="about">

      <div class="container aos-init aos-animate" data-aos="fade-up">
        <div class="row gx-0">

          <div class="col-lg-6 d-flex flex-column justify-content-center aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
            @php
              $previous = url()->previous();
            @endphp
            <div class="content">
              <h3>Plan Details</h3>
              <h2>{{ $plan['name'] }}</h2>
              <p>{{ $plan['description'] }}</p>
              <h3>Subscription details</h3>
              <ul>
                <li>Price: RM {{ $plan['price'] }}/subject</li>
                @if(!str_contains($previous, 'subscription'))
                <li>Annual Registration: RM {{ $plan['signup_fee'] }}</li>
                <li>Exam and Notes: RM {{ $plan['exam_fee'] }}</li>
                @endif
                <li>Renewal: Every {{ $plan['invoice_period'].' '.$plan['invoice_interval'] }}</li>
              </ul>
              
              <div class="row">
                <div class="col-md-12 order-md-1">
                  <h4 class="mb-3">Checkout</h4>
                  @guest
                    <p>If you already have an account with us, you can proceed by login. Else, you can register your new account here.</p>
                    <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
                  @endguest
                  @if ($errors->any())
                    <div class="alert alert-danger">
                      <ul>
                        @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                        @endforeach
                      </ul>
                    </div>
                  @endif
                  @auth
                  <form method="put" action="{{ url('payment/create') }}" name="checkout">
                    <h3>Subject Selection</h3>
                      <?php $subject = explode(',', $plan['subjects']); ?>
                      @foreach($subject as $key => $value)
                      <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" id="subject-{{ $key }}" name="subjects[]" onclick="checkBoxLimit()" value="{{ $value }}">
                        <label class="form-check-label" for="subject-{{ $key }}" name="agree">{{ $value }}</label>
                      </div>
                      @endforeach
                      @csrf
                      
                      <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                      <p class="text-mute">Name: {{ auth()->user()->name }}<br>
                        E-mail: {{ auth()->user()->email }}</p>
                      <div class="mb-3">
                        <label for="studentName">Student Name <span class="text-muted">(required)</span></label>
                        <input type="text" class="form-control" name="student_name" {{ $errors->has('student_name') ? 'has-error' : '' }} value="{{ old('student_name') }}">
                        <span class="text-danger">{{ $errors->first('student_name') }}</span>
                      </div>

                    @if(!str_contains($previous, 'subscription'))
                    @php
                    $extra = $plan['signup_fee'] + $plan['exam_fee'];
                    @endphp
                    <input type="hidden" name="subscription_option" value="initial">
                    @else
                    @php
                    $extra = 0;
                    @endphp
                    <input type="hidden" name="subscription_option" value="upgrade">
                    @endif
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="agree">
                      <label class="custom-control-label" for="agree" name="agree">I agree to the <a href="{{ url('terms-and-conditions') }}" target="_blank" required>{{ env('APP_NAME') }}'s terms and conditions</a></label>
                    </div>
                    <span class="text-danger">{{ $errors->first('agree') }}</span>
                    <input type="hidden" name="plan_id" value="{{ $plan['id'] }}">
                    <input type="hidden" name="extra_amount" value="{{ $extra }}">
                    <input type="hidden" name="price" value="{{ $plan['price'] }}">

                    <hr class="mb-4">
                    <div class="text-center text-lg-start">
                      <button class="btn btn-primary">
                        <span>Subscribe</span>
                        <i class="bi bi-arrow-right"></i>
                      </button>
                    </div>
                    <div class="alert alert-info mt-2">
                      <h5>Disclaimer</h5>
                      <ul>
                        <li>4 lesson per month for every subject</li>
                        <li>We reserve the rights to refuse entry into class for late payments</li>
                        <li>Fees must be paid before the second class of the month</li>
                      </ul>
                    </div>
                    <p><img height="24px" src="https://cdn02.billplz.com/assets/v1/Billplz_Blue-3153732736cf969cb5d2e23e3e8fa4b3e2292b87d4b19b581b27ee93940b0bc2.svg"> is the payment gateway provider. By subscribing to this service, you are subject to bind with their <a href="https://www.billplz.com/privacy" target="_blank">terms and conditions</a></p>
                  </form>
                  @endauth
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 d-flex align-items-center aos-init aos-animate" data-aos="zoom-out" data-aos-delay="200">
            <img src="{{ asset('assets/img/portfolio/'.$plan['id'].'.png') }}" class="img-fluid" alt="">
          </div>

        </div>
      </div>

    </section>

  </main><!-- End #main -->

  @include('footer')
@endsection

@push('js')
<script type="text/javascript">
  function checkBoxLimit() {
  var checkBoxGroup = document.forms['checkout']['subjects[]'];     
  var max_sub = {{ $plan['maximum_subject'] }};
  var min_sub = {{ $plan['minimum_subject'] }};
  for (var i = 0; i < checkBoxGroup.length; i++) {
    checkBoxGroup[i].onclick = function() {
      var checkedcount = 0;
      for (var i = 0; i < checkBoxGroup.length; i++) {
        checkedcount += (checkBoxGroup[i].checked) ? 1 : 0;
      }
      if (checkedcount < min_sub) {
        alert("You must select minimum of " + min_sub + " subject.");
      }
      if (checkedcount > max_sub) {
        alert("You can select maximum of " + max_sub + " subject.");
        this.checked = false;
      }
    }
  }
}
</script>
@endpush