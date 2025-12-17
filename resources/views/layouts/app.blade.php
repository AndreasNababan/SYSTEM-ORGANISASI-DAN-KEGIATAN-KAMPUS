<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Sistem Organisasi') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body { font-family: 'Inter', sans-serif; }

            /* --- HIDE SCROLLBAR --- */
            html::-webkit-scrollbar { display: none; }
            html { -ms-overflow-style: none; scrollbar-width: none; }

            /* --- ANIMASI --- */
            @keyframes blob {
                0% { transform: translate(0px, 0px) scale(1); }
                33% { transform: translate(30px, -50px) scale(1.1); }
                66% { transform: translate(-20px, 20px) scale(0.9); }
                100% { transform: translate(0px, 0px) scale(1); }
            }
            .animate-blob { animation: blob 7s infinite; }
            .animation-delay-2000 { animation-delay: 2s; }
            .animation-delay-4000 { animation-delay: 4s; }
            
            @keyframes fadeInUp {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .animate-fade-in-up { animation: fadeInUp 0.5s ease-out forwards; }
        </style>

        <script>
            // Fungsi untuk mengecek preferensi sistem
            function updateTheme() {
                // Jika user punya settingan OS/Browser Dark Mode
                if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            }

            // Jalankan saat pertama kali load
            updateTheme();

            // Dengarkan perubahan (misal: user ganti settingan Chrome saat web sedang dibuka)
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', updateTheme);
        </script>
    </head>
    
    <body class="font-sans antialiased text-gray-900 bg-gray-50 dark:bg-gray-950 dark:text-gray-100 transition-colors duration-300">
        
        <div class="fixed inset-0 -z-10 overflow-hidden">
            <div class="absolute -top-[10%] -left-[10%] w-[40rem] h-[40rem] rounded-full animate-blob 
                        bg-purple-300 mix-blend-multiply blur-3xl opacity-70 
                        dark:bg-purple-600 dark:mix-blend-normal dark:blur-[100px] dark:opacity-20"></div>
            
            <div class="absolute top-[0%] -right-[10%] w-[35rem] h-[35rem] rounded-full animate-blob animation-delay-2000 
                        bg-blue-300 mix-blend-multiply blur-3xl opacity-70 
                        dark:bg-blue-600 dark:mix-blend-normal dark:blur-[100px] dark:opacity-20"></div>
            
            <div class="absolute -bottom-[10%] left-[20%] w-[40rem] h-[40rem] rounded-full animate-blob animation-delay-4000 
                        bg-pink-300 mix-blend-multiply blur-3xl opacity-70 
                        dark:bg-pink-600 dark:mix-blend-normal dark:blur-[100px] dark:opacity-20"></div>
        </div>

        <div class="min-h-screen flex flex-col relative">
            
            <div class="relative z-50 sticky top-0 border-b backdrop-blur-md 
                        bg-white/80 border-gray-200 
                        dark:bg-gray-900/80 dark:border-gray-800 transition-colors duration-300">
                @include('layouts.navigation')
            </div>

            @isset($header)
                <header class="relative z-40 shadow-sm border-b backdrop-blur-sm 
                               bg-white/60 border-gray-100 
                               dark:bg-gray-900/50 dark:border-gray-800 transition-colors duration-300">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <h2 class="font-bold text-2xl leading-tight tracking-tight 
                                   text-gray-800 
                                   dark:text-white">
                            {{ $header }}
                        </h2>
                    </div>
                </header>
            @endisset

            <main class="flex-grow container mx-auto px-4 sm:px-6 lg:px-8 py-8 relative z-30">
                <div class="animate-fade-in-up">
                    {{ $slot }}
                </div>
            </main>

           
        </div>
    </body>
</html>