<x-mail::message>
# Terima Kasih Telah Mendaftar!

Terimakasih kepada <b>{{ $username }}</b> sudah mendaftar menggunakan website kami. <br>
Berikut merupakan Kode Referral yang dapat anda gunakan.
{{-- <x-mail::subcopy>
</x-mail::subcopy> --}}
<x:mail::panel>
Perumahan : <b>{{ $houseName }}</b> <br>
Kode Referral : <b>{{ $code }}</b>
</x:mail::panel>
<b>
    Note: <br>Kode Referral dapat digunakan sebagaimana mestinya Basmallah Agency membuat peraturan.
</b>
<x-mail::subcopy>
</x-mail::subcopy>
Terimakasih telah menggunakan website kami. :D<br>
{{ config('app.name') }}
</x-mail::message>
