@extends('components.layouts.landingpage')

@section('title', 'Basmallah Agency | Wisdom Wagir Submission')

@section('description', 'Basmallah Agency merupakan Agen Properti yang sudah berjalan lama')

@section('content')
    @extends('components.layouts.navbar')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <section class="container mx-auto">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto">
            <div class="w-full bg-white rounded-lg shadow dark:border dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <div class="flex-row self-start mb-3">
                        <a href="#" class="flex self-start mt-5 text-2xl font-semibold text-gray-900 dark:text-white">
                            Wisdom Wagir
                        </a>
                        <span class="flex self-start text-gray-400">Form Submission</span>
                    </div>
                    <form class="space-y-4 md:space-y-6" action="{{ route("housing-partners.store") }}" method="post">
                        @method('POST')
                        @csrf
                        <input type="hidden" name="id" value="{{ old('id') }}">
                        <input type="hidden" id="instalment_amount_data" name="instalment_amount_data" value="{{ old('instalment_amount_data') }}">
                        <input type="hidden" id="avg_monthly_turnover_data" name="avg_monthly_turnover_data" value="{{ old('avg_monthly_turnover_data') }}">
                        <input type="hidden" id="join_husband_data" name="join_husband_data" value="{{ old('join_husband_data') }}">
                        <input type="hidden" id="join_wife_data" name="join_wife_data" value="{{ old('join_wife_data') }}">
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email *</label>
                            <input type="email" name="email" id="email" value="{{ old("email") }}" class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukkan Email" autocomplete="off" required>
                            @error('email')
                                <div class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Warning, </span> {{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                            <input type="text" name="name" value="{{ old("name") }}" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukkan Nama Lengkap" autocomplete="off" required>
                            @error('name')
                                <div class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Warning, </span> {{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="id_card" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIK</label>
                            <input type="text" inputmode="numeric" name="id_card" id="id_card" value="{{ old("id_card") }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukkan NIK" autocomplete="off" required>
                            @error('id_card')
                                <div class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Warning, </span> {{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat</label>
                            <input type="text" name="address" id="address" value="{{ old("address") }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukkan Alamat" autocomplete="off" required>
                            @error('address')
                                <div class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Warning, </span> {{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomor WhatsApp</label>
                            <input type="text" inputmode="numeric" name="phone" id="phone" value="{{ old("phone") }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Contoh. 089*********" autocomplete="off" required>
                            @error('phone')
                                <div class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Warning, </span> {{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status Pekerjaan</label>
                            <div class="flex items-center my-2">
                                <input {{ old('employment_status', 'self_employees') == 'self_employees' ? 'checked' : '' }} id="self_employees" type="radio" value="self_employees" name="employment_status" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="self_employees" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Wirausaha</label>
                            </div>
                            <div class="flex items-center my-2">
                                <input {{ old('employment_status', 'false') == 'civil_servants' ? 'checked' : '' }} id="civil_servants" type="radio" value="civil_servants" name="employment_status" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="civil_servants" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">PNS</label>
                            </div>
                            <div class="flex items-center my-2">
                                <input {{ old('employment_status', 'false') == 'employee' ? 'checked' : '' }} id="employee" type="radio" value="employee" name="employment_status" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="employee" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Pegawai Swasta</label>
                            </div>
                        </div>
                        <div id="self_employee_as_section">
                            <label for="self_employee_as" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bidang Wirausaha</label>
                            <input type="text" name="self_employee_as" id="self_employee_as" value="{{ old("self_employee_as") }}"class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukkan Bidang Usaha" autocomplete="off" required>
                            @error('self_employee_as')
                                <div class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Warning, </span> {{ $message }}</div>
                            @enderror
                        </div>
                        <div id="avg_monthly_turnover_section">
                            <label for="avg_monthly_turnover" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Berapa rata rata omset anda bulanan Anda?</label>
                            <input type="text" inputmode="numeric" name="avg_monthly_turnover" id="avg_monthly_turnover" value="{{ old("avg_monthly_turnover") }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukkan Omset Bulanan" autocomplete="off" required>
                        </div>
                        <div>
                            <label for="income" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Penghasilan</label>
                            <div class="flex items-center my-2">
                                <input {{ old('salary', 'personal_income') == 'personal_income' ? 'checked' : '' }} id="personal_income" type="radio" value="personal_income" name="salary" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="personal_income" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Pribadi</label>
                            </div>
                            <div class="flex items-center my-2">
                                <input {{ old('salary', 'false') == 'joint_income' ? 'checked' : '' }} id="joint_income" type="radio" value="joint_income" name="salary" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="joint_income" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Joint Income</label>
                            </div>
                        </div>
                        <div id="self_income_section">
                            <label for="self_income" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah Penghasilan Pribadi</label>
                            <input type="text" inputmode="numeric" name="self_income" id="self_income" value="{{ old("self_income") }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukkan Jumlah Penghasilan Pribadi" autocomplete="off" required>
                            @error('self_income')
                                <div class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Warning, </span> {{ $message }}</div>
                            @enderror
                        </div>
                        <div id="join_income_section" class="hidden border border-solid rounded-lg p-5">
                            <div>
                                <label for="join_husband" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah Penghasilan Suami</label>
                                <input type="text" inputmode="numeric" name="join_husband" id="join_husband" value="{{ old("join_husband") }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukkan Jumlah Penghasilan Suami" autocomplete="off">
                            </div>
                            @error('join_husband_data')
                                <div class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Warning, </span> {{ $message }}</div>
                            @enderror
                            <div class="mt-2">
                                <label for="join_wife" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah Penghasilan Istri</label>
                                <input type="text" inputmode="numeric" name="join_wife" id="join_wife" value="{{ old("join_wife") }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukkan Jumlah Penghasilan Istri" autocomplete="off">
                            </div>
                            @error('join_wife_data')
                                <div class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Warning, </span> {{ $message }}</div>
                            @enderror
                            <div class="mt-2">
                                <label for="join-total" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total Jumlah Penghasilan Joint Income</label>
                                <p id="total_joint">Rp.0</p>
                            </div>
                        </div>
                        <div>
                            <label for="has_instalment" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Apakah Anda memiliki cicilan?</label>
                            <div class="flex items-center my-2">
                                <input {{ old('has_instalment') == 'true' ? 'checked' : '' }} id="instalment_yes" type="radio" value="true" name="has_instalment" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="instalment_yes" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Ya</label>
                            </div>
                            <div class="flex items-center my-2">
                                <input {{ old('has_instalment', 'false') == 'false' ? 'checked' : '' }} id="instalment_no" type="radio" value="false" name="has_instalment" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="instalment_no" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Tidak</label>
                            </div>
                        </div>
                        <div id="instalment_amount_section" class="hidden">
                            <label for="instalment_amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah Cicilan</label>
                            <input type="instalment_amount" name="instalment_amount" id="instalment_amount" value="{{ old("instalment_amount") }}"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukkan Jumlah Cicilan">
                            @error('instalment_amount_data')
                                <div class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Warning, </span> {{ $message }}</div>
                            @enderror
                        </div>
                        <div class="flex items-center justify-center">
                            <button type="button" data-modal-target="default-modal" data-modal-toggle="default-modal" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Submit</button>
                          </div>  
                          @include('submissions.modal')                      
                    </form>
                </div>
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

    
    @push('scripts')
        <script src="{{ asset('js/submission.js') }}"></script>
    @endpush