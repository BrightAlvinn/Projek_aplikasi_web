<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catat Transaksi - CatatUang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen text-slate-800 p-6 flex justify-center items-center">

    <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-md max-w-lg w-full">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Catat Transaksi</h2>
                <p class="text-xs text-slate-400">Masukkan pemasukan atau pengeluaran baru</p>
            </div>
            <a href="{{ route('dashboard') }}" class="text-xs font-semibold text-teal-600 hover:underline">← Kembali</a>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 text-red-600 text-xs p-3 rounded-xl mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('transactions.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Jenis Transaksi -->
            <div>
                <label class="block text-xs font-bold uppercase text-slate-500 mb-1">Jenis Transaksi</label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="flex items-center justify-center gap-2 p-3 border rounded-xl cursor-pointer hover:bg-teal-50 border-teal-500 text-teal-700 font-semibold text-sm">
                        <input type="radio" name="type" value="income" {{ old('type') === 'income' ? 'checked' : '' }} required>
                        <span>Pemasukan (+)</span>
                    </label>
                    <label class="flex items-center justify-center gap-2 p-3 border rounded-xl cursor-pointer hover:bg-rose-50 border-rose-500 text-rose-700 font-semibold text-sm">
                        <input type="radio" name="type" value="expense" {{ old('type', 'expense') === 'expense' ? 'checked' : '' }} required>
                        <span>Pengeluaran (-)</span>
                    </label>
                </div>
            </div>

            <!-- Nominal -->
            <div>
                <label class="block text-xs font-bold uppercase text-slate-500 mb-1">Nominal (Rp)</label>
                <input type="number" name="amount" value="{{ old('amount') }}" placeholder="Contoh: 50000" required
                    class="w-full px-4 py-2.5 border rounded-xl text-lg font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-teal-500">
            </div>

            <!-- Kategori -->
            <div>
                <label class="block text-xs font-bold uppercase text-slate-500 mb-1">Kategori</label>
                <select name="category_id" required class="w-full px-4 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                            [{{ strtoupper($cat->type === 'income' ? 'Masuk' : 'Keluar') }}] {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Tanggal -->
            <div>
                <label class="block text-xs font-bold uppercase text-slate-500 mb-1">Tanggal</label>
                <input type="date" name="transaction_date" value="{{ old('transaction_date', date('Y-m-d')) }}" required
                    class="w-full px-4 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
            </div>

            <!-- Keterangan -->
            <div>
                <label class="block text-xs font-bold uppercase text-slate-500 mb-1">Keterangan</label>
                <input type="text" name="description" value="{{ old('description') }}" placeholder="Contoh: Makan siang, Gaji kantor" required
                    class="w-full px-4 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
            </div>

            <!-- Catatan Opsional -->
            <div>
                <label class="block text-xs font-bold uppercase text-slate-500 mb-1">Catatan Tambahan (Opsional)</label>
                <textarea name="notes" rows="2" placeholder="Catatan kecil..." class="w-full px-4 py-2 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">{{ old('notes') }}</textarea>
            </div>

            <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 rounded-xl transition">
                Simpan Transaksi
            </button>
        </form>
    </div>

</body>
</html>