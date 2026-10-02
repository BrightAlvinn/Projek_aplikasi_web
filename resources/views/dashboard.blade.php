<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - CatatUang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen">
    <div class="max-w-4xl mx-auto py-12 px-4">
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <h1 class="text-2xl font-bold text-slate-800 mb-2">
                Selamat datang, {{ Auth::user()->name }}! 🎉
            </h1>
            <p class="text-slate-500 mb-6">Anda berhasil masuk ke dashboard CatatUang.</p>

            @if(session('success'))
                <div class="bg-teal-50 text-teal-700 text-sm p-3 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="border-t pt-4 mt-4">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-xl text-sm font-semibold transition">
                        Keluar (Logout)
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
