@extends('layout.login.base', ['title' => 'Login'])

@section('content')
    <div class="text-center">
        <h1 class="fw-bold">LOGIN</h1>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="list-unstyled mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: '{{ session('success') }}',
                });
            </script>
        @elseif (session('error'))
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '{{ session('error') }}',
                });
            </script>
        @endif
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <div class="input-group flex-nowrap">
                    <span class="input-group-text bg-white" id="addon-wrapping"><i class="bi bi-envelope-at-fill"
                            style="color: #304A93;"></i> </span>
                    <input type="text" name="email" class="form-control-lg form-control" placeholder="Email Address"
                        aria-label="Email Address" aria-describedby="addon-wrapping">
                </div>
            </div>
            <div class="mb-2">
                <div class="input-group flex-nowrap">
                    <span class="input-group-text bg-white" id="addon-wrapping"><i class="bi bi-key-fill"
                            style="color: #304A93;"></i> </span>
                    <input type="password" name="password" class="form-control-lg form-control" placeholder="Password"
                        aria-label="Password" aria-describedby="addon-wrapping">
                </div>
            </div>
            <div class="d-flex justify-content-end align-items-end mb-3">
                <a href="{{ route('password.request') }}" class="mx-2" style="text-decoration: none">Reset Password</a>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>
@endsection
