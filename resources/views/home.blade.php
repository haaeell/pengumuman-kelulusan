@extends('layouts.app')

@section('content')

<div class="space-y-6">
        <!-- STAT CARDS -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-blue-50 border border-blue-600 rounded-xl p-5 flex justify-between">
                <div>
                    <p class="text-sm font-medium">Jumlah Siswa</p>
                    <h3 class="text-2xl font-bold">{{ $students->count() }}</h3>
                </div>
                <span class="text-3xl">👨‍🎓</span>
            </div>

            <div class="bg-green-50 border border-green-600 rounded-xl p-5 flex justify-between">
                <div>
                    <p class="text-sm font-medium">Eligible</p>
                    <h3 class="text-2xl font-bold">
                        {{ $students->where('is_eligible', 1)->count() }}
                    </h3>
                </div>
                <span class="text-3xl">✅</span>
            </div>

            <div class="bg-red-50 border border-red-600 rounded-xl p-5 flex justify-between">
                <div>
                    <p class="text-sm font-medium">Tidak Eligible</p>
                    <h3 class="text-2xl font-bold">
                        {{ $students->where('is_eligible', 0)->count() }}
                    </h3>
                </div>
                <span class="text-3xl">❌</span>
            </div>
        </div>
    </div>
@endsection
