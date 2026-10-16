<!DOCTYPE html>
<html lang="id" class="overflow-x-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catat Transaksi - CatatUang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen w-full max-w-full overflow-x-hidden text-slate-800 antialiased p-4 sm:p-6 md:p-8 flex justify-center items-start sm:items-center transition-all duration-300 ease-in-out">

    <div class="w-full max-w-lg md:max-w-2xl bg-white p-5 sm:p-8 rounded-2xl sm:rounded-3xl border border-slate-200 shadow-md transition-all duration-300 ease-in-out">
        <!-- Header: tombol Kembali di atas judul pada mobile, di kanan pada layar lebar -->
        <div class="flex flex-col-reverse sm:flex-row sm:items-start sm:justify-between gap-3 mb-5 md:mb-6 transition-all duration-300 ease-in-out">
            <div class="min-w-0">
                <h2 class="text-xl md:text-2xl font-bold text-slate-900 transition-all duration-300 ease-in-out">Catat Transaksi</h2>
                <p class="text-xs md:text-sm text-slate-400 mt-0.5">Masukkan pemasukan atau pengeluaran baru</p>
            </div>
            <a href="{{ route('dashboard') }}" class="self-start shrink-0 inline-flex items-center gap-1 whitespace-nowrap px-3 py-1.5 -ml-3 sm:ml-0 rounded-lg text-xs font-semibold text-teal-600 hover:bg-teal-50 transition-all duration-300 ease-in-out">
                <span aria-hidden="true">←</span> Kembali
            </a>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-100 text-red-600 text-xs sm:text-sm p-3 rounded-xl mb-4 break-words">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('transactions.store') }}" method="POST" class="w-full space-y-4 md:space-y-5">
            @csrf

            <!-- Jenis Transaksi -->
            <fieldset>
                <legend class="block text-xs font-bold uppercase text-slate-500 mb-1.5">Jenis Transaksi</legend>
                {{-- Radio asli disembunyikan (sr-only) dan tampil sebagai tombol pilihan, sehingga tidak lagi menabrak border kartu --}}
                <div class="grid grid-cols-1 min-[360px]:grid-cols-2 gap-2.5 sm:gap-3 transition-all duration-300 ease-in-out">
                    <label class="relative cursor-pointer min-w-0">
                        <input type="radio" name="type" value="income" class="peer sr-only" {{ old('type') === 'income' ? 'checked' : '' }} required>
                        <span class="flex items-center justify-center gap-2 w-full px-3 py-3 border-2 border-slate-200 rounded-xl text-sm font-semibold text-slate-500 text-center transition-all duration-300 ease-in-out hover:bg-teal-50 peer-checked:border-teal-500 peer-checked:bg-teal-50 peer-checked:text-teal-700 peer-focus-visible:ring-2 peer-focus-visible:ring-teal-500">
                            <span class="w-2 h-2 shrink-0 rounded-full bg-teal-500"></span>
                            <span>Pemasukan (+)</span>
                        </span>
                    </label>
                    <label class="relative cursor-pointer min-w-0">
                        <input type="radio" name="type" value="expense" class="peer sr-only" {{ old('type', 'expense') === 'expense' ? 'checked' : '' }} required>
                        <span class="flex items-center justify-center gap-2 w-full px-3 py-3 border-2 border-slate-200 rounded-xl text-sm font-semibold text-slate-500 text-center transition-all duration-300 ease-in-out hover:bg-rose-50 peer-checked:border-rose-500 peer-checked:bg-rose-50 peer-checked:text-rose-700 peer-focus-visible:ring-2 peer-focus-visible:ring-rose-500">
                            <span class="w-2 h-2 shrink-0 rounded-full bg-rose-500"></span>
                            <span>Pengeluaran (-)</span>
                        </span>
                    </label>
                </div>
            </fieldset>

            <!-- Nominal -->
            <div>
                <label for="amount" class="block text-xs font-bold uppercase text-slate-500 mb-1.5">Nominal (Rp)</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 font-bold">Rp</span>
                    <input type="number" id="amount" name="amount" inputmode="numeric" min="1" value="{{ old('amount') }}" placeholder="50000" required
                        class="block w-full min-w-0 pl-12 pr-4 py-3 border border-slate-200 rounded-xl text-lg md:text-xl font-bold text-slate-900 placeholder:text-slate-300 focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-500/30 transition-all duration-300 ease-in-out">
                </div>
            </div>

            <!-- Kategori & Tanggal: bertumpuk di mobile, berdampingan di desktop -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5 transition-all duration-300 ease-in-out">
                <!-- Kategori -->
                <div class="min-w-0">
                    <label for="category_id" class="block text-xs font-bold uppercase text-slate-500 mb-1.5">Kategori</label>
                    <select id="category_id" name="category_id" required class="block w-full min-w-0 px-4 py-3 border border-slate-200 rounded-xl bg-white text-base sm:text-sm truncate focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-500/30 transition-all duration-300 ease-in-out">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                [{{ strtoupper($cat->type === 'income' ? 'Masuk' : 'Keluar') }}] {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tanggal -->
                <div class="min-w-0">
                    <label for="transaction_date" class="block text-xs font-bold uppercase text-slate-500 mb-1.5">Tanggal</label>
                    <input type="date" id="transaction_date" name="transaction_date" value="{{ old('transaction_date', date('Y-m-d')) }}" required
                        class="block w-full min-w-0 max-w-full appearance-none px-4 py-3 border border-slate-200 rounded-xl bg-white text-base sm:text-sm focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-500/30 transition-all duration-300 ease-in-out">
                </div>
            </div>

            <!-- Keterangan -->
            <div>
                <label for="description" class="block text-xs font-bold uppercase text-slate-500 mb-1.5">Keterangan</label>
                <input type="text" id="description" name="description" value="{{ old('description') }}" placeholder="Contoh: Makan siang, Gaji kantor" required
                    class="block w-full min-w-0 px-4 py-3 border border-slate-200 rounded-xl text-base sm:text-sm focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-500/30 transition-all duration-300 ease-in-out">
            </div>

            <!-- Catatan Opsional -->
            <div>
                <label for="notes" class="block text-xs font-bold uppercase text-slate-500 mb-1.5">Catatan Tambahan <span class="normal-case font-medium text-slate-400">(Opsional)</span></label>
                <textarea id="notes" name="notes" rows="3" placeholder="Catatan kecil..." class="block w-full min-w-0 px-4 py-3 border border-slate-200 rounded-xl text-base sm:text-sm resize-y focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-500/30 transition-all duration-300 ease-in-out">{{ old('notes') }}</textarea>
            </div>

            <!-- Aksi: bertumpuk di mobile (Simpan di atas), berdampingan di desktop -->
            <div class="flex flex-col-reverse md:flex-row md:justify-end gap-2.5 md:gap-3 pt-1 transition-all duration-300 ease-in-out">
                <a href="{{ route('dashboard') }}" class="w-full md:w-auto text-center px-6 py-3 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition-all duration-300 ease-in-out">
                    Batal
                </a>
                <button type="submit" class="w-full md:w-auto px-8 py-3 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-xl shadow-sm transition-all duration-300 ease-in-out">
                    Simpan Transaksi
                </button>
            </div>
        </form>
    </div>

</body>
</html>