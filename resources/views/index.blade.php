@extends('components.layouts.landingpage')

@section('title', 'Basmallah Agency')

@section('description', 'Basmallah Agency merupakan Agen Properti yang sudah berjalan lama')

@section('content')
    <section id="container" class="transition bg-cover ease-in-out bg-center bg-no-repeat bg-vintage-brem bg-blend-multiply"
        style="background-image: url('{{ $heroImage }}')">
        <div class="px-4 mx-auto max-w-screen-xl text-center py-24 lg:py-56">
            <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-white md:text-5xl lg:text-6xl">
                Basmallah Agency
            </h1>
            <p class="mb-8 text-md font-normal text-gray-300 lg:text-xl sm:px-16 lg:px-48">
                Sejak tahun 2025, Basmallah Agency berdedikasi untuk berkolaborasi dengan proyek perumahan subsidi yang
                berdampak tinggi di lokasi paling strategis di Malang Raya. Kami menyediakan hunian yang nyaman dengan harga
                terjangkau. Bersama kami, dapatkan hunian impian anda dengan mudah!
            </p>
            <div class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0">
                <a href="#house-list"
                    class="text-vintage-dark bg-vintage-light focus:ring-4 focus:ring-vintage-brem font-medium rounded-lg text-sm px-6 py-3.5 dark:bg-vintage-cream dark:hover:bg-vintage-light focus:outline-none dark:focus:ring-vintage-light dark:text-black">
                    Daftar
                </a>
                <a href="#faq"
                    class="inline-flex justify-center hover:text-gray-900 items-center py-3 px-5 sm:ms-4 text-sm font-medium text-center text-white rounded-lg border border-white hover:bg-gray-100 focus:ring-4 focus:ring-gray-400">
                    FAQ
                </a>
            </div>
        </div>
    </section>
    {{-- <svg xmlns="http://www.w3.org/2000/svg" class="dark:hidden" viewBox="0 0 1440 320">
        <path fill="#E0CCBE" fill-opacity="1"
            d="M0,160L60,176C120,192,240,224,360,202.7C480,181,600,107,720,101.3C840,96,960,160,1080,197.3C1200,235,1320,245,1380,250.7L1440,256L1440,0L1380,0C1320,0,1200,0,1080,0C960,0,840,0,720,0C600,0,480,0,360,0C240,0,120,0,60,0L0,0Z">
        </path>
    </svg> --}}
    <svg xmlns="http://www.w3.org/2000/svg" class="" viewBox="0 0 1440 320">
        <path fill="#747264" fill-opacity="1"
            d="M0,160L60,176C120,192,240,224,360,202.7C480,181,600,107,720,101.3C840,96,960,160,1080,197.3C1200,235,1320,245,1380,250.7L1440,256L1440,0L1380,0C1320,0,1200,0,1080,0C960,0,840,0,720,0C600,0,480,0,360,0C240,0,120,0,60,0L0,0Z">
        </path>
    </svg>

    <section id="about" class="py-8 antialiased md:py-16">
        <div class="mx-auto grid max-w-screen-xl px-4 pb-8 md:grid-cols-12 lg:gap-12 lg:pb-16 xl:gap-0">
            <div class="content-center justify-self-start md:col-span-7 md:text-start">
                <h1
                    class="mb-4 text-4xl font-extrabold leading-none text-black tracking-tight dark:text-white md:max-w-2xl md:text-5xl xl:text-6xl">
                    Kenapa Pilih<br />
                    <span class="text-vintage-dark">
                        Basmallah Agency?
                    </span>

                </h1>
                <p class="mb-4 max-w-2xl text-black dark:text-gray-400 md:mb-12 md:text-lg mb-3 lg:mb-5 lg:text-xl">
                    Basmallah Agency merupakan salah satu agency perperti yang berkerjasama dengan perusahaan real estate
                    dan developer terkemuka dan terpercaya di malang raya serta dikenal luas secara regional.

                </p>
            </div>
            <div class="hidden md:col-span-5 md:mt-0 md:flex">
                <img class="dark:hidden" src="{{ asset('Hero Images.png') }}" alt="shopping illustration" />
            </div>
        </div>
        <div class="grid gap-3">
            <h1 class="text-vintage-dark dark:text-white text-center text-2xl font-bold">Partner Kami</h1>
            <div
                class="mx-auto grid max-w-screen-xl grid-cols-{{ $housingPartnersTotal }} gap-8 text-gray-500 dark:text-gray-400 sm:grid-cols-{{ $housingPartnersTotal }} sm:gap-12 lg:grid-cols-{{ $housingPartnersTotal }} px-4">
                @foreach ($housingPartners as $partner)
                    <a href="#" class="flex items-center md:justify-center">
                        <h1
                            class="h-6 text-vintage-brem hover:text-vintage-dark dark:hover:text-white font-bold text-sm md:text-3xl">
                            {{ $partner }}
                        </h1>
                    </a>
                @endforeach
            </div>
        </div>

    </section>

    {{-- <section
        class="bg-center bg-no-repeat bg-[url('https://images.pexels.com/photos/396303/pexels-photo-396303.jpeg?auto=compress&cs=tinysrgb&dpr=1')] bg-gray-700 bg-blend-multiply">
        <div class="flex flex-col flex-col-reverse md:flex-row justify-between items-center container mx-auto">
            <div class="max-w-screen-xl text-center py-24 lg:py-56">
                <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-white md:text-5xl lg:text-6xl">
                    Kenapa Pilih Basmallah Agency?
                </h1>
                <p class="mb-8 text-lg font-normal text-gray-300 lg:text-xl">
                    Basmallah Agency siap membantu menemukan rumah impian anda dengan DP 0%
                </p>
            </div>

            <div class="max-w-screen-xl text-center ">
                <img src="{{ asset('promo-icon.svg') }}" class="h-full w-full mx-auto md:scale-125" alt="Promo Icon 1">
            </div>
        </div>

    </section> --}}
    {{-- <section class="flex flex-col dark:hidden">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#E0CCBE" fill-opacity="1"
                d="M0,160L60,176C120,192,240,224,360,202.7C480,181,600,107,720,101.3C840,96,960,160,1080,197.3C1200,235,1320,245,1380,250.7L1440,256L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z">
            </path>
        </svg>

        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#E0CCBE" fill-opacity="1"
                d="M0,160L60,176C120,192,240,224,360,202.7C480,181,600,107,720,101.3C840,96,960,160,1080,197.3C1200,235,1320,245,1380,250.7L1440,256L1440,0L1380,0C1320,0,1200,0,1080,0C960,0,840,0,720,0C600,0,480,0,360,0C240,0,120,0,60,0L0,0Z">
            </path>
        </svg>
    </section> --}}



    <section id="house-list" class="bg-vintage-light">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#3C3633" fill-opacity="1"
                d="M0,160L60,176C120,192,240,224,360,202.7C480,181,600,107,720,101.3C840,96,960,160,1080,197.3C1200,235,1320,245,1380,250.7L1440,256L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z">
            </path>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" class="-mt-1" viewBox="0 0 1440 320">
            <path fill="#3C3633" fill-opacity="1"
                d="M0,160L60,176C120,192,240,224,360,202.7C480,181,600,107,720,101.3C840,96,960,160,1080,197.3C1200,235,1320,245,1380,250.7L1440,256L1440,0L1380,0C1320,0,1200,0,1080,0C960,0,840,0,720,0C600,0,480,0,360,0C240,0,120,0,60,0L0,0Z">
            </path>
        </svg>
        <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 ">
            <div class="mx-auto max-w-screen-sm text-center mb-8 lg:mb-16">
                <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-vintage-dark dark:text-white">List Perumahan
                </h2>
                <p class="font-light text-vintage-dark lg:mb-16 sm:text-xl dark:text-gray-400">
                    Pilih rumah favorit Anda dan lakukan submission untuk berkesempatan mendapatkan rumah impian Anda!
                </p>
            </div>
            <div class="grid gap-8 mb-6 lg:mb-16 md:grid-cols-2">
                @foreach ($houseLists as $house)
                    <article
                        class="flex flex-col md:flex-row border border-vintage-brem border-rounded drop-shadow-xl shadow-vintage-brem grid-rows-4 items-stretch bg-white rounded-lg">
                        <div class="relative">
                            <img class="w-full md:max-w-64 h-[200px] object-center md:h-md md:rounded-lg sm:rounded-none rounded-t-lg md:rounded-b-md  object-cover"
                                src="{{ asset("storage/$house->image_url") }}" alt="Bonnie Avatar">
                        </div>
                        <div class="">
                            <div class="px-3 flex flex-col gap-3 self-stretch h-full">
                                <h3 class="text-xl font-bold">
                                    <h1 class="font-bold text-lg text-vintage-dark dark:text-white md:text-2xl">
                                        {{ $house->name }}
                                    </h1>
                                </h3>
                                <div class="grid">
                                    <div class="inline-flex items-center">
                                        <span
                                            class="text-white bg-vintage-dark border border-vintage-dark font-medium px-2.5 py-0.5 dark:bg-green-900 dark:text-green-300">DP
                                            {{ $house->down_payment }}%</span>
                                        <p
                                            class="font-light bg-white text-vintage-dark border border-vintage-dark px-2.5 py-0.5 dark:text-white">
                                            Tersisa <span class="font-semibold">
                                                {{ \Number::format($house->available, locale: 'id') }}</span>
                                        </p>
                                    </div>
                                    <p class="font-light text-black dark:text-white mb-5">
                                        Booking Fee <span class="font-semibold">Rp.
                                            {{ \Number::format($house->booking_fee, locale: 'id') }}</span>
                                    </p>
                                </div>



                                <div class="mt-auto mb-5">
                                    <a href="/housing-partners/{{ $house->id }}/submission"
                                        class="border-2 font-bold text-vintage-dark hover:bg-vintage-dark hover:text-white border px-3 py-2 border-vintage-dark bg-transparent">
                                        Daftar Sekarang
                                    </a>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
                {{-- @foreach ($houseLists as $house)
                    <article
                        class="grid grid-flow-col grid-rows-3 relative border border-vintage-cream bg-vintage-light rounded-lg">
                        <div class="relative row-span-3">
                            <img class="w-full h-[200px] object-center md:w-56 md:h-md rounded-lg sm:rounded-none sm:rounded-l-lg  object-cover"
                                src="{{ asset("storage/$house->image_url") }}" alt="Bonnie Avatar">
                        </div>
                        <div class="p-3 col-span-2 flex flex-col md:h-full">
                            <div class="">
                                <h3 class="text-xl font-bold">
                                    <h1 class="font-bold text-lg text-vintage-dark dark:text-white md:text-2xl">
                                        {{ $house->name }}
                                    </h1>
                                </h3>
                                <span
                                    class="bg-vintage-dark text-white text-sm font-medium me-2 mt-3 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">DP
                                    {{ $house->down_payment }}%</span>
                                <p class="mt-3 mb-4 font-light text-vintage-dark dark:text-white">
                                    Booking Fee : <span class="font-semibold">Rp.
                                        {{ \Number::format($house->booking_fee, locale: 'id') }}</span>
                                </p>
                            </div>
                            <div class="mt-auto">
                                <a href="/housing-partners/{{ $house->id }}/submission" type="button"
                                    class="text-white bg-vintage-dark hover:bg-vintage-dark focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-vintage-cream dark:text-black dark:hover:bg-vintage-light dark:focus:ring-vintage-brem">
                                    Daftar
                                    <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div
                            class="col-span-2 row-span-2 flex justify-between bg-vintage-dark text-white rounded-lg bottom-0 inset-x-0 text-lg font-medium px-2.5 py-0.5 rounded-sm dark:bg-vintage-cream dark:text-black ">
                            Tersisa
                            <span class="text-end">{{ \Number::format($house->available, locale: 'id') }}</span>
                        </div>
                    </article>
                @endforeach --}}
            </div>
        </div>
    </section>


    <section id="faq" class=" antialiased bg-vintage-brem">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#EEEDEB" fill-opacity="1"
                d="M0,256L40,229.3C80,203,160,149,240,144C320,139,400,181,480,208C560,235,640,245,720,234.7C800,224,880,192,960,192C1040,192,1120,224,1200,229.3C1280,235,1360,213,1400,202.7L1440,192L1440,0L1400,0C1360,0,1280,0,1200,0C1120,0,1040,0,960,0C880,0,800,0,720,0C640,0,560,0,480,0C400,0,320,0,240,0C160,0,80,0,40,0L0,0Z">
            </path>
        </svg>

        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
            <div class="lg:flex lg:items-center lg:justify-between lg:gap-4">
                <h2 class="mb-4 text-lg md:text-4xl tracking-tight font-extrabold text-white dark:text-white">
                    Frequently
                    Ask &
                    Question</h2>
            </div>

            <div class="mt-6 flow-root">
                <div id="content-faq" class="-my-6 divide-y divide-white dark:divide-gray-800">
                    @foreach ($faqs->items() as $faq)
                        <div class="space-y-4 py-6 md:py-8">
                            <div class="grid gap-4">
                                <span class="text-xl font-semibold text-white dark:text-white">
                                    “{{ $faq->ask_question }}”</span>
                            </div>
                            <div class="text-base font-normal text-white dark:text-gray-400">
                                {!! $faq->answer !!}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            @if ($faqs->hasMorePages())
                <div id="{{ $faqs->nextCursor()->encode() }}"
                    class="next-button mt-6 flex items-center justify-center lg:justify-start">
                    <button id="btn-next-button" type="button"
                        class="w-full rounded-lg  bg-white px-5 py-2.5 text-sm font-medium text-vintage-dark sm:w-auto">
                        Lihat Banyak
                    </button>
                </div>
            @endif

        </div>
        <footer class="mt-4 bg-vintage-dark">
            <div class="w-full max-w-screen-xl mx-3 md:mx-auto md:py-8">
                <div class="sm:flex sm:items-center sm:justify-between">
                    <a href="https://flowbite.com/" class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
                        <span
                            class="self-center uppercase text-white text-2xl font-bold whitespace-nowrap dark:text-white">Basmallah
                            Agency</span>
                    </a>
                    <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-white sm:mb-0 dark:text-gray-400">
                        <li>
                            <a href="#" class="hover:underline me-4 md:me-6">basmallahagency@gmail.com</a>
                        </li>
                        <li>
                            <a href="#" class="hover:underline me-4 md:me-6">082341312321</a>
                        </li>
                    </ul>
                </div>
                <hr class="my-6 border-white sm:mx-auto dark:border-gray-700 lg:my-8" />
                <span class="block text-sm text-white sm:text-center dark:text-gray-400">©
                    {{ \Carbon\Carbon::now()->format('Y') }} <a href="https://flowbite.com/"
                        class="hover:underline">Lastation™</a>. All Rights Reserved.</span>
            </div>
        </footer>
    </section>




@endsection
