@extends('layouts.admin')

@section('title', 'Detail Pesan Kontak')
@section('header', 'Detail Pesan')

@section('content')
<div class="bg-white/90 backdrop-blur-xl w-full shadow-[0_4px_12px_rgba(92,61,46,0.08)] rounded-2xl border border-primary-lighter/30 overflow-hidden max-w-4xl mx-auto">
    <div class="flex justify-between items-center p-6 border-b border-primary-lighter/40 bg-white/50">
        <div>
            <h3 class="text-lg font-bold font-display text-primary-dark tracking-tight flex items-center gap-2">
                <i class="fas fa-envelope-open-text text-cta"></i> Detail Pesan Masuk
            </h3>
        </div>
        <a href="{{ route('admin.contacts.index') }}" class="text-sm font-semibold text-primary hover:text-cta transition-colors flex items-center gap-1.5">
            <i class="fas fa-arrow-left text-xs"></i> Kembali ke Inbox
        </a>
    </div>

    <div class="p-8">
        <div class="bg-primary-lighter/10 rounded-2xl border border-primary-lighter/50 p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-primary-lighter/50 pb-4 mb-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-primary-lighter/30 text-primary flex items-center justify-center font-bold text-xl uppercase shadow-sm">
                        {{ substr($contact->name, 0, 1) }}
                    </div>
                    <div>
                        <h4 class="font-bold text-primary-dark text-lg">{{ $contact->name }}</h4>
                        <p class="text-sm text-gray-600 font-medium">{{ $contact->email }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-primary bg-primary-lighter/30 px-3 py-1.5 rounded-full border border-primary-lighter tracking-wide">
                        <i class="far fa-calendar-alt"></i> {{ $contact->created_at->format('d M Y, H:i') }}
                    </span>
                </div>
            </div>

            <div class="pt-2">
                <h5 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-1">Subjek</h5>
                <p class="text-lg font-bold text-primary-dark mb-6">{{ $contact->subject }}</p>

                <h5 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">Isi Pesan</h5>
                <div class="bg-white rounded-xl p-5 border border-primary-lighter/30 text-gray-800 leading-relaxed font-medium whitespace-pre-wrap shadow-sm">
                    {{ $contact->message }}
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <a href="mailto:{{ $contact->email }}?subject=RE: {{ urlencode($contact->subject) }}" class="bg-primary text-white hover:bg-primary-dark hover:-translate-y-[1px] shadow-sm hover:shadow-[0_6px_18px_rgba(139,94,60,0.3)] px-6 py-2.5 rounded-full text-sm font-bold transition-all duration-200 flex items-center gap-2">
                <i class="fas fa-reply text-xs"></i> Balas via Email
            </a>
        </div>
    </div>
</div>
@endsection
