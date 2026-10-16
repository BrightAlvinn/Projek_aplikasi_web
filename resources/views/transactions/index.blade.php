@extends('layouts.app')

@section('title', 'Riwayat & Manajemen Transaksi')
@section('page_title', 'Riwayat & Manajemen Transaksi')

@section('content')

    <!-- WIREFRAME CARD 1: FILTER & PENCARIAN TRANSAKSI -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs p-5 transition-colors">
        <form method="GET" action="{{ route('transactions.index') }}" class="space-y-4">
            
            <!-- Row 1: Dropdown & Input Filter (Tanggal, Tipe, Kategori, Deskripsi) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5">
                
                <!-- 1. Tanggal -->
                <div>
                    <label for="date" class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Tanggal</label>
                    <input type="date" id="date" name="date" value="{{ request('date') }}"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs sm:text-sm font-medium text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-[#4ABDAC] transition">
                </div>

                <!-- 2. Tipe (Pemasukan / Pengeluaran) -->
                <div>
                    <label for="type" class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Tipe</label>
                    <select id="type" name="type"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs sm:text-sm font-medium text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-[#4ABDAC] transition">
                        <option value="">Semua Tipe</option>
                        <option value="income" {{ request('type') === 'income' ? 'selected' : '' }}>Pemasukan (+)</option>
                        <option value="expense" {{ request('type') === 'expense' ? 'selected' : '' }}>Pengeluaran (-)</option>
                    </select>
                </div>

                <!-- 3. Kategori -->
                <div>
                    <label for="category_id" class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Kategori</label>
                    <select id="category_id" name="category_id"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs sm:text-sm font-medium text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-[#4ABDAC] transition">
                        <option value="">Semua Kategori</option>
                        @foreach($categories ?? [] as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }} ({{ $cat->type === 'income' ? 'Masuk' : 'Keluar' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- 4. Deskripsi -->
                <div>
                    <label for="search" class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Deskripsi</label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Cari keterangan..."
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs sm:text-sm font-medium text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-[#4ABDAC] transition">
                </div>

            </div>

            <!-- Row 2: Tombol Aksi (Terapkan Filter, Ekspor CSV, + Transaksi Baru) -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-2 border-t border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-slate-900 dark:bg-slate-800 hover:bg-slate-800 dark:hover:bg-slate-700 text-white text-xs font-bold transition shadow-xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        <span>Terapkan Filter</span>
                    </button>
                    @if(request()->hasAny(['date', 'type', 'category_id', 'search']))
                        <a href="{{ route('transactions.index') }}" class="px-3.5 py-2.5 rounded-xl text-xs font-bold text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 transition">
                            Reset
                        </a>
                    @endif
                </div>

                <div class="flex items-center gap-2.5 w-full sm:w-auto justify-end">
                    <!-- Tombol Ekspor CSV -->
                    <a href="{{ route('transactions.export', request()->query()) }}" class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 text-xs font-bold transition shadow-2xs">
                        <svg class="w-4 h-4 text-[#4ABDAC]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        <span>Ekspor CSV</span>
                    </a>

                    <!-- Tombol + Transaksi Baru -->
                    <a href="{{ route('transactions.create') }}" class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-[#4ABDAC] hover:bg-[#3ca092] text-white text-xs font-bold transition shadow-md shadow-[#4ABDAC]/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>+ Transaksi Baru</span>
                    </a>
                </div>
            </div>

        </form>
    </div>


    <!-- WIREFRAME CARD 2: TABEL TRANSAKSI TERKINI / RIWAYAT -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs overflow-hidden transition-colors">
        
        <!-- Header Tabel -->
        <div class="p-4 sm:p-5 border-b border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-sm sm:text-base font-extrabold text-slate-900 dark:text-white tracking-tight">Tabel Transaksi Terkini</h2>
                <p class="text-xs text-slate-400 dark:text-slate-500">Menampilkan {{ $transactions->total() }} catatan transaksi</p>
            </div>
            <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 font-semibold">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Masuk
                </span>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-rose-50 dark:bg-rose-950/40 text-rose-700 dark:text-rose-400 font-semibold">
                    <span class="w-2 h-2 rounded-full bg-rose-500"></span> Keluar
                </span>
            </div>
        </div>

        <!-- Tabel Data -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead class="text-xs uppercase bg-slate-50/80 dark:bg-slate-800/60 text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-800 font-bold">
                    <tr>
                        <th class="py-3.5 px-4 sm:px-6 whitespace-nowrap">Tanggal</th>
                        <th class="py-3.5 px-4 sm:px-6">Kategori</th>
                        <th class="py-3.5 px-4 sm:px-6">Deskripsi & Catatan</th>
                        <th class="py-3.5 px-4 sm:px-6 text-right whitespace-nowrap">Nominal</th>
                        <th class="py-3.5 px-4 sm:px-6 text-center whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($transactions as $tx)
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40 transition-colors">
                            <td class="py-4 px-4 sm:px-6 text-xs text-slate-500 dark:text-slate-400 whitespace-nowrap font-medium">
                                {{ $tx->transaction_date ? $tx->transaction_date->format('d M Y') : '-' }}
                            </td>
                            <td class="py-4 px-4 sm:px-6">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
                                    <span class="w-2 h-2 rounded-full shrink-0" style="background-color: {{ $tx->category?->color ?? '#64748b' }}"></span>
                                    <span class="truncate max-w-[120px]">{{ $tx->category?->name ?? 'Umum' }}</span>
                                </span>
                            </td>
                            <td class="py-4 px-4 sm:px-6 max-w-xs text-slate-800 dark:text-slate-200">
                                <p class="font-bold truncate">{{ $tx->description ?: '-' }}</p>
                                @if($tx->notes)
                                    <p class="text-[11px] text-slate-400 dark:text-slate-500 truncate mt-0.5">{{ $tx->notes }}</p>
                                @endif
                            </td>
                            <td class="py-4 px-4 sm:px-6 text-right font-extrabold whitespace-nowrap {{ $tx->type === 'income' ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                {{ $tx->type === 'income' ? '+' : '-' }} {{ $tx->formatted_amount ?? ('Rp ' . number_format($tx->amount, 0, ',', '.')) }}
                            </td>
                            <td class="py-4 px-4 sm:px-6 text-center whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <!-- Edit Link -->
                                    <a href="{{ route('transactions.edit', $tx->id) }}" class="p-1.5 rounded-lg text-slate-500 hover:text-[#4ABDAC] hover:bg-slate-100 dark:hover:bg-slate-800 transition" title="Edit Transaksi">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </a>

                                    <!-- Delete Button Form -->
                                    <form action="{{ route('transactions.destroy', $tx->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition" title="Hapus Transaksi">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-12 text-slate-400 dark:text-slate-500 text-xs">
                                <p class="text-sm font-semibold mb-1">Tidak ada data transaksi yang sesuai filter.</p>
                                <p>Silakan sesuaikan filter pencarian atau klik <a href="{{ route('transactions.create') }}" class="text-[#4ABDAC] underline font-bold">Catat Transaksi Baru</a>.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($transactions->hasPages())
            <div class="p-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30">
                {{ $transactions->links() }}
            </div>
        @endif

    </div>

@endsection
