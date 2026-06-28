<?php

namespace App\Http\Controllers;

use App\Models\AccountRequest;
use App\Models\User;
use App\Mail\AccountRequestProcessed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AccountRequestController extends Controller
{
    public function index()
    {
        abort_unless(Auth::user()?->role === 'admin', 403);

        $requests = AccountRequest::latest()->paginate(10);

        return view('account-requests.index', compact('requests'));
    }

    public function approve($id)
    {
        abort_unless(Auth::user()?->role === 'admin', 403);

        $req = AccountRequest::findOrFail($id);

        if ($req->status !== 'pending') {
            return redirect()->route('account-requests.index')->with('warning', 'Permohonan sudah diproses.');
        }

        $existing = User::where('email', $req->email)->first();
        $password = null;

        if ($existing) {
            $existing->update([
                'name' => $req->name,
                'role' => $req->requested_role ?? $existing->role,
            ]);
            $user = $existing;
        } else {
            $password = Str::random(10);
            $user = User::create([
                'name' => $req->name,
                'email' => $req->email,
                'password' => Hash::make($password),
                'role' => $req->requested_role ?? 'petugas',
            ]);
        }

        $req->status = 'approved';
        $req->processed_by = Auth::id();
        $req->processed_at = now();
        $req->processed_notes = $existing
            ? 'Approved and synced existing user id: ' . $user->id
            : 'Approved and created user id: ' . ($user->id ?? 'N/A');
        $req->processed_password = $password;
        $req->save();

        try {
            Mail::to($req->email)->send(new AccountRequestProcessed($req, $password, true));
        } catch (\Exception $e) {
            // ignore mail errors for local env
        }

        $message = 'Permohonan disetujui.';
        if ($password) {
            $message .= " Password sementara: $password";
        }

        return redirect()->route('account-requests.index')->with('success', $message);
    }

    public function deny($id)
    {
        abort_unless(Auth::user()?->role === 'admin', 403);

        $req = AccountRequest::findOrFail($id);

        if ($req->status !== 'pending') {
            return redirect()->route('account-requests.index')->with('warning', 'Permohonan sudah diproses.');
        }

        $req->status = 'denied';
        $req->processed_by = Auth::id();
        $req->processed_at = now();
        $req->processed_notes = 'Denied by admin';
        $req->processed_password = null;
        $req->save();

        try {
            Mail::to($req->email)->send(new AccountRequestProcessed($req, null, false));
        } catch (\Exception $e) {
            // ignore
        }

        return redirect()->route('account-requests.index')->with('success', 'Permohonan ditolak.');
    }

    public function resend($id)
    {
        abort_unless(Auth::user()?->role === 'admin', 403);

        $req = AccountRequest::findOrFail($id);

        if ($req->status !== 'approved') {
            return redirect()->route('account-requests.index')->with('warning', 'Hanya permohonan yang disetujui yang dapat dikirim ulang.');
        }

        try {
            Mail::to($req->email)->send(new AccountRequestProcessed($req, $req->processed_password, true));
        } catch (\Exception $e) {
            return redirect()->route('account-requests.index')->with('warning', 'Gagal mengirim email.');
        }

        return redirect()->route('account-requests.index')->with('success', 'Email kredensial telah dikirim ulang.');
    }
}