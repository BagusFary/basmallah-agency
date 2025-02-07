@extends('components.layouts.landingpage')

@section('title', 'Basmallah Agency | ' . $housingPartners->name)

@section('description', 'Basmallah Agency merupakan Agen Properti yang sudah berjalan lama')

@section('body-class', 'bg-vintage-brem')
@section('content')

    <section class="container mx-auto">
        <div class="px-3 py-8 md:py-[7em] ">
            <div class="w-full bg-white rounded-lg shadow border-2 dark:border dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <div class="flex-row self-start mb-3">
                        <a href="#" class="flex self-start mt-5 text-2xl font-semibold text-gray-900 dark:text-white">
                            {{ $housingPartners->name }}
                        </a>
                        <span class="flex self-start text-gray-400">Form Submission</span>
                    </div>
                    <form class="space-y-4 md:space-y-6" id="form-submission" action="{{ route("housing-partners.store", $housingPartners->id) }}" method="post">
                        @method('POST')
                        @csrf
                        <input type="hidden" name="id" value="{{ old('id') }}">
                        <input type="hidden" id="code" name="code" value="{{ $housingPartners->code }}">
                        <input type="hidden" id="instalment_amount" name="instalment_amount" value="{{ old('instalment_amount') ?? '0' }}">
                        <input type="hidden" id="avg_monthly_turnover" name="avg_monthly_turnover" value="{{ old('avg_monthly_turnover') ?? '0' }}">
                        <input type="hidden" id="join_husband" name="join_husband" value="{{ old('join_husband') }}">
                        <input type="hidden" id="join_wife" name="join_wife" value="{{ old('join_wife') }}">
                        <input type="hidden" id="self_income" name="self_income" value="{{ old('self_income') }}">
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-vintage-dark dark:text-white">Email *</label>
                            <input type="email" name="email" id="email" value="{{ old("email") }}" class=" bg-vintage-light border border-vintage-brem text-vintage-dark text-sm rounded-lg focus:ring-vintage-dark focus:border-vintage-brem block w-full p-2.5" placeholder="Masukkan Email" autocomplete="off">
                            @error('email')
                                <div class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Peringatan, </span> {{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                            <input type="text" name="name" value="{{ old("name") }}" id="name" class="bg-vintage-light border border-vintage-brem text-vintage-dark text-sm rounded-lg focus:ring-vintage-dark focus:border-vintage-brem block w-full p-2.5" placeholder="Masukkan Nama Lengkap" autocomplete="off" required>
                            @error('name')
                                <div class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Peringatan, </span> {{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="id_card" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIK</label>
                            <input type="text" inputmode="numeric" name="id_card" id="id_card" value="{{ old("id_card") }}" class="bg-vintage-light border border-vintage-brem text-vintage-dark text-sm rounded-lg focus:ring-vintage-dark focus:border-vintage-brem block w-full p-2.5" placeholder="Masukkan NIK" autocomplete="off" required>
                            @error('id_card')
                                <div class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Peringatan, </span> {{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat</label>
                            <input type="text" name="address" id="address" value="{{ old("address") }}" class="bg-vintage-light border border-vintage-brem text-vintage-dark text-sm rounded-lg focus:ring-vintage-dark focus:border-vintage-brem block w-full p-2.5" placeholder="Masukkan Alamat" autocomplete="off" required>
                            @error('address')
                                <div class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Peringatan, </span> {{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomor WhatsApp</label>
                            <input type="text" inputmode="numeric" name="phone" id="phone" value="{{ old("phone") }}" class="bg-vintage-light border border-vintage-brem text-vintage-dark text-sm rounded-lg focus:ring-vintage-dark focus:border-vintage-brem block w-full p-2.5" placeholder="Contoh. 089*********" autocomplete="off" required>
                            @error('phone')
                                <div class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Peringatan, </span> {{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status Pekerjaan</label>
                            <div class="flex items-center my-2">
                                <input {{ old('employment_status', 'self_employees') == 'self_employees' ? 'checked' : '' }} id="self_employees" type="radio" value="self_employees" name="employment_status" class="w-4 h-4 text-vintage-dark bg-vintage-light border-vintage-dark focus:ring-vintage-dark focus:ring-2">
                                <label for="self_employees" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Wirausaha</label>
                            </div>
                            <div class="flex items-center my-2">
                                <input {{ old('employment_status', 'false') == 'civil_servants' ? 'checked' : '' }} id="civil_servants" type="radio" value="civil_servants" name="employment_status" class="w-4 h-4 text-vintage-dark bg-vintage-light border-vintage-dark focus:ring-vintage-dark focus:ring-2">
                                <label for="civil_servants" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">PNS</label>
                            </div>
                            <div class="flex items-center my-2">
                                <input {{ old('employment_status', 'false') == 'employees' ? 'checked' : '' }} id="employee" type="radio" value="employees" name="employment_status" class="w-4 h-4 text-vintage-dark bg-vintage-light border-vintage-dark focus:ring-vintage-dark focus:ring-2">
                                <label for="employee" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Pegawai Swasta</label>
                            </div>
                        </div>
                        <div id="self_employee_as_section">
                            <label for="self_employee_as" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bidang Wirausaha</label>
                            <input type="text" name="self_employee_as" id="self_employee_as" value="{{ old("self_employee_as") }}"class="bg-vintage-light border border-vintage-brem text-vintage-dark text-sm rounded-lg focus:ring-vintage-dark focus:border-vintage-brem block w-full p-2.5" placeholder="Masukkan Bidang Usaha" autocomplete="off" required>
                            @error('self_employee_as')
                                <div class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Peringatan, </span> {{ $message }}</div>
                            @enderror
                        </div>
                        <div id="avg_monthly_turnover_section">
                            <label for="avg_monthly_turnover_input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Berapa rata rata omset anda bulanan Anda?</label>
                            <input type="text" inputmode="numeric" name="avg_monthly_turnover_input" id="avg_monthly_turnover_input" value="{{ old("avg_monthly_turnover_input") }}" class="bg-vintage-light border border-vintage-brem text-vintage-dark text-sm rounded-lg focus:ring-vintage-dark focus:border-vintage-brem block w-full p-2.5" placeholder="Masukkan Omset Bulanan" autocomplete="off" required>
                            @error('avg_monthly_turnover')
                                <div class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Peringatan, </span> {{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="income" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Penghasilan</label>
                            <div class="flex items-center my-2">
                                <input {{ old('salary', 'personal_income') == 'personal_income' ? 'checked' : '' }} id="personal_income" type="radio" value="personal_income" name="salary" class="w-4 h-4 text-vintage-dark bg-vintage-light border-vintage-dark focus:ring-vintage-dark focus:ring-2">
                                <label for="personal_income" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Pribadi</label>
                            </div>
                            <div class="flex items-center my-2">
                                <input {{ old('salary', 'false') == 'joint_income' ? 'checked' : '' }} id="joint_income" type="radio" value="joint_income" name="salary" class="w-4 h-4 text-vintage-dark bg-vintage-light border-vintage-dark focus:ring-vintage-dark focus:ring-2">
                                <label for="joint_income" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Joint Income</label>
                            </div>
                        </div>
                        <div id="self_income_section">
                            <label for="self_income_input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah Penghasilan Pribadi</label>
                            <input type="text" inputmode="numeric" name="self_income_input" id="self_income_input" value="{{ old("self_income_input") }}" class="bg-vintage-light border border-vintage-brem text-vintage-dark text-sm rounded-lg focus:ring-vintage-dark focus:border-vintage-brem block w-full p-2.5" placeholder="Masukkan Jumlah Penghasilan Pribadi" autocomplete="off" required>
                            @error('self_income')
                                <div class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Peringatan, </span> {{ $message }}</div>
                            @enderror
                        </div>
                        <div id="join_income_section" class="hidden border border-solid rounded-lg p-5">
                            <div>
                                <label for="join_husband_input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah Penghasilan Suami</label>
                                <input type="text" inputmode="numeric" name="join_husband_input" id="join_husband_input" value="{{ old("join_husband_input") }}" class="bg-vintage-light border border-vintage-brem text-vintage-dark text-sm rounded-lg focus:ring-vintage-dark focus:border-vintage-brem block w-full p-2.5" placeholder="Masukkan Jumlah Penghasilan Suami" autocomplete="off">
                            </div>
                            @error('join_husband')
                                <div class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Peringatan, </span> {{ $message }}</div>
                            @enderror
                            <div class="mt-2">
                                <label for="join_wife_input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah Penghasilan Istri</label>
                                <input type="text" inputmode="numeric" name="join_wife_input" id="join_wife_input" value="{{ old("join_wife_input") }}" class="bg-vintage-light border border-vintage-brem text-vintage-dark text-sm rounded-lg focus:ring-vintage-dark focus:border-vintage-brem block w-full p-2.5" placeholder="Masukkan Jumlah Penghasilan Istri" autocomplete="off">
                            </div>
                            @error('join_wife')
                                <div class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Peringatan, </span> {{ $message }}</div>
                            @enderror
                            <div class="mt-2">
                                <label for="join-total" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total Jumlah Penghasilan Joint Income</label>
                                <p id="total_joint">Rp.0</p>
                            </div>
                        </div>
                        <div>
                            <label for="has_instalment" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Apakah Anda memiliki cicilan?</label>
                            <div class="flex items-center my-2">
                                <input {{ old('has_instalment') == '1' ? 'checked' : '' }} id="instalment_yes" type="radio" value="1" name="has_instalment" class="w-4 h-4 text-vintage-dark bg-vintage-light border-vintage-dark focus:ring-vintage-dark focus:ring-2">
                                <label for="instalment_yes" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Ya</label>
                            </div>
                            <div class="flex items-center my-2">
                                <input {{ old('has_instalment', '0') == '0' ? 'checked' : '' }} id="instalment_no" type="radio" value="0" name="has_instalment" class="w-4 h-4 text-vintage-dark bg-vintage-light border-vintage-dark focus:ring-vintage-dark focus:ring-2">
                                <label for="instalment_no" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Tidak</label>
                            </div>
                        </div>
                        <div id="instalment_amount_section" class="hidden">
                            <label for="instalment_amount_input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah Cicilan</label>
                            <input type="text" inputmode="numeric" name="instalment_amount_input" id="instalment_amount_input" value="{{ old("instalment_amount_input") }}"  class="bg-vintage-light border border-vintage-brem text-vintage-dark text-sm rounded-lg focus:ring-vintage-dark focus:border-vintage-brem block w-full p-2.5" placeholder="Masukkan Jumlah Cicilan">
                            @error('instalment_amount')
                                <div class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Peringatan, </span> {{ $message }}</div>
                            @enderror
                        </div>
                        <div class="flex items-center justify-center">
                            <button type="button" data-modal-target="default-modal" data-modal-toggle="default-modal" class="w-full text-white bg-vintage-dark focus:ring-4 focus:ring-vintage-brem font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none">Submit</button>
                          </div>
                          @include('submissions.modal')
                    </form>
                </div>
            </div>
        </div>
    </section>


    @endsection


    @push('scripts')
        <script src="{{ asset('js/submission.js') }}"></script>
    @endpush
