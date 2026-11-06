<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    /**
     * Mengaktifkan atau menonaktifkan (suspend/unban) akun pengguna.
     */
    public function toggleStatus(Request $request, User $user): RedirectResponse
    {
        if ($user->id === $request->user()->id) {
            return back()->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri!');
        }

        $newStatus = ! $user->isActive();
        $user->is_active = $newStatus;
        $user->save();

        $statusLabel = $newStatus ? 'diaktifkan kembali' : 'berhasil dinonaktifkan (disuspend)';

        return back()->with('success', "Akun pengguna {$user->name} {$statusLabel}.");
    }

    /**
     * Mengubah peran (role) pengguna antara 'user' dan 'admin'.
     */
    public function updateRole(Request $request, User $user): RedirectResponse
    {
        if ($user->id === $request->user()->id) {
            return back()->with('error', 'Anda tidak dapat mengubah role akun Anda sendiri!');
        }

        $validated = $request->validate([
            'role' => ['required', 'in:user,admin'],
        ]);

        $user->role = $validated['role'];
        $user->save();

        $roleLabel = $user->isAdmin() ? 'Administrator' : 'Pengguna Biasa (User)';

        return back()->with('success', "Peran akun {$user->name} berhasil diubah menjadi {$roleLabel}.");
    }

    /**
     * Menghapus akun pengguna secara permanen.
     */
    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($user->id === $request->user()->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        $userName = $user->name;
        $user->delete();

        return back()->with('success', "Akun pengguna {$userName} berhasil dihapus permanen dari sistem.");
    }
}

