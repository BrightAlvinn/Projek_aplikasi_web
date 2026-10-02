<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Aplikasi Keuangan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen p-4">
    <div class="bg-white p-8 rounded-2xl shadow-lg max-w-md w-full">
        <h2 class="text-2xl font-bold text-slate-800 text-center mb-1">Buat Akun Baru</h2>
        <p class="text-sm text-slate-500 text-center mb-6">Mulai kelola arus kas Anda hari ini</p>

        @if ($errors->any())
            <div class="bg-red-50 text-red-600 text-sm p-3 rounded-lg mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    placeholder="Contoh: Budi Santoso"
                    class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-teal-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    placeholder="nama@email.com"
                    class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-teal-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Kata Sandi</label>
                <input type="password" name="password" required
                    placeholder="Minimal 6 karakter"
                    class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-teal-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Konfirmasi Kata Sandi</label>
                <input type="password" name="password_confirmation" required
                    placeholder="Ulangi kata sandi"
                    class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-teal-500 focus:outline-none">
            </div>

            <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-semibold py-2.5 rounded-xl transition">
                Daftar Sekarang
            </button>
        </form>

        <p class="text-center text-sm text-slate-500 mt-6">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="text-teal-600 font-semibold hover:underline">Masuk di sini</a>
        </p>
    </div>
</body>
</html>