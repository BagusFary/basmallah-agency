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


      <footer class="bg-white rounded-lg shadow-sm dark:bg-gray-900 m-4">
        <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
            <div class="sm:flex sm:items-center sm:justify-between">
                <a href="https://flowbite.com/" class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
                    <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Basmallah
                        Agency</span>
                </a>
                <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0 dark:text-gray-400">
                    <li>
                        <a href="#" class="hover:underline me-4 md:me-6">basmallahagency@gmail.com</a>
                    </li>
                    <li>
                        <a href="#" class="hover:underline me-4 md:me-6">082341312321</a>
                    </li>
                </ul>
            </div>
            <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
            <span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">©
                {{ \Carbon\Carbon::now()->format('Y') }} <a href="https://flowbite.com/"
                    class="hover:underline">Lastation™</a>. All Rights Reserved.</span>
        </div>
    </footer>


    @endsection

    
    @push('scripts')
        <script src="{{ asset('js/submission.js') }}"></script>
    @endpush