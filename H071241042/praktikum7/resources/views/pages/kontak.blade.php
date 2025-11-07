@extends('layouts.master')

@section('title', 'Kontak')

@section('content')
<div class="max-w-4xl mx-auto">
    <h2 class="text-3xl font-bold text-[#042440] mb-8 text-center">Hubungi Kami</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Informasi Kontak -->
        <div class="bg-white p-6 rounded-lg shadow-lg border border-[#b79393]">
            <h3 class="text-xl font-semibold mb-4 text-[#4e499e]">Informasi Kontak</h3>
            <div class="space-y-4 text-[#042440]">
                <div>
                    <h4 class="font-semibold">📍 Alamat Basecamp</h4>
                    <p class="opacity-80">Jl. Raya Bromo, Desa Ngadisari, Kec. Sukapura, Probolinggo, Jawa Timur</p>
                </div>
                <div>
                    <h4 class="font-semibold">📞 Telepon/WhatsApp</h4>
                    <p class="opacity-80">+62 812-3456-7890 (Guide Bromo)</p>
                    <p class="opacity-80">+62 813-4567-8901 (Jeep Rental)</p>
                </div>
                <div>
                    <h4 class="font-semibold">📧 Email</h4>
                    <p class="opacity-80">info@explorbromo.com</p>
                    <p class="opacity-80">booking@explorbromo.com</p>
                </div>
                <div>
                    <h4 class="font-semibold">🕒 Jam Operasional</h4>
                    <p class="opacity-80">Setiap Hari: 24 Jam (Untuk Trip Sunrise)</p>
                    <p class="opacity-80">Office: 08:00 - 17:00 WIB</p>
                </div>
            </div>
        </div>

        <!-- Form Kontak -->
        <div class="bg-white p-6 rounded-lg shadow-lg border border-[#b79393]">
            <h3 class="text-xl font-semibold mb-4 text-[#4e499e]">Booking Trip atau Tanya-tanya</h3>
            <form class="space-y-4 text-[#042440]">
                <div>
                    <label for="nama" class="block text-sm font-medium">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" class="mt-1 block w-full rounded-md border border-[#b79393] focus:border-[#4e499e] focus:ring-[#4e499e] p-2 shadow-sm">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium">Email</label>
                    <input type="email" id="email" name="email" class="mt-1 block w-full rounded-md border border-[#b79393] focus:border-[#4e499e] focus:ring-[#4e499e] p-2 shadow-sm">
                </div>
                <div>
                    <label for="telepon" class="block text-sm font-medium">Nomor Telepon</label>
                    <input type="tel" id="telepon" name="telepon" class="mt-1 block w-full rounded-md border border-[#b79393] focus:border-[#4e499e] focus:ring-[#4e499e] p-2 shadow-sm">
                </div>
                <div>
                    <label for="jenis" class="block text-sm font-medium">Jenis Layanan</label>
                    <select id="jenis" name="jenis" class="mt-1 block w-full rounded-md border border-[#b79393] focus:border-[#4e499e] focus:ring-[#4e499e] p-2 shadow-sm">
                        <option value="">Pilih Layanan</option>
                        <option value="jeep">Jeep Tour Bromo</option>
                        <option value="guide">Pemandu Wisata</option>
                        <option value="homestay">Penginapan</option>
                        <option value="paket">Paket Wisata</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>
                <div>
                    <label for="tanggal" class="block text-sm font-medium">Tanggal Kunjungan (Rencana)</label>
                    <input type="date" id="tanggal" name="tanggal" class="mt-1 block w-full rounded-md border border-[#b79393] focus:border-[#4e499e] focus:ring-[#4e499e] p-2 shadow-sm">
                </div>
                <div>
                    <label for="pesan" class="block text-sm font-medium">Pesan/Kebutuhan Khusus</label>
                    <textarea id="pesan" name="pesan" rows="4" class="mt-1 block w-full rounded-md border border-[#b79393] focus:border-[#4e499e] focus:ring-[#4e499e] p-2 shadow-sm" placeholder="Jumlah orang, kebutuhan khusus, dll..."></textarea>
                </div>
                <button type="submit" class="bg-[#4e499e] text-white px-6 py-3 rounded-md hover:bg-[#3e3b82] transition duration-300 w-full font-semibold">
                    Kirim Pesan & Booking
                </button>
            </form>
        </div>
    </div>

    <!-- Additional Info -->
    <div class="mt-8 bg-[#b79393]/20 rounded-xl p-6 border border-[#b79393]">
        <h3 class="text-xl font-semibold text-[#042440] mb-3">Tips Booking Trip Bromo</h3>
        <ul class="list-disc list-inside text-[#042440]/90 space-y-2">
            <li>Booking minimal 3 hari sebelumnya untuk harga terbaik</li>
            <li>Jeep capacity: 4–6 orang (bisa rombongan)</li>
            <li>Include: Driver, BBM, Tour sesuai rute</li>
            <li>Exclude: Tiket masuk, makan, akomodasi</li>
            <li>Free pickup dari penginapan di area Cemoro Lawang/Ngadisari</li>
        </ul>
    </div>
</div>
@endsection
