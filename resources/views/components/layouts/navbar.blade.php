<nav
    class="navbar sticky top-0 m-0 p-0 w-full transition bg-white text-black shadow-vintage-brem overflow-hidden border-vintage dark:bg-vintage-brem duration-500 ease-in-out z-40 drop-shadow-md dark:shadow-light dark:text-white">
    <div class="max-w-screen-xl h-full flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
            <span
                class="flex items-center  self-center text-2xl text-vintage-dark font-semibold whitespace-nowrap dark:text-white">
                <img class="w-32 h-14 object-cover" src="{{ asset('favicon.ico') }}" alt="">
                <span class="-ml-3 hidden md:block uppercase font-bold">Basmallah <span
                        class="text-vintage-brem">Agency</span></span>
            </span>
        </a>
        @if (!Request::is('housing-partners/*/submission'))
            <button data-collapse-toggle="navbar-default" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:focus:ring-gray-600"
                aria-controls="navbar-default" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
            <div class="hidden w-full md:block md:w-auto" id="navbar-default">
                <ul
                    class="font-medium flex flex-col md:items-center p-4 md:p-0 md:ps-3 border transition ease-in-out rounded-lg md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:dark:bg-vintage-brem dark:border-vintage-brem">
                    <li>
                        <a href="#"
                            class="block py-auto px-3 text-vintage-brem bg-vintage-light rounded-sm md:bg-transparent hover:text-vintage-dark md:p-0 dark:text-white md:dark:text-white dark:hover:text-vintage-dark">Home</a>
                    </li>
                    <li>
                        <a href="#about"
                            class="block py-auto px-3 text-vintage-brem bg-vintage-light rounded-sm md:bg-transparent md:p-0 dark:text-white md:dark:text-white hover:text-vintage-dark dark:hover:text-vintage-dark">Tentang
                            Kami</a>
                    </li>
                    <li>
                        <a href="#house-list"
                            class="block py-auto px-3 text-vintage-brem bg-vintage-light rounded-sm md:bg-transparent md:p-0 dark:text-white md:dark:text-white hover:text-vintage-dark dark:hover:text-vintage-dark">List
                            Perumahan</a>
                    </li>
                    <li>
                        <a href="#faq"
                            class="block py-auto px-3 text-vintage-brem bg-vintage-light rounded-sm md:bg-transparent md:p-0 dark:text-white md:dark:text-white hover:text-vintage-dark dark:hover:text-vintage-dark">
                            FAQ</a>
                    </li>
                </ul>
            </div>
        @endif
    </div>
</nav>
