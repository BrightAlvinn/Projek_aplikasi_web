@extends('layouts.app')

@section('title', 'Manajemen Kategori')
@section('page_title', 'Manajemen Kategori')

@section('content')

    <!-- WIREFRAME TOP ACTION CARD: FORM TAMBAH KATEGORI BARU -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs p-5 transition-colors">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
            <div>
                <h2 class="text-sm sm:text-base font-extrabold text-slate-900 dark:text-white tracking-tight">Tambah Kategori Baru</h2>
                <p class="text-xs text-slate-400 dark:text-slate-500">Buat pos kategori baru untuk mengelompokkan arus keuangan Anda</p>
            </div>
        </div>

        <form action="{{ route('categories.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-12 gap-3.5 items-end">
            @csrf

            <!-- Nama Kategori -->
            <div class="sm:col-span-5">
                <label for="new_cat_name" class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Nama Kategori</label>
                <input type="text" id="new_cat_name" name="name" placeholder="Misal: Langganan Streaming, Hadiah, dll." required
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs sm:text-sm font-medium text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-[#4ABDAC] transition">
            </div>

            <!-- Tipe Kategori -->
            <div class="sm:col-span-3">
                <label for="new_cat_type" class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Jenis Arus</label>
                <select id="new_cat_type" name="type" required
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs sm:text-sm font-medium text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-[#4ABDAC] transition">
                    <option value="expense">Pengeluaran (-)</option>
                    <option value="income">Pemasukan (+)</option>
                </select>
            </div>

            <!-- Warna Aksen -->
            <div class="sm:col-span-2">
                <label for="new_cat_color" class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Warna Label</label>
                <div class="flex items-center gap-2">
                    <input type="color" id="new_cat_color" name="color" value="#4ABDAC"
                        class="w-full h-10 p-1 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 cursor-pointer">
                </div>
            </div>

            <!-- Tombol Tambah -->
            <div class="sm:col-span-2">
                <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-[#4ABDAC] hover:bg-[#3ca092] text-white text-xs sm:text-sm font-bold shadow-md shadow-[#4ABDAC]/20 transition flex items-center justify-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>+ Simpan</span>
                </button>
            </div>
        </form>
    </div>


    <!-- WIREFRAME MAIN CONTENT: 2 KOLOM (KATEGORI PENGELUARAN & KATEGORI PEMASUKAN) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        
        <!-- KOLOM 1: KATEGORI PENGELUARAN (KIRI) -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs p-5 transition-colors">
            <div class="flex items-center justify-between gap-3 pb-3 mb-4 border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-extrabold text-slate-900 dark:text-white">Kategori Pengeluaran</h3>
                        <p class="text-[11px] text-slate-400 dark:text-slate-500">{{ count($expenseCategories) }} kategori terdaftar</p>
                    </div>
                </div>
                <span class="text-xs font-bold px-2 py-0.5 rounded-full bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400">Outflow</span>
            </div>

            <div class="space-y-2.5">
                @forelse($expenseCategories as $cat)
                    <div class="flex items-center justify-between p-3 rounded-xl border border-slate-200/80 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/40 hover:bg-white dark:hover:bg-slate-800 transition">
                        <div class="flex items-center gap-3 min-w-0">
                            <span class="w-3.5 h-3.5 rounded-full shrink-0 shadow-2xs" style="background-color: {{ $cat->color }}"></span>
                            <div class="min-w-0">
                                <p class="text-xs sm:text-sm font-bold text-slate-800 dark:text-slate-200 truncate">{{ $cat->name }}</p>
                                <p class="text-[11px] text-slate-400 dark:text-slate-500">{{ $cat->transactions_count }} transaksi</p>
                            </div>
                        </div>

                        <!-- Action Buttons: Edit & Hapus -->
                        <div class="flex items-center gap-1 shrink-0">
                            <button type="button" onclick="openEditModal({{ $cat->id }}, '{{ addslashes($cat->name) }}', '{{ $cat->type }}', '{{ $cat->color }}')"
                                class="p-1.5 rounded-lg text-slate-400 hover:text-[#4ABDAC] hover:bg-slate-100 dark:hover:bg-slate-700 transition" title="Edit Kategori">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                </svg>
                            </button>

                            <form action="{{ route('categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Hapus kategori {{ addslashes($cat->name) }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition" title="Hapus Kategori">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-center py-8 text-xs text-slate-400 dark:text-slate-500">Belum ada kategori pengeluaran.</p>
                @endforelse
            </div>
        </div>

        <!-- KOLOM 2: KATEGORI PEMASUKAN (KANAN) -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs p-5 transition-colors">
            <div class="flex items-center justify-between gap-3 pb-3 mb-4 border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-extrabold text-slate-900 dark:text-white">Kategori Pemasukan</h3>
                        <p class="text-[11px] text-slate-400 dark:text-slate-500">{{ count($incomeCategories) }} kategori terdaftar</p>
                    </div>
                </div>
                <span class="text-xs font-bold px-2 py-0.5 rounded-full bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400">Inflow</span>
            </div>

            <div class="space-y-2.5">
                @forelse($incomeCategories as $cat)
                    <div class="flex items-center justify-between p-3 rounded-xl border border-slate-200/80 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/40 hover:bg-white dark:hover:bg-slate-800 transition">
                        <div class="flex items-center gap-3 min-w-0">
                            <span class="w-3.5 h-3.5 rounded-full shrink-0 shadow-2xs" style="background-color: {{ $cat->color }}"></span>
                            <div class="min-w-0">
                                <p class="text-xs sm:text-sm font-bold text-slate-800 dark:text-slate-200 truncate">{{ $cat->name }}</p>
                                <p class="text-[11px] text-slate-400 dark:text-slate-500">{{ $cat->transactions_count }} transaksi</p>
                            </div>
                        </div>

                        <!-- Action Buttons: Edit & Hapus -->
                        <div class="flex items-center gap-1 shrink-0">
                            <button type="button" onclick="openEditModal({{ $cat->id }}, '{{ addslashes($cat->name) }}', '{{ $cat->type }}', '{{ $cat->color }}')"
                                class="p-1.5 rounded-lg text-slate-400 hover:text-[#4ABDAC] hover:bg-slate-100 dark:hover:bg-slate-700 transition" title="Edit Kategori">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                </svg>
                            </button>

                            <form action="{{ route('categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Hapus kategori {{ addslashes($cat->name) }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition" title="Hapus Kategori">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-center py-8 text-xs text-slate-400 dark:text-slate-500">Belum ada kategori pemasukan.</p>
                @endforelse
            </div>
        </div>

    </div>

    <!-- MODAL EDIT KATEGORI -->
    <div id="editCategoryModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
        <div class="bg-white dark:bg-slate-900 rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-200 dark:border-slate-800 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                <h3 class="text-base font-bold text-slate-900 dark:text-white">Edit Kategori</h3>
                <button type="button" onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 font-bold text-lg">&times;</button>
            </div>

            <form id="editCategoryForm" method="POST" action="" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="edit_name" class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Nama Kategori</label>
                    <input type="text" id="edit_name" name="name" required
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs sm:text-sm font-medium text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-[#4ABDAC] transition">
                </div>

                <div>
                    <label for="edit_type" class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Jenis Arus</label>
                    <select id="edit_type" name="type" required
                        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs sm:text-sm font-medium text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-[#4ABDAC] transition">
                        <option value="expense">Pengeluaran (-)</option>
                        <option value="income">Pemasukan (+)</option>
                    </select>
                </div>

                <div>
                    <label for="edit_color" class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Warna Label</label>
                    <input type="color" id="edit_color" name="color"
                        class="w-full h-10 p-1 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 cursor-pointer">
                </div>

                <div class="pt-2 flex items-center justify-end gap-2">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-[#4ABDAC] hover:bg-[#3ca092] text-white text-xs font-bold rounded-xl shadow-md transition">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    function openEditModal(id, name, type, color) {
        const form = document.getElementById('editCategoryForm');
        form.action = `/categories/${id}`;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_type').value = type;
        document.getElementById('edit_color').value = color || '#4ABDAC';
        document.getElementById('editCategoryModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editCategoryModal').classList.add('hidden');
    }
</script>
@endpush
