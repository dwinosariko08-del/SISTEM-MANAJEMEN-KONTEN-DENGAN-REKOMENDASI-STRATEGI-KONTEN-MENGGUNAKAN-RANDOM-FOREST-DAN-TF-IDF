<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome - Media Informatika</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* Background Slideshow Animasi */
        .limiter {
            position: relative;
            overflow-x: hidden;
            min-height: 100vh;
            background-color: #0f1115;
        }

        .limiter::before {
            content: "";
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 0;
            background-size: cover;
            background-position: center;
            animation: corporateSlideshow 20s infinite;
            filter: brightness(0.35);
        }

        @keyframes corporateSlideshow {
            0% { background-image: url('{{ asset('auth/images/gedung.jpg') }}'); }
            16% { background-image: url('{{ asset('auth/images/gedung1.jpg') }}'); }
            33% { background-image: url('{{ asset('auth/images/ruang1.jpg') }}'); }
            50% { background-image: url('{{ asset('auth/images/ruang2.jpeg') }}'); }
            66% { background-image: url('{{ asset('auth/images/ruang3.jpg') }}'); }
            83% { background-image: url('{{ asset('auth/images/ruang4.jpeg') }}'); }
            100% { background-image: url('{{ asset('auth/images/gedung.jpg') }}'); }
        }

        /* Glassmorphism Aksen Biru */
        .nsa-glass {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        .nav-glass {
            background: rgba(15, 17, 21, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(59, 130, 246, 0.1);
        }

        .text-blue-500 { color: #FFC107; }
        .bg-blue-600 { background-color: #FFC107; }
        .shadow-blue-500\/50 { box-shadow: 0 10px 30px -10px rgba(59, 130, 246, 0.5); }
        .text-shadow { text-shadow: 0px 4px 10px rgba(0,0,0,0.8); }
        
        /* Ukuran Logo di Navbar */
        .logo-img {
            height: 45px;
            width: auto;
            object-fit: contain;
        }
    </style>
</head>
<body class="limiter text-white">

    <nav class="fixed w-full z-50 nav-glass">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <img src="{{ asset('auth/images/logo.png') }}" alt="Logo Media Informatika" class="w-10 h-10 object-contain">
                <div class="h-8 w-[1px] bg-white/20 hidden sm:block"></div>
                <span class="text-xl font-extrabold tracking-tighter text-white hidden sm:block">Media <span class="text-blue-500">Informatika</span></span>
            </div>

            @if (Route::has('login'))
            <div class="flex items-center gap-6">
                @auth
                    <a href="{{ url('/dashboard') }}" class="font-semibold text-sm hover:text-blue-500 transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="font-semibold text-sm text-gray-300 hover:text-white transition">Log in</a>
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="bg-blue-600 text-black px-6 py-2.5 rounded-full text-sm font-bold hover:scale-105 transition shadow-blue-500\/50">
                        Register
                    </a>
                    @endif
                @endauth
            </div>
            @endif
        </div>
    </nav>

    <main class="relative z-10 max-w-7xl mx-auto px-6 pt-32 lg:pt-56 flex flex-col lg:flex-row items-center gap-16 pb-20">
        
        <div class="flex-1 space-y-8 text-center lg:text-left">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-600/10 border border-blue-500/20 text-blue-500 text-xs font-bold uppercase tracking-widest">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-600 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-600"></span>
                </span>
                CONTENT MANAGEMENT SYSTEM
            </div>
            
            <h1 class="text-5xl lg:text-7xl font-extrabold text-white leading-[1.1] tracking-tight text-shadow">
              Sistem Manajemen  <br>
                <span class="text-blue-500"> Konten Media Sosial.</span>
            </h1>

            <p class="text-lg text-gray-300 max-w-xl mx-auto lg:mx-0 leading-relaxed text-shadow">
                Optimalkan manajemen aset video dan monitoring editor dalam satu dasbor eksklusif.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start pt-4">
                <a href="{{ route('login') }}" class="px-10 py-4 bg-blue-600 text-black rounded-2xl font-bold shadow-blue-500\/50 hover:scale-105 transition active:scale-95 text-center">
                    Masuk ke Sistem
                </a>
            </div>
        </div>

        <div class="flex-1 w-full max-w-xl relative">
            <div class="absolute -top-10 -right-10 w-64 h-64 bg-blue-600/10 rounded-full blur-3xl animate-pulse"></div>
            
            <div class="nsa-glass rounded-[2.5rem] p-8 shadow-2xl relative overflow-hidden border border-blue-500/30">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex gap-2">
                        <div class="w-3 h-3 rounded-full bg-blue-600"></div>
                        <div class="w-3 h-3 rounded-full bg-white/10"></div>
                        <div class="w-3 h-3 rounded-full bg-white/5"></div>
                    </div>
                    <span class="text-[10px] font-mono text-blue-500/60 uppercase">System Status: Active</span>
                </div>

                <div class="grid grid-cols-2 gap-6 mb-8">
                    <div class="p-6 rounded-3xl bg-white/5 border border-white/10 text-center lg:text-left">
                        <p class="text-[10px] font-bold text-blue-500/70 uppercase tracking-widest mb-1">Content Posted</p>
                        <h3 class="text-3xl font-black text-white">{{ number_format($publishedContent) }}</h3>
                    </div>
                    <div class="p-6 rounded-3xl bg-white/5 border border-white/10 text-center lg:text-left">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Active Assets</p>
                        <h3 class="text-3xl font-black text-white">{{ number_format($activeAssets) }}</h3>
                    </div>
                </div>

                <div class="space-y-4">
                    @if($latestProject)
                    <div class="h-16 bg-white/5 rounded-2xl border border-white/10 flex items-center px-5 justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-blue-600/10 flex items-center justify-center text-blue-500">✓</div>
                            <span class="text-sm font-bold text-gray-200">{{ Str::limit($latestProject->editorContent->content_title ?? $latestProject->topic, 25) }}</span>
                        </div>
                        <span class="text-[10px] font-bold px-3 py-1 bg-blue-600 text-black rounded-full">LIVE</span>
                    </div>
                    @else
                    <div class="h-16 bg-white/5 rounded-2xl border border-white/10 flex items-center px-5 justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-blue-600/10 flex items-center justify-center text-blue-500">⌛</div>
                            <span class="text-sm font-bold text-gray-200">Belum ada konten publik</span>
                        </div>
                        <span class="text-[10px] font-bold px-3 py-1 bg-gray-500 text-white rounded-full">WAITING</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <footer class="relative z-10 max-w-7xl mx-auto px-6 py-12 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="flex items-center gap-3">
            <img src="{{ asset('auth/images/logo.png') }}" alt="Logo Media Informatika" class="w-6 h-6 object-contain">
            <p class="text-gray-500 text-sm">© {{ date('Y') }} <span class="font-bold text-white uppercase tracking-wider">MEDIA INFORMATIKA</span>.</p>
        </div>
        <div class="flex gap-8">
            <a href="#" class="text-sm text-gray-400 hover:text-blue-500 transition">Terms</a>
            <a href="#" class="text-sm text-gray-400 hover:text-blue-500 transition font-bold">Media Informatika v1.0</a>
        </div>
    </footer>

</body>
</html>