@extends('layouts.app')

@section('content')

<style>
    /* Forzamos fondo oscuro en todo el contenedor para evitar destellos blancos */
    body, #app, main {
        background-color: #0b0b0b !important;
    }

    /* Banner superior */
    .login-banner {
        width: 100%; 
        height: 420px;
        background-image: url('{{ asset('img/1.png') }}');
        background-size: cover; 
        background-position: center;
        border-bottom: 2px solid #1a1a1a;
    }

    /* Contenedor principal con altura mínima para empujar el footer al fondo */
    .login-wrapper {
        background-color: #0b0b0b;
        min-height: calc(100vh - 420px - 100px); /* Ajusta según el alto del banner y footer */
        display: flex;
        align-items: center;
        padding: 50px 0;
    }

    /* Estética de las tarjetas */
    .card { 
        border: none !important; 
        transition: all 0.3s ease; 
        background-color: #ffffff;
    }
    
    .card:hover { 
        transform: translateY(-5px); 
        shadow: 0 10px 20px rgba(0,0,0,0.5);
    }

    input::-ms-reveal, input::-ms-clear { display: none; }
</style>

<div style="background-color: #0b0b0b;">
    <section class="login-banner"></section>

    <section class="login-wrapper">
        <div class="container">
            <div class="row justify-content-center g-4">

                <div class="col-md-6 col-lg-5 d-flex">
                    <div class="card shadow w-100 border-0 rounded-4">
                        <div class="card-body p-4 d-flex flex-column">
                            <h4 class="text-center mb-4 fw-bold">
                                <i class="bi bi-person-circle text-primary me-2"></i> Iniciar Sesión
                            </h4>

                            @if(session('success'))
                            <div class="alert alert-success border-0 shadow-sm">
                                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                            </div>
                            @endif

                            @if(session('login_error'))
                            <div class="alert alert-danger border-0 shadow-sm">
                                {{ session('login_error') }}
                            </div>
                            @endif

                            <form method="POST" action="{{ route('login.submit') }}" class="d-flex flex-column flex-grow-1">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Correo electrónico</label>
                                    <input type="email" name="email" class="form-control"
                                        placeholder="ejm: usuario@correo.com" value="{{ old('email') }}" required>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Contraseña</label>
                                    <div class="input-group">
                                        <input type="password" name="password" id="loginPassword" class="form-control"
                                            placeholder="••••••••" required>
                                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('loginPassword', this)">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <button class="btn btn-primary w-100 py-2 fw-semibold">
                                    Ingresar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-5 d-flex">
                    <div class="card shadow w-100 border-0 rounded-4">
                        <div class="card-body p-4 d-flex flex-column">
                            <h4 class="text-center mb-4 fw-bold">
                                <i class="bi bi-person-plus-fill text-success me-2"></i> Crear Cuenta
                            </h4>

                            @if($errors->any())
                            <div class="alert alert-danger border-0 shadow-sm">
                                @foreach($errors->all() as $error)
                                    {{ $error }} @break
                                @endforeach
                            </div>
                            @endif

                            <form method="POST" action="{{ route('registro.submit') }}" class="d-flex flex-column flex-grow-1">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Nombre completo</label>
                                    <input type="text" name="name" class="form-control"
                                        placeholder="ejm: Juan Pérez" value="{{ old('name') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Correo electrónico</label>
                                    <input type="email" name="email" class="form-control"
                                        placeholder="ejm: juan@correo.com" value="{{ old('email') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Contraseña</label>
                                    <div class="input-group">
                                        <input type="password" name="password" id="registerPassword" class="form-control"
                                            placeholder="mínimo 6 caracteres" required>
                                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('registerPassword', this)">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Confirmar contraseña</label>
                                    <div class="input-group">
                                        <input type="password" name="password_confirmation" id="confirmPassword" class="form-control"
                                            placeholder="repite la contraseña" required>
                                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('confirmPassword', this)">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <button class="btn btn-success w-100 py-2 fw-semibold">
                                    Registrarse
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>

<script>
// Función para mostrar/ocultar contraseña
function togglePassword(id, btn) {
    const input = document.getElementById(id);
    const icon = btn.querySelector('i');
    if(input.type === "password") {
        input.type = "text";
        icon.classList.replace("bi-eye","bi-eye-slash");
    } else {
        input.type = "password";
        icon.classList.replace("bi-eye-slash","bi-eye");
    }
}

// Forzar el fondo del footer al cargar la página
document.addEventListener("DOMContentLoaded", function() {
    const footer = document.querySelector('footer');
    if(footer) {
        footer.style.backgroundColor = "#111";
        footer.style.marginTop = "0";
    }
});
</script>

@endsection