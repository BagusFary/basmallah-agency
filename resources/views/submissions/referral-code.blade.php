@extends('components.layouts.landingpage')

@section('title', 'Basmallah Agency | Wisdom Wagir Kode Referral')

@section('description', 'Basmallah Agency merupakan Agen Properti yang sudah berjalan lama')

@section('content')
    @extends('components.layouts.navbar')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <section class="container mx-auto">
        <h1>Referral Code Page</h1>
    </section>

    @endsection


    @push('scripts')
        <script src="{{ asset('js/submission.js') }}"></script>
    @endpush
