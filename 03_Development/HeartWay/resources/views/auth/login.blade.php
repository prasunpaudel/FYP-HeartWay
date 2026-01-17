@section('Content')
    @extends('layouts.template')
    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div
                            class="col-6 d-lg-flex d-none h-100 my-auto ps-0 position-absolute top-0 start-0 text-center justify-content-center flex-column">
                            <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden"
                            style="background-image: url('https://wesavelives.org/wp-content/uploads/2019/08/school-bus-safety_wesavelives-1.jpg'); background-size: cover;">
                            <span class="mask bg-gradient-primary opacity-6"></span>
                            <h1 class="mb-5 text-white position-relative">Welcome</h1>
                            <h4 class="mt-5 text-white font-weight-bolder position-relative">
                                    "Peace of mind, delivered in real time"
                                </h4>
                                <p class="text-white position-relative">
                                    Track school buses live, receive timely notifications, and stay confident about your
                                    child’s daily commute with HeartWay.
                                </p>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto ms-lg-auto">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-start">
                                    <h4 class="font-weight-bolder">Login to you Account</h4>
                                    <p class="mb-0">Enter your email and password to sign in</p>
                                </div>
                                @if(session('error'))
                                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
                                        <div class="bg-red-100 border border-red-400 text-red-500 px-4 py-3 rounded" style="color:red;border:1px sold red;">
                                            {{ session('error') }}
                                        </div>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <form role="form" method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="mb-3">
                                            @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            <input type="email" name="email" class="form-control form-control-lg"
                                                placeholder="Email" aria-label="Email">
                                        </div>
                                        <div class="mb-3">
                                            @error('password')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            <input type="password" name="password" class="form-control form-control-lg"
                                                placeholder="Password" aria-label="Password">
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-lg btn-primary w-100 mt-4 mb-0">
                                                Sign in
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>
@endsection
