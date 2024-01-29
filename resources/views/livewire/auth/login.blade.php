<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
    <div class="auth-wrapper v2">
        <div class="auth-sidecontent">
            <img src="{{ asset('admin/images/authentication/img-auth-sideimg.jpg') }}" alt="images"
                class="img-fluid img-auth-side">
        </div>
        <div class="auth-form">
            <div class="card my-5">
                <div class="card-body">
                    <form wire:submit.prevent="loginAttemp()">
                        <div class="text-center">
                            <a href="javascript:;"><img src="admin/images/logo-dark.svg" alt="img"></a>
                        </div>
                        <div class="form-group mb-3 my-3">
                            <input wire:model="username" type="text" class="form-control @error('username') is-invalid @enderror" id="floatingInput" placeholder="Username">
                            @error('username')
                                @php
                                    $message = $message ?? '';
                                @endphp
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <input wire:model="password" type="password" class="form-control @error('password') is-invalid @enderror" id="floatingInput1" placeholder="Password">
                            @error('password')
                                @php
                                    $message = $message ?? '';
                                @endphp
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="d-flex mt-1 justify-content-between align-items-center">
                            <div class="form-check">
                                <input class="form-check-input input-primary" type="checkbox" checked="">
                                <label class="form-check-label text-muted" for="customCheckc1">Remember me?</label>
                            </div>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
