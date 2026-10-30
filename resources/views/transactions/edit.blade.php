@extends('layouts.app')

@section('title', 'Edit Transaksi')
@section('page_title', 'Edit Transaksi')

@section('content')

    <div class="max-w-2xl mx-auto">
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-md p-6 sm:p-8 space-y-6 transition-colors">
            
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800">
                <div>
                    <h2 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white">Perbarui Transaksi</h2>
                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">Ubah data transaksi yang sudah dicatat</p>
                </div>
                <a href="{{ route('transactions.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Kembali</span>
                </a>
            </div>

            @if (isset($errors) && $errors->any())
                <div class="bg-rose-50 dark:bg-rose-950/40 border border-rose-100 dark:border-rose-900 text-rose-600 dark:text-rose-400 text-xs sm:text-sm p-3.5 rounded-xl">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('transactions.update', $transaction->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <!-- Jenis Transaksi -->
                <fieldset>
                    <legend class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">Jenis Transaksi</legend>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="type" value="income" class="peer sr-only" {{ old('type', $transaction->type) === 'income' ? 'checked' : '' }} required>
                            <span class="flex items-center justify-center gap-2 w-full px-4 py-3 border-2 border-slate-200 dark:border-slate-700 rounded-2xl text-sm font-bold text-slate-500 dark:text-slate-400 text-center transition hover:bg-teal-50/50 dark:hover:bg-teal-950/20 peer-checked:border-[#4ABDAC] peer-checked:bg-[#4ABDAC]/10 peer-checked:text-[#4ABDAC]">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                                <span>Pemasukan (+)</span>
                            </span>
                        </label>
                        <label class="relative cursor-pointer">
                            <input type="radio" name="type" value="expense" class="peer sr-only" {{ old('type', $transaction->type) === 'expense' ? 'checked' : '' }} required>
                            <span class="flex items-center justify-center gap-2 w-full px-4 py-3 border-2 border-slate-200 dark:border-slate-700 rounded-2xl text-sm font-bold text-slate-500 dark:text-slate-400 text-center transition hover:bg-rose-50/50 dark:hover:bg-rose-950/20 peer-checked:border-rose-500 peer-checked:bg-rose-50/20 dark:peer-checked:bg-rose-950/40 peer-checked:text-rose-600 dark:peer-checked:text-rose-400">
                                <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>
                                <span>Pengeluaran (-)</span>
                            </span>
                        </label>
                    </div>
                </fieldset>

                <!-- Nominal -->
                <div>
                    <label for="amount" class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">Nominal (Rp)</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 font-bold text-base">Rp</span>
                        <input type="text" id="amount" inputmode="numeric" autocomplete="off" value="{{ old('amount', (int) $transaction->amount) }}" required
                            data-rupiah-input data-rupiah-target="amount_value"
                            class="block w-full pl-12 pr-4 py-3 border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 rounded-xl text-lg sm:text-xl font-bold text-slate-900 dark:text-white placeholder:text-slate-300 dark:placeholder:text-slate-600 focus:outline-none focus:ring-2 focus:ring-[#4ABDAC] transition">
                        <input type="hidden" id="amount_value" name="amount" value="{{ old('amount', (int) $transaction->amount) }}">
                    </div>
                </div>

                <!-- Kategori & Tanggal -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="category_id" class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">Kategori</label>
                        <select id="category_id" name="category_id" required
                            class="block w-full px-4 py-3 border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 rounded-xl text-sm font-semibold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#4ABDAC] transition">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $transaction->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }} ({{ $cat->type === 'income' ? 'Masuk' : 'Keluar' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="transaction_date" class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">Tanggal</label>
                        <input type="date" id="transaction_date" name="transaction_date" value="{{ old('transaction_date', $transaction->transaction_date ? $transaction->transaction_date->format('Y-m-d') : date('Y-m-d')) }}" required
                            class="block w-full px-4 py-3 border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 rounded-xl text-sm font-semibold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#4ABDAC] transition">
                    </div>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">Deskripsi Singkat</label>
                    <input type="text" id="description" name="description" value="{{ old('description', $transaction->description) }}" required
                        class="block w-full px-4 py-3 border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 rounded-xl text-sm font-medium text-slate-900 dark:text-white placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#4ABDAC] transition">
                </div>

                <!-- Catatan Tambahan (Opsional) -->
                <div>
                    <label for="notes" class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">Catatan Tambahan (Opsional)</label>
                    <textarea id="notes" name="notes" rows="2"
                        class="block w-full px-4 py-3 border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 rounded-xl text-sm font-medium text-slate-900 dark:text-white placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#4ABDAC] transition">{{ old('notes', $transaction->notes) }}</textarea>
                </div>

                <!-- Tombol Submit -->
                <div class="pt-2 flex items-center justify-end gap-3">
                    <a href="{{ route('transactions.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 text-xs sm:text-sm font-bold hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#4ABDAC] hover:bg-[#3ca092] text-white text-xs sm:text-sm font-bold shadow-md shadow-[#4ABDAC]/20 transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>

        </div>
    </div>

@endsection
