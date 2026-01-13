@extends('layouts.app')

@section('content')
    <div class="space-y-6">

        <!-- HEADER -->
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold">Kelola Link WhatsApp</h2>
                <p class="text-sm text-gray-500">Admin bisa mengatur link grup WA untuk siswa eligible dan cadangan</p>
            </div>
        </div>

        <!-- FORM LINK WA -->
        <div class="bg-white shadow rounded-xl p-6 max-w-2xl">
            <form action="{{ route('wa-links.store') }}" method="POST">
                @csrf
                <div class="space-y-4">

                    <!-- LINK ELIGIBLE -->
                    <div>
                        <label class="block text-sm font-semibold mb-1">Link WA Eligible</label>
                        <input type="url" name="link_eligible" value="{{ $links['eligible']->link ?? '' }}"
                            placeholder="https://chat.whatsapp.com/xxxxxx"
                            class="w-full border border-gray-300 rounded-xl px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- LINK CADANGAN -->
                    <div>
                        <label class="block text-sm font-semibold mb-1">Link WA Cadangan</label>
                        <input type="url" name="link_cadangan" value="{{ $links['cadangan']->link ?? '' }}"
                            placeholder="https://chat.whatsapp.com/yyyyyy"
                            class="w-full border border-gray-300 rounded-xl px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-2">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition">Simpan</button>
                </div>
            </form>
        </div>

    </div>
@endsection
