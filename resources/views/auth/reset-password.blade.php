@extends('layout.login.base', ['title' => 'Reset Password'])

@section('content')
    <div class="text-center">
        <h1 class="fw-bold">RESET PASSWORD</h1>
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
        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ request()->token }}">
            <input type="hidden" name="email" value="{{ request()->email }}">
            <div class="mb-2">
                <div class="input-group flex-nowrap">
                    <span class="input-group-text bg-white" id="addon-wrapping"><i class="bi bi-key-fill"
                            style="color: #304A93;"></i> </span>
                    <input type="password" name="password" class="form-control-lg form-control" placeholder="Password Baru"
                        aria-label="Password" aria-describedby="addon-wrapping">
                </div>
            </div>
            <div class="mb-2">
                <div class="input-group flex-nowrap">
                    <span class="input-group-text bg-white" id="addon-wrapping"><i class="bi bi-key-fill"
                            style="color: #304A93;"></i> </span>
                    <input type="password" name="password_confirmation" class="form-control-lg form-control"
                        placeholder="Konfirmasi Password Baru" aria-label="Password" aria-describedby="addon-wrapping">
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Reset Password</button>
            </div>
        </form>
    </div>

@endsection
