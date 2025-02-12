<x-mail::message>
# Ada informasi nih terkait orang yang melakukan submission!
    {{-- {{ dd($userSubmission) }} --}}
Berikut adalah informasi pengguna.
<x-mail::subcopy>
</x-mail::subcopy>
Perumahan : <b>{{ $userSubmission['housing_partner']['name'] }}</b> <br>
Kode Referral : <b>{{ $userSubmission['referral_code'] }}</b>
<x-mail::subcopy>
</x-mail::subcopy>
Nama : <b>{{ $userSubmission['name'] }}</b> <br>
Nomor Whatsapp : <b>{{ $userSubmission['phone'] }}</b> <br>
Email : <b>{{ $userSubmission['email'] }}</b> <br>
NIK : <b>{{ $userSubmission['id_card'] }}</b> <br>
Status Pekerjaan : <b>
@switch($userSubmission['employment_status'])
    @case('self_employees')
        Wirausaha
    @break

    @case('civil_servants')
        PNS
    @break

    @case('employees')
        Pegawai Swasta
    @break

    @default
@endswitch
</b> <br>
@if ($userSubmission['employment_status'] == 'self_employees')
Bidang Wirausaha : <b>{{ $userSubmission['self_employee_as'] }}</b> <br>
Rata-rata Omset Bulanan : <b>{{ \Number::format($userSubmission['avg_monthly_turnover'], locale: 'id') }}</b> <br>
@endif
Punya Cicilan :
<b>
@if ($userSubmission['has_instalment'] == '1')
Iya
@else
Tidak
@endif
</b> <br>
@if($userSubmission['has_instalment'] == '1')
Jumlah Cicilan : <b>{{ \Number::format($userSubmission['instalment_amount'], locale: 'id') }}</b>
@endif
<x-mail::subcopy>
</x-mail::subcopy>

<b>Penghasilan</b>
<x-mail::table>
| Tipe | Pendapatan |
| :-----------: | -----------: |
@foreach ($userSubmission['incomes'] as $income)
@switch($income['type'])
@case('self')
@if($income['salary'] == '0')
| Pribadi | Tidak ada |
@else
| Pribadi | Rp. {{ \Number::format($income['salary'], locale: 'id') }} |
@endif
@break
@case('join-husband')
| Suami | Rp. {{ \Number::format($income['salary'], locale: 'id') }} |
@break
@case('join-wife')
| Istri | Rp. {{ \Number::format($income['salary'], locale: 'id') }} |
@break
@default
@endswitch
@endforeach
</x-mail::table>

<x-mail::subcopy>
</x-mail::subcopy>
<b>
    Jangan lupa selalu cek dashboard untuk mendapatkan informasi lengkap. <br>
</b>
Terimakasih telah menggunakan website kami. :D<br>
{{ config('app.name') }}
</x-mail::message>
