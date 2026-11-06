<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\DefaultCategory;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class AdminDashboardController extends Controller
{
    /**
     * Menampilkan halaman Dashboard khusus Admin dengan 5 modul analitik & manajemen utama.
     */
    public function index(Request $request): View
    {
        $now = Carbon::now();

        // =========================================================================
        // 1. RINGKASAN STATISTIK UTAMA (KPI CARDS)
        // =========================================================================
        $totalUsers = User::count();
        $startOfMonth = $now->copy()->startOfMonth();
        $newUsersThisMonth = User::where('created_at', '>=', $startOfMonth)->count();

        // Pengguna Aktif (transaksi dalam 7 hari & 30 hari terakhir)
        $sevenDaysAgo = $now->copy()->subDays(7)->toDateString();
        $thirtyDaysAgo = $now->copy()->subDays(30)->toDateString();

        $activeUsers7Days = User::whereHas('transactions', function ($query) use ($sevenDaysAgo) {
            $query->where('transaction_date', '>=', $sevenDaysAgo);
        })->count();

        $activeUsers30Days = User::whereHas('transactions', function ($query) use ($thirtyDaysAgo) {
            $query->where('transaction_date', '>=', $thirtyDaysAgo);
        })->count();

        // Total Frekuensi Transaksi
        $totalTransactions = Transaction::count();
        $incomeTransactionsCount = Transaction::where('type', 'income')->count();
        $expenseTransactionsCount = Transaction::where('type', 'expense')->count();

        // Total Penggunaan Storage (file foto bukti transaksi)
        $storageStats = $this->calculateReceiptStorage();

        // =========================================================================
        // 2. GRAFIK & ANALITIK PLATFORM
        // =========================================================================
        // A. Pertumbuhan Pengguna Baru (6 Bulan Terakhir & 8 Minggu Terakhir)
        $userGrowthMonthlyLabels = [];
        $userGrowthMonthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $mStart = $now->copy()->subMonths($i)->startOfMonth();
            $mEnd = $now->copy()->subMonths($i)->endOfMonth();
            $userGrowthMonthlyLabels[] = $mStart->isoFormat('MMM Y');
            $userGrowthMonthlyData[] = User::whereBetween('created_at', [$mStart, $mEnd])->count();
        }

        $userGrowthWeeklyLabels = [];
        $userGrowthWeeklyData = [];
        for ($w = 7; $w >= 0; $w--) {
            $wStart = $now->copy()->subWeeks($w)->startOfWeek();
            $wEnd = $now->copy()->subWeeks($w)->endOfWeek();
            $userGrowthWeeklyLabels[] = 'Mgg ' . $wStart->format('d/m');
            $userGrowthWeeklyData[] = User::whereBetween('created_at', [$wStart, $wEnd])->count();
        }

        // B. Tren Aktivitas Transaksi (6 Bulan Terakhir & 30 Hari Terakhir)
        $txTrendMonthlyLabels = [];
        $txTrendMonthlyIncomeData = [];
        $txTrendMonthlyExpenseData = [];
        for ($i = 5; $i >= 0; $i--) {
            $mStart = $now->copy()->subMonths($i)->startOfMonth()->toDateString();
            $mEnd = $now->copy()->subMonths($i)->endOfMonth()->toDateString();
            $txTrendMonthlyLabels[] = $now->copy()->subMonths($i)->isoFormat('MMM Y');

            $txTrendMonthlyIncomeData[] = Transaction::where('type', 'income')
                ->whereBetween('transaction_date', [$mStart, $mEnd])
                ->count();

            $txTrendMonthlyExpenseData[] = Transaction::where('type', 'expense')
                ->whereBetween('transaction_date', [$mStart, $mEnd])
                ->count();
        }

        $txTrendDailyLabels = [];
        $txTrendDailyData = [];
        for ($d = 29; $d >= 0; $d--) {
            $day = $now->copy()->subDays($d)->toDateString();
            $txTrendDailyLabels[] = $now->copy()->subDays($d)->format('d M');
            $txTrendDailyData[] = Transaction::whereDate('transaction_date', $day)->count();
        }

        // C. Kategori Terpopuler (paling sering dipakai oleh user)
        $popularCategories = DB::table('transactions')
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->select(
                'categories.name',
                'categories.type',
                DB::raw('max(categories.color) as color'),
                DB::raw('max(categories.icon) as icon'),
                DB::raw('count(transactions.id) as total_usage'),
                DB::raw('sum(transactions.amount) as total_amount')
            )
            ->groupBy('categories.name', 'categories.type')
            ->orderByDesc('total_usage')
            ->limit(6)
            ->get();

        $totalCategorizedCount = max(1, $totalTransactions);
        $popularCategories = $popularCategories->map(function ($cat) use ($totalCategorizedCount) {
            $cat->percentage = round(($cat->total_usage / $totalCategorizedCount) * 100, 1);
            return $cat;
        });

        // =========================================================================
        // 3. MANAJEMEN PENGGUNA (USER MANAGEMENT)
        // =========================================================================
        $usersQuery = User::withCount('transactions')
            ->withSum(['transactions as total_expense' => function ($query) {
                $query->where('type', 'expense');
            }], 'amount')
            ->withSum(['transactions as total_income' => function ($query) {
                $query->where('type', 'income');
            }], 'amount');

        if ($request->filled('search')) {
            $search = trim($request->search);
            $usersQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role') && in_array($request->role, ['user', 'admin'], true)) {
            $usersQuery->where('role', $request->role);
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $usersQuery->where('is_active', true);
            } elseif ($request->status === 'suspended') {
                $usersQuery->where('is_active', false);
            }
        }

        $users = $usersQuery->latest()->paginate(10, ['*'], 'users_page')->withQueryString();

        // =========================================================================
        // 4. MASTER KATEGORI DEFAULT (TEMPLATE KATEGORI)
        // =========================================================================
        $defaultIncomeCategories = DefaultCategory::income()->orderBy('name')->get();
        $defaultExpenseCategories = DefaultCategory::expense()->orderBy('name')->get();

        // =========================================================================
        // 5. MONITORING AI CHATBOT ("CATA") & SISTEM
        // =========================================================================
        $aiStatus = $this->getAiConnectionStatus();
        $systemLogs = $this->getRecentLogs(20);
        $recentUsers = User::latest()->take(5)->get();
        $recentTransactions = Transaction::with(['user', 'category'])->latest('id')->take(5)->get();

        return view('admin.dashboard', [
            'admin' => $request->user(),

            // KPI
            'totalUsers' => $totalUsers,
            'newUsersThisMonth' => $newUsersThisMonth,
            'activeUsers7Days' => $activeUsers7Days,
            'activeUsers30Days' => $activeUsers30Days,
            'totalTransactions' => $totalTransactions,
            'incomeTransactionsCount' => $incomeTransactionsCount,
            'expenseTransactionsCount' => $expenseTransactionsCount,
            'storageStats' => $storageStats,

            // Charts
            'userGrowthMonthlyLabels' => $userGrowthMonthlyLabels,
            'userGrowthMonthlyData' => $userGrowthMonthlyData,
            'userGrowthWeeklyLabels' => $userGrowthWeeklyLabels,
            'userGrowthWeeklyData' => $userGrowthWeeklyData,
            'txTrendMonthlyLabels' => $txTrendMonthlyLabels,
            'txTrendMonthlyIncomeData' => $txTrendMonthlyIncomeData,
            'txTrendMonthlyExpenseData' => $txTrendMonthlyExpenseData,
            'txTrendDailyLabels' => $txTrendDailyLabels,
            'txTrendDailyData' => $txTrendDailyData,
            'popularCategories' => $popularCategories,

            // User Management
            'users' => $users,

            // Master Kategori Default
            'defaultIncomeCategories' => $defaultIncomeCategories,
            'defaultExpenseCategories' => $defaultExpenseCategories,

            // Monitoring & Logs
            'aiStatus' => $aiStatus,
            'systemLogs' => $systemLogs,
            'recentUsers' => $recentUsers,
            'recentTransactions' => $recentTransactions,
        ]);
    }

    /**
     * Endpoint API untuk mengecek koneksi live ke AI Chatbot "Cata".
     */
    public function checkAiStatus(): JsonResponse
    {
        $status = $this->getAiConnectionStatus();

        return response()->json($status);
    }

    /**
     * Membersihkan file log sistem (storage/logs/laravel.log).
     */
    public function clearLog(): RedirectResponse
    {
        $logPath = storage_path('logs/laravel.log');

        if (File::exists($logPath)) {
            File::put($logPath, '');
        }

        return back()->with('success', 'File log sistem berhasil dibersihkan.');
    }

    /**
     * Menghitung penggunaan storage foto bukti transaksi.
     *
     * @return array{bytes: int, formatted: string, count: int, max_bytes: int, percentage: float, directory: string}
     */
    private function calculateReceiptStorage(): array
    {
        $receiptDir = storage_path('app/public/receipts');
        $totalBytes = 0;
        $fileCount = 0;

        if (is_dir($receiptDir)) {
            $files = scandir($receiptDir);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..') {
                    $filePath = $receiptDir . DIRECTORY_SEPARATOR . $file;
                    if (is_file($filePath)) {
                        $totalBytes += filesize($filePath);
                        $fileCount++;
                    }
                }
            }
        }

        // Hitung juga jumlah data transaksi yang memiliki link receipt_path
        $dbReceiptsCount = Transaction::whereNotNull('receipt_path')->where('receipt_path', '!=', '')->count();
        $fileCount = max($fileCount, $dbReceiptsCount);

        // Batas kuota standar: 500 MB
        $maxBytes = 500 * 1024 * 1024;
        $percentage = min(100.0, round(($totalBytes / $maxBytes) * 100, 2));

        return [
            'bytes' => $totalBytes,
            'formatted' => $this->formatBytes($totalBytes),
            'count' => $fileCount,
            'max_bytes' => $maxBytes,
            'percentage' => $percentage,
            'directory' => 'storage/app/public/receipts',
        ];
    }

    /**
     * Menguji koneksi ke endpoint Griphub Router AI Chatbot.
     *
     * @return array{status: string, online: bool, message: string, latency_ms: ?int, model: string, base_url: string}
     */
    private function getAiConnectionStatus(): array
    {
        $apiKey = (string) config('services.griphub.api_key');
        $baseUrl = rtrim((string) config('services.griphub.base_url'), '/');
        $model = (string) config('services.griphub.model', 'deepseek-v4.1-flash');

        if ($apiKey === '') {
            return [
                'status' => 'unconfigured',
                'online' => false,
                'message' => 'API Key (GRIPHUB_API_KEY) belum dikonfigurasi.',
                'latency_ms' => null,
                'model' => $model,
                'base_url' => $baseUrl,
            ];
        }

        $startTime = microtime(true);
        try {
            $response = Http::withToken($apiKey)
                ->acceptJson()
                ->timeout(4)
                ->get($baseUrl . '/models');

            $latency = (int) round((microtime(true) - $startTime) * 1000);

            if ($response->successful()) {
                return [
                    'status' => 'online',
                    'online' => true,
                    'message' => 'Koneksi ke server AI berjalan normal & responsif.',
                    'latency_ms' => $latency,
                    'model' => $model,
                    'base_url' => $baseUrl,
                ];
            }

            return [
                'status' => 'error',
                'online' => false,
                'message' => 'Layanan AI merespons dengan HTTP ' . $response->status(),
                'latency_ms' => $latency,
                'model' => $model,
                'base_url' => $baseUrl,
            ];
        } catch (\Throwable $exception) {
            $latency = (int) round((microtime(true) - $startTime) * 1000);

            return [
                'status' => 'error',
                'online' => false,
                'message' => 'Gagal terhubung: ' . $exception->getMessage(),
                'latency_ms' => $latency,
                'model' => $model,
                'base_url' => $baseUrl,
            ];
        }
    }

    /**
     * Membaca entri log terbaru dari storage/logs/laravel.log.
     *
     * @return list<array{timestamp: string, level: string, message: string}>
     */
    private function getRecentLogs(int $limit = 20): array
    {
        $logPath = storage_path('logs/laravel.log');

        if (! file_exists($logPath) || ! is_readable($logPath)) {
            return [];
        }

        $fileSize = filesize($logPath);
        if ($fileSize === 0) {
            return [];
        }

        // Ambil maksimal 64KB terakhir agar tidak membebani memori
        $readLength = min($fileSize, 65536);
        $handle = fopen($logPath, 'r');
        if (! $handle) {
            return [];
        }

        fseek($handle, -$readLength, SEEK_END);
        $content = fread($handle, $readLength);
        fclose($handle);

        if ($content === false) {
            return [];
        }

        $lines = explode("\n", $content);
        $logs = [];

        foreach (array_reverse($lines) as $line) {
            $trimmed = trim($line);
            if ($trimmed === '') {
                continue;
            }

            if (preg_match('/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\] [a-zA-Z0-9_\-]+(?:\.([A-Z]+))?: (.*)$/', $trimmed, $matches)) {
                $logs[] = [
                    'timestamp' => $matches[1],
                    'level' => strtoupper($matches[2] ?? 'INFO'),
                    'message' => $matches[3],
                ];

                if (count($logs) >= $limit) {
                    break;
                }
            }
        }

        return $logs;
    }

    /**
     * Konversi ukuran bytes ke format yang mudah dibaca (KB, MB, GB).
     */
    private function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min((int) $pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
