@section('Content')
    @extends('layouts.template')
    <main class="main-content mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div
                            class="col-6 d-lg-flex d-none h-100 my-auto ps-0 position-absolute top-0 start-0 text-center justify-content-center flex-column">
                            <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden"
                            style="background-image: url('https://wesavelives.org/wp-content/uploads/2019/08/school-bus-safety_wesavelives-1.jpg'); background-size: cover;">
                                <span class="mask bg-gradient-primary opacity-6"></span>
                                <h1 class="mb-5 text-white position-relative">Verify your email</h1>
                                <p class="text-white position-relative">
                                    We've sent a 6-digit code to <strong>{{ $email }}</strong>. Enter it below.
                                </p>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto ms-lg-auto">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-start">
                                    <h4 class="font-weight-bolder">Enter verification code</h4>
                                    <p class="mb-0">Check your email and enter the 6-digit code</p>
                                </div>
                                @if(session('error'))
                                    <div class="mx-4 mt-3">
                                        <div class="alert alert-danger text-white" role="alert">
                                            {{ session('error') }}
                                        </div>
                                    </div>
                                @endif
                                @if(session('status'))
                                    <div class="mx-4 mt-3">
                                        <div class="alert alert-success text-white" role="alert">
                                            {{ session('status') }}
                                        </div>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <form role="form" method="POST" action="{{ route('otp.verify') }}">
                                        @csrf
                                        <input type="hidden" name="email" value="{{ $email }}">
                                        <div class="mb-3">
                                            @error('otp')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                            <input type="text" name="otp" class="form-control form-control-lg text-center"
                                                placeholder="000000" aria-label="Verification code" maxlength="6" pattern="[0-9]{6}"
                                                inputmode="numeric" autocomplete="one-time-code" autofocus
                                                value="{{ old('otp') }}">
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-lg btn-primary w-100 mt-4 mb-0">
                                                Verify and continue
                                            </button>
                                        </div>
                                    </form>
                                    <div class="text-center mt-3">
                                        <p class="text-sm text-muted mb-0">Didn't receive the code?</p>
                                        <form method="POST" action="{{ route('otp.resend') }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-link btn-sm p-0">
                                                Resend code
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
