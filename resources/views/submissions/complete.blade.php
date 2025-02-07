@extends('components.layouts.landingpage')

@section('title', 'Basmallah Agency | Wisdom Wagir Kode Referral')

@section('description', 'Basmallah Agency merupakan Agen Properti yang sudah berjalan lama')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <section class="flex justify-center items-center  h-screen">
        <div class="border border-2 border-vintage-dark p-10 px-3 max-w-md mx-3 rounded rounded-lg bg-white">
            <div class="grid gap 5">
                <h1 class="text-2xl font-semibold">Submission Berhasil!</h1>
                <span>Selamat! Anda mendapatkan kode referral dari melakukan submission. Berikut adalah kode referral
                    anda.</span>
                <span onclick="clipboardClick()"
                    class="bg-vintage-brem cursor-pointer rounded tracking-wide p-3 text-white px-3 py-4 text-center">
                    <span id="code-referral-clipboard">{{ $referralCode ?? 'Kode Referral' }}</span>
                </span>
                <span id="clipboard-success" class="text-green-400 text-center hidden">Kode Berhasil Disalin!</span>
                <p class="text-sm font-tint">
                    Note : <br>Kode Referral akan dikirimkan melalui email.
                </p>
            </div>
            <div class="mt-5">
                <a href="/" class="bg-vintage-dark px-4 py-2 rounded text-white">Kembali</a>
            </div>
        </div>
    </section>

@endsection


@push('scripts')
    <script src="{{ asset('js/submission.js') }}"></script>
@endpush
