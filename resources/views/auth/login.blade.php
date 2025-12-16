<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Rental Mobil</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    
   <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#667eea',
                },
            },
            fontFamily: {
                sans: ['Plus Jakarta Sans', 'sans-serif'],
            },
        }
    }
</script>
<style>
    .gradient-bg {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
    }
    
    .glass-effect {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }
    
    .input-field {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .input-field:focus {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.2);
    }
    
    .btn-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .btn-gradient:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
    }
    
    .btn-gradient:active {
        transform: translateY(-1px);
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }
    
    .float-animation {
        animation: float 6s ease-in-out infinite;
    }
    
    .blob {
        position: absolute;
        border-radius: 50%;
        filter: blur(60px);
        opacity: 0.5;
        animation: blob 7s infinite;
    }
    
    @keyframes blob {
        0%, 100% { transform: translate(0, 0) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
    }
    
    .car-3d {
        position: relative;
        transform-style: preserve-3d;
        animation: car-float 4s ease-in-out infinite;
        filter: drop-shadow(0 30px 60px rgba(0, 0, 0, 0.5));
    }
    
    @keyframes car-float {
        0%, 100% { 
            transform: translateY(0px) translateZ(50px) rotateY(-5deg);
        }
        50% { 
            transform: translateY(-15px) translateZ(50px) rotateY(-5deg);
        }
    }
    
    .car-3d img {
        transform: perspective(1000px) rotateY(-10deg) rotateX(2deg);
        transition: transform 0.3s ease;
    }
    
    .car-3d:hover img {
        transform: perspective(1000px) rotateY(-15deg) rotateX(5deg) scale(1.05);
    }
    
    .car-glow {
        position: absolute;
        bottom: -20px;
        left: 50%;
        transform: translateX(-50%);
        width: 80%;
        height: 40px;
        background: radial-gradient(ellipse, rgba(102, 126, 234, 0.6), transparent);
        filter: blur(20px);
        animation: glow-pulse 2s ease-in-out infinite;
    }
    
    @keyframes glow-pulse {
        0%, 100% { opacity: 0.6; transform: translateX(-50%) scale(1); }
        50% { opacity: 1; transform: translateX(-50%) scale(1.1); }
    }
    
    .speed-lines {
        position: absolute;
        top: 50%;
        left: -100px;
        width: 200px;
        height: 2px;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.8), transparent);
        animation: speed-line 1.5s ease-in-out infinite;
    }
    
    @keyframes speed-line {
        0% { transform: translateX(-200px); opacity: 0; }
        50% { opacity: 1; }
        100% { transform: translateX(400px); opacity: 0; }
    }
</style>
</head>
<body class="font-sans overflow-hidden">
    <!-- Background with Gradient and Blobs -->
    <div class="gradient-bg fixed inset-0 z-0">
        <div class="blob w-96 h-96 bg-purple-400 top-0 left-0"></div>
        <div class="blob w-80 h-80 bg-pink-400 bottom-0 right-0" style="animation-delay: 2s;"></div>
        <div class="blob w-72 h-72 bg-blue-400 top-1/2 left-1/2" style="animation-delay: 4s;"></div>
    </div>

    <!-- Main Content -->
    <section class="relative z-10 min-h-screen flex items-center justify-center px-4 py-12">
        <div class="container mx-auto max-w-7xl">
            <div class="flex flex-wrap items-center justify-center lg:justify-between gap-12">
                
                <!-- Left Side - Login Form -->
                <div class="w-full lg:w-5/12 order-2 lg:order-1">
                    <div class="glass-effect rounded-3xl shadow-2xl p-8 md:p-12">
                        <!-- Header -->
                        <div class="text-center mb-8">
                            <h2 class="text-3xl font-bold text-gray-800 mb-2">Selamat Datang</h2>
                            <p class="text-gray-600">Silakan login untuk melanjutkan</p>
                        </div>

                        <!-- Form -->
                        <form action="{{route('login.proses')}}" method="POST" class="space-y-6">
                            @csrf
                            
                            <!-- Email Input -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="ti ti-mail mr-2"></i>Email Address
                                </label>
                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    required
                                    class="input-field w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:outline-none bg-white/50"
                                    placeholder="admin@gmail.com" />
                            </div>

                            <!-- Password Input -->
                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="ti ti-lock mr-2"></i>Password
                                </label>
                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    required
                                    class="input-field w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:outline-none bg-white/50"
                                    placeholder="••••••••" />
                            </div>

                            <!-- Remember Me -->
                            <div class="flex items-center justify-between">
                                <label class="flex items-center cursor-pointer">
                                    <input
                                        type="checkbox"
                                        class="w-5 h-5 rounded border-gray-300 text-purple-600 focus:ring-purple-500"
                                        checked />
                                    <span class="ml-2 text-sm text-gray-700 font-medium">Remember me</span>
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <button
                                type="submit"
                                class="btn-gradient w-full py-4 rounded-xl text-white font-bold text-lg shadow-lg">
                                <i class="ti ti-login mr-2"></i>Sign In
                            </button>
                        </form>

                        <!-- Footer -->
                        <div class="mt-8 text-center">
                            <p class="text-sm text-gray-600">
                                © 2025 Rent Car Nasi. All rights reserved.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Right Side - 3D Lamborghini -->
                <div class="w-full lg:w-6/12 order-1 lg:order-2 relative">
                    <!-- Speed Lines Effect -->
                    <div class="speed-lines" style="top: 40%;"></div>
                    <div class="speed-lines" style="top: 50%; animation-delay: 0.3s;"></div>
                    <div class="speed-lines" style="top: 60%; animation-delay: 0.6s;"></div>
                    
                    <!-- 3D Car Container -->
                    <div class="car-3d relative z-10">
                        <img 
                            src="{{ asset('assets/images/rent-car-nasi.png') }}" 
                            alt="Lamborghini" 
                            class="w-full h-auto"
                            style="max-width: 1200px;" />
                        <!-- Glow Effect Under Car -->
                        <div class="car-glow"></div>
                    </div>
                    
                    <!-- Text Content -->
                    <div class="mt-8 text-center relative z-20">
                        <h1 class="text-5xl md:text-7xl font-bold text-white mb-4 drop-shadow-lg">
                            Rent Car Nasi
                        </h1>
                        <p class="text-xl md:text-2xl text-white/90 drop-shadow-md">
                            © Powered By | Sri Mulyarni | Attaya Botak
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 1500
        });
    @endif
    @if(session('failed'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('failed') }}',
        });
    @endif
    @if($errors->any())
        Swal.fire({
            icon: 'warning',
            title: 'Perhatian',
            html: `
                <ul style="text-align: left;">
                    @foreach($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            `,
        });
    @endif
</script>
</body>
</html>