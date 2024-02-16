<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card overflow-hidden">
                <div class="bg-primary bg-soft">
                    <div class="row">
                        <div class="col-7">
                            <div class="text-primary p-4">
                                <h5 class="text-primary">Welcome Back !</h5>
                                <p>Sign in to continue to Skote.</p>
                            </div>
                        </div>
                        <div class="col-5 align-self-end">
                            <img src="{{ asset('images/profile-img.png') }}" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="auth-logo">
                        <a href="index.html" class="auth-logo-light">
                            <div class="avatar-md profile-user-wid mb-4">
                                <span class="avatar-title rounded-circle bg-light">
                                    <img src="{{ asset('images/logo-light.svg') }}" alt=""
                                        class="rounded-circle" height="34">
                                </span>
                            </div>
                        </a>

                        <a href="index.html" class="auth-logo-dark">
                            <div class="avatar-md profile-user-wid mb-4">
                                <span class="avatar-title rounded-circle bg-light">
                                    <img src="{{ asset('images/logo.svg') }}" alt="" class="rounded-circle"
                                        height="34">
                                </span>
                            </div>
                        </a>
                    </div>
                    <div class="p-2">
                        <form class="form-horizontal" wire:submit.prevent="_login">

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror"
                                    id="email" wire:model="email" placeholder="Enter Email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <div class="input-group auth-pass-inputgroup">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Enter password" aria-label="Password"
                                        aria-describedby="password-addon" wire:model.lazy="password">
                                    <button class="btn btn-light " type="button" id="password-addon"><i
                                            class="mdi mdi-eye-outline"></i></button>

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember-check"
                                    wire:model.lazy="remember_me">
                                <label class="form-check-label" for="remember-check">
                                    Remember me
                                </label>
                            </div>

                            <div class="mt-3 d-grid">
                                <button class="btn btn-primary waves-effect waves-light" type="submit">
                                    Login
                                    <span wire:loading wire:target="_login">...</span>
                            </div>

                            <div class="mt-4 text-center">
                                <a href="auth-recoverpw.html" class="text-muted"><i class="mdi mdi-lock me-1"></i>
                                    Forgot your password?</a>
                            </div>


                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
