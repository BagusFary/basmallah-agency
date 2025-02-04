@extends('components.layouts.landingpage')

@section('title', 'Basmallah Agency')

@section('description', 'Basmallah Agency merupakan Agen Properti yang sudah berjalan lama')


    
@section('content')
    @extends('components.layouts.navbar')

    <section id="container"
        class="bg-center bg-no-repeat bg-[url('{{ 'https://images.pexels.com/photos/396303/pexels-photo-396303.jpeg?auto=compress&cs=tinysrgb&dpr=1' }}')] bg-gray-700 bg-blend-multiply">
        <div class="px-4 mx-auto max-w-screen-xl text-center py-24 lg:py-56">
            <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-white md:text-5xl lg:text-6xl">
                Basmallah Agency
            </h1>
            <p class="mb-8 text-lg font-normal text-gray-300 lg:text-xl sm:px-16 lg:px-48">
                Basmallah Agency siap membantu menemukan rumah impian anda dengan DP 0%
            </p>
            <div class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0">
                <a href="#house-list"
                    class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
                    Daftar
                </a>
                <a href="#faq"
                    class="inline-flex justify-center hover:text-gray-900 items-center py-3 px-5 sm:ms-4 text-base font-medium text-center text-white rounded-lg border border-white hover:bg-gray-100 focus:ring-4 focus:ring-gray-400">
                    FAQ
                </a>
            </div>
        </div>
    </section>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#2072c9" fill-opacity="1"
            d="M0,192L30,176C60,160,120,128,180,101.3C240,75,300,53,360,74.7C420,96,480,160,540,160C600,160,660,96,720,90.7C780,85,840,139,900,170.7C960,203,1020,213,1080,202.7C1140,192,1200,160,1260,160C1320,160,1380,192,1410,208L1440,224L1440,0L1410,0C1380,0,1320,0,1260,0C1200,0,1140,0,1080,0C1020,0,960,0,900,0C840,0,780,0,720,0C660,0,600,0,540,0C480,0,420,0,360,0C300,0,240,0,180,0C120,0,60,0,30,0L0,0Z">
        </path>
    </svg>

    <section id="about" class="bg-white py-8 antialiased dark:bg-gray-900 md:py-16">
        <div class="mx-auto grid max-w-screen-xl px-4 pb-8 md:grid-cols-12 lg:gap-12 lg:pb-16 xl:gap-0">
            <div class="content-center justify-self-start md:col-span-7 md:text-start">
                <h1
                    class="mb-4 text-4xl font-extrabold leading-none tracking-tight dark:text-white md:max-w-2xl md:text-5xl xl:text-6xl">
                    Kenapa Pilih<br />Basmallah Agency?</h1>
                <p class="mb-4 max-w-2xl text-gray-500 dark:text-gray-400 md:mb-12 md:text-lg mb-3 lg:mb-5 lg:text-xl">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam tempore commodi exercitationem a
                    suscipit aspernatur reprehenderit ab cumque? Omnis consequuntur, quis dolorem, eligendi quam aliquid non
                    placeat dolor ipsa molestias sunt architecto, qui numquam necessitatibus! Tempore reprehenderit omnis
                    provident ex.
                </p>
            </div>
            <div class="hidden md:col-span-5 md:mt-0 md:flex">
                <img class="dark:hidden" src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/girl-shopping-list.svg"
                    alt="shopping illustration" />
                <img class="hidden dark:block"
                    src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/girl-shopping-list-dark.svg"
                    alt="shopping illustration" />
            </div>
        </div>
        <div class="grid gap-3">
            <h1 class="text-gray text-center text-2xl font-bold">Partner Kami</h1>
            <div
                class="mx-auto grid max-w-screen-xl grid-cols-2 gap-8 text-gray-500 dark:text-gray-400 sm:grid-cols-3 sm:gap-12 lg:grid-cols-3 px-4">
                <a href="#" class="flex items-center md:justify-center">
                    <h1 class="h-6 hover:text-gray-900 dark:hover:text-white font-bold text-sm md:text-3xl">Grand Permata Turian</h1>
                </a>
                <a href="#" class="flex items-center md:justify-center">
                    <h1 class="h-6 hover:text-gray-900 dark:hover:text-white font-bold text-sm md:text-3xl">D'Permata Taruna Villa</h1>
                </a>
                <a href="#" class="flex items-center md:justify-center">
                    <h1 class="h-6 hover:text-gray-900 dark:hover:text-white font-bold text-sm md:text-3xl">The Wisdom Wagir</h1>
                </a>
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

    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#2072c9" fill-opacity="1"
            d="M0,160L40,170.7C80,181,160,203,240,224C320,245,400,267,480,234.7C560,203,640,117,720,106.7C800,96,880,160,960,208C1040,256,1120,288,1200,282.7C1280,277,1360,235,1400,213.3L1440,192L1440,320L1400,320C1360,320,1280,320,1200,320C1120,320,1040,320,960,320C880,320,800,320,720,320C640,320,560,320,480,320C400,320,320,320,240,320C160,320,80,320,40,320L0,320Z">
        </path>
    </svg>

    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#2072c9" fill-opacity="1"
            d="M0,160L40,170.7C80,181,160,203,240,224C320,245,400,267,480,234.7C560,203,640,117,720,106.7C800,96,880,160,960,208C1040,256,1120,288,1200,282.7C1280,277,1360,235,1400,213.3L1440,192L1440,0L1400,0C1360,0,1280,0,1200,0C1120,0,1040,0,960,0C880,0,800,0,720,0C640,0,560,0,480,0C400,0,320,0,240,0C160,0,80,0,40,0L0,0Z">
        </path>
    </svg>

    <section id="house-list" class="bg-whie dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6 ">
            <div class="mx-auto max-w-screen-sm text-center mb-8 lg:mb-16">
                <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">List Perumahan</h2>
                <p class="font-light text-gray-500 lg:mb-16 sm:text-xl dark:text-gray-400">
                    Pilih rumah favorit Anda dan lakukan submission untuk berkesempatan mendapatkan rumah impian Anda!
                </p>
            </div>
            <div class="grid gap-8 mb-6 lg:mb-16 md:grid-cols-2">
                <div class="items-center bg-gray-50 rounded-lg shadow sm:flex dark:bg-gray-800 dark:border-gray-700">
                    <div class="relative">
                        <span
                            class="absolute mt-3 bg-blue-100 text-blue-800 text-lg font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-blue-900 dark:text-blue-300">Tersisa
                            500</span>
                        <img class="w-full rounded-lg sm:rounded-none sm:rounded-l-lg"
                            src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/bonnie-green.png"
                            alt="Bonnie Avatar">
                    </div>
                    <div class="p-5">
                        <h3 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                            <a href="#">The Wisdom Wangir</a>
                        </h3>
                        <span class="text-gray-500 dark:text-gray-400">DP 0%</span>
                        <p class="mt-3 mb-4 font-light text-gray-500 dark:text-gray-400">
                            Booking Fee : <span class="font-semibold">Rp. 300.000</span>
                        </p>
                        <button type="button"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Daftar
                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg>
                        </button>

                    </div>
                </div>
                <div class="items-center bg-gray-50 rounded-lg shadow sm:flex dark:bg-gray-800 dark:border-gray-700">
                    <div class="relative">
                        <span
                            class="absolute mt-3 bg-blue-100 text-blue-800 text-lg font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-blue-900 dark:text-blue-300">Tersisa
                            500</span>
                        <img class="w-full rounded-lg sm:rounded-none sm:rounded-l-lg"
                            src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/bonnie-green.png"
                            alt="Bonnie Avatar">
                    </div>
                    <div class="p-5">
                        <h3 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                            <a href="#">The Wisdom Wangir</a>
                        </h3>
                        <span class="text-gray-500 dark:text-gray-400">DP 0%</span>
                        <p class="mt-3 mb-4 font-light text-gray-500 dark:text-gray-400">
                            Booking Fee : <span class="font-semibold">Rp. 300.000</span>
                        </p>
                        <button type="button"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Daftar
                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg>
                        </button>

                    </div>
                </div>
                <div class="items-center bg-gray-50 rounded-lg shadow sm:flex dark:bg-gray-800 dark:border-gray-700">
                    <div class="relative">
                        <span
                            class="absolute mt-3 bg-blue-100 text-blue-800 text-lg font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-blue-900 dark:text-blue-300">Tersisa
                            500</span>
                        <img class="w-full rounded-lg sm:rounded-none sm:rounded-l-lg"
                            src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/bonnie-green.png"
                            alt="Bonnie Avatar">
                    </div>
                    <div class="p-5">
                        <h3 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                            <a href="#">The Wisdom Wangir</a>
                        </h3>
                        <span class="text-gray-500 dark:text-gray-400">DP 0%</span>
                        <p class="mt-3 mb-4 font-light text-gray-500 dark:text-gray-400">
                            Booking Fee : <span class="font-semibold">Rp. 300.000</span>
                        </p>
                        <button type="button"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Daftar
                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg>
                        </button>

                    </div>
                </div>
                <div class="items-center bg-gray-50 rounded-lg shadow sm:flex dark:bg-gray-800 dark:border-gray-700">
                    <div class="relative">
                        <span
                            class="absolute mt-3 bg-blue-100 text-blue-800 text-lg font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-blue-900 dark:text-blue-300">Tersisa
                            500</span>
                        <img class="w-full rounded-lg sm:rounded-none sm:rounded-l-lg"
                            src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/bonnie-green.png"
                            alt="Bonnie Avatar">
                    </div>
                    <div class="p-5">
                        <h3 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                            <span href="#">The Wisdom Wangir</span>
                        </h3>
                        <span class="text-gray-500 dark:text-gray-400">DP 0%</span>
                        <p class="mt-3 mb-4 font-light text-gray-500 dark:text-gray-400">
                            Booking Fee : <span class="font-semibold">Rp. 300.000</span>
                        </p>
                        <button type="button"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Daftar
                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg>
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="faq" class="bg-white py-8 antialiased dark:bg-gray-900 md:py-16">
        <div class="mx-auto max-w-screen-lg px-4 2xl:px-0">
            <div class="lg:flex lg:items-center lg:justify-between lg:gap-4">
                <h2 class="shrink-0 text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Frequently Ask &
                    Question</h2>
            </div>

            <div class="mt-6 flow-root">
                <div class="-my-6 divide-y divide-gray-200 dark:divide-gray-800">
                    <div class="space-y-4 py-6 md:py-8">
                        <div class="grid gap-4">
                            <a href="#"
                                class="text-xl font-semibold text-gray-900 hover:underline dark:text-white">“The specs say
                                this model has 2 USB ports. The one I received has none. Are they hidden somewhere?”</a>
                        </div>
                        <p class="text-base font-normal text-gray-500 dark:text-gray-400">It’s a USB-C port it’s a smaller
                            port. Not the regular size USB port. See the picture below. It fits the newer Apple chargers.
                        </p>
                    </div>
                    <div class="space-y-4 py-6 md:py-8">
                        <div class="grid gap-4">
                            <a href="#"
                                class="text-xl font-semibold text-gray-900 hover:underline dark:text-white">“The specs say
                                this model has 2 USB ports. The one I received has none. Are they hidden somewhere?”</a>
                        </div>
                        <p class="text-base font-normal text-gray-500 dark:text-gray-400">It’s a USB-C port it’s a smaller
                            port. Not the regular size USB port. See the picture below. It fits the newer Apple chargers.
                        </p>
                    </div>
                    <div class="space-y-4 py-6 md:py-8">
                        <div class="grid gap-4">
                            <a href="#"
                                class="text-xl font-semibold text-gray-900 hover:underline dark:text-white">“The specs say
                                this model has 2 USB ports. The one I received has none. Are they hidden somewhere?”</a>
                        </div>
                        <p class="text-base font-normal text-gray-500 dark:text-gray-400">It’s a USB-C port it’s a smaller
                            port. Not the regular size USB port. See the picture below. It fits the newer Apple chargers.
                        </p>
                    </div>
                    <div class="space-y-4 py-6 md:py-8">
                        <div class="grid gap-4">
                            <a href="#"
                                class="text-xl font-semibold text-gray-900 hover:underline dark:text-white">“The specs say
                                this model has 2 USB ports. The one I received has none. Are they hidden somewhere?”</a>
                        </div>
                        <p class="text-base font-normal text-gray-500 dark:text-gray-400">It’s a USB-C port it’s a smaller
                            port. Not the regular size USB port. See the picture below. It fits the newer Apple chargers.
                        </p>
                    </div>
                    <div class="space-y-4 py-6 md:py-8">
                        <div class="grid gap-4">
                            <a href="#"
                                class="text-xl font-semibold text-gray-900 hover:underline dark:text-white">“The specs say
                                this model has 2 USB ports. The one I received has none. Are they hidden somewhere?”</a>
                        </div>
                        <p class="text-base font-normal text-gray-500 dark:text-gray-400">It’s a USB-C port it’s a smaller
                            port. Not the regular size USB port. See the picture below. It fits the newer Apple chargers.
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-center lg:justify-start">
                <button type="button"
                    class="w-full rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 sm:w-auto">View
                    more questions</button>
            </div>
        </div>
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
