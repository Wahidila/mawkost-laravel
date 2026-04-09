@extends('layouts.admin')

@section('title', 'Pesan Kontak')
@section('header', 'Pesan Kontak')

@section('content')
<div class="bg-white/90 backdrop-blur-xl w-full shadow-[0_4px_12px_rgba(92,61,46,0.08)] rounded-2xl border border-primary-lighter/30 overflow-hidden">
    <div class="flex justify-between items-center p-6 border-b border-primary-lighter/40 bg-white/50">
        <div>
            <h3 class="text-lg font-bold font-display text-primary-dark tracking-tight flex items-center gap-2">
                <i class="fas fa-envelope-open-text text-cta"></i> Inbox Pesan
            </h3>
            <p class="text-sm text-gray-500 mt-0.5">Kelola pesan kontak dari pengunjung website.</p>
        </div>
    </div>
    
    <div class="overflow-x-auto custom-scrollbar">
        <table class="min-w-full divide-y divide-primary-lighter/30">
            <thead class="bg-primary-lighter/20">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider">Pengirim</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider">Subjek</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider">Pesan Singkat</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-transparent divide-y divide-primary-lighter/20">
                @forelse($contacts as $item)
                <tr class="{{ $item->is_read ? 'hover:bg-primary-lighter/5 transition-colors duration-150' : 'bg-primary-lighter/10 hover:bg-primary-lighter/20 transition-colors duration-150' }}">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 {{ !$item->is_read ? 'font-semibold text-primary-dark' : '' }}">{{ $item->created_at->format('d M Y H:i') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 {{ !$item->is_read ? 'font-bold text-primary-dark' : '' }}">{{ $item->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 {{ !$item->is_read ? 'font-bold text-primary-dark' : '' }}">{{ $item->subject }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 {{ !$item->is_read ? 'font-semibold text-primary-dark' : '' }}">{{ Str::limit($item->message, 30) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @if($item->is_read)
                            <span class="inline-flex items-center gap-1 text-[11px] font-bold text-green-600 bg-green-50/50 px-2.5 py-1 rounded-full border border-green-200 uppercase tracking-wider shadow-sm">
                                <i class="fas fa-check-double"></i> Dibaca
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-[11px] font-bold text-cta bg-cta/10 px-2.5 py-1 rounded-full border border-cta/20 uppercase tracking-wider shadow-sm">
                                <i class="fas fa-circle text-[8px] animate-pulse"></i> Baru
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('admin.contacts.show', $item->id) }}" class="text-primary hover:text-white bg-primary-lighter/30 hover:bg-primary px-4 py-1.5 rounded-full transition-colors duration-200 inline-flex items-center gap-1.5 shadow-sm text-xs font-bold">
                            <i class="fas fa-eye"></i> Lihat
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center text-gray-400">
                            <i class="fas fa-envelope-open text-4xl mb-3 opacity-50"></i>
                            <p class="text-sm font-medium">Belum ada pesan kontak masuk</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($contacts->hasPages())
    <div class="px-6 py-4 border-t border-primary-lighter/30 bg-primary-lighter/5">
        {{ $contacts->links() }}
    </div>
    @endif
</div>
@endsection
