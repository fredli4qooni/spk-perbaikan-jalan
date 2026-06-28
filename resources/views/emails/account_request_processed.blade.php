@if($approved)
<p>Halo {{ $request->name }},</p>
<p>Permohonan pembuatan akun Anda telah <strong>disetujui</strong> oleh admin.</p>
<p>Berikut informasi akun sementara Anda:</p>
<ul>
    <li>Email: {{ $request->email }}</li>
    <li>Role: {{ $request->requested_role }}</li>
    @if($password)
        <li>Password sementara: <strong>{{ $password }}</strong></li>
    @endif
</ul>
<p>Silakan login dan segera ubah password Anda.</p>
@else
<p>Halo {{ $request->name }},</p>
<p>Permohonan pembuatan akun Anda telah <strong>ditolak</strong> oleh admin.</p>
<p>Jika Anda mempunyai pertanyaan, silakan hubungi pihak admin.</p>
@endif

<p>Terima kasih.</p>
