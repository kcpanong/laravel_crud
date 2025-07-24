<div>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                @if (session()->has('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="card">
                    <div class="card-header text-center">
                        {{ $isLogin ? 'Login' : 'Register' }}
                    </div>

                    <div class="card-body">
                        <form wire:submit.prevent="authenticate">
                            @if (!$isLogin)
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" wire:model.defer="name" class="form-control @error('name') is-invalid @enderror">
                                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            @endif

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" wire:model.defer="email" class="form-control @error('email') is-invalid @enderror">
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" wire:model.defer="password" class="form-control @error('password') is-invalid @enderror">
                                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            @if (!$isLogin)
                                <div class="mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" wire:model.defer="password_confirmation" class="form-control">
                                </div>
                            @endif

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    {{ $isLogin ? 'Login' : 'Register' }}
                                </button>
                            </div>
                        </form>

                        <div class="mt-3 text-center">
                            <button class="btn btn-link" wire:click="toggleForm">
                                {{ $isLogin ? "Don't have an account? Register" : "Already have an account? Login" }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>