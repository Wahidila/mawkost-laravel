@extends('layouts.admin')

@section('title', 'Manage Users')
@section('header', 'Data Pengguna')

@section('content')
<div class="bg-white/90 backdrop-blur-xl w-full shadow-[0_4px_12px_rgba(92,61,46,0.08)] rounded-2xl border border-primary-lighter/30 overflow-hidden">
    <div class="flex justify-between items-center p-6 border-b border-primary-lighter/40 bg-white/50">
        <div>
            <h3 class="text-lg font-bold font-display text-primary-dark tracking-tight flex items-center gap-2">
                <i class="fas fa-users text-cta"></i> Daftar Pengguna
            </h3>
            <p class="text-sm text-gray-500 mt-0.5">Kelola data seluruh pengguna sistem dan aplikasi.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="bg-primary text-white hover:bg-primary-dark hover:-translate-y-[1px] shadow-sm hover:shadow-[0_6px_18px_rgba(139,94,60,0.3)] px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 flex items-center gap-2">
            <i class="fas fa-plus text-xs"></i> Tambah Pengguna
        </a>
    </div>

    @if(session('success'))
        <div class="m-6 mb-0 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm text-sm font-medium flex items-start gap-2.5 animate-fade-in">
            <i class="fas fa-check-circle text-green-500 mt-0.5 text-lg"></i> 
            <div>{{ session('success') }}</div>
        </div>
    @endif
    
    @if(session('error'))
        <div class="m-6 mb-0 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl shadow-sm text-sm font-medium flex items-start gap-2.5 animate-fade-in">
            <i class="fas fa-exclamation-circle text-red-500 mt-0.5 text-lg"></i> 
            <div>{{ session('error') }}</div>
        </div>
    @endif

    <div class="overflow-x-auto custom-scrollbar @if(session('success') || session('error')) mt-6 @endif">
        <table class="min-w-full divide-y divide-primary-lighter/30">
            <thead class="bg-primary-lighter/20">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider">Email</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider">WhatsApp</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider">Role</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-primary-dark uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-transparent divide-y divide-primary-lighter/20">
                @forelse($users as $u)
                <tr class="hover:bg-primary-lighter/5 transition-colors duration-150 group">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-primary-dark cursor-default">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-primary-lighter/30 text-primary flex items-center justify-center font-bold text-xs uppercase shadow-sm">
                                {{ substr($u->name, 0, 2) }}
                            </div>
                            {{ $u->name }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-medium">{{ $u->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-medium">{{ $u->whatsapp ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <span class="px-3 py-1 inline-flex text-[11px] leading-5 font-bold rounded-full shadow-sm border
                            {{ $u->isAdmin() ? 'bg-purple-50 text-purple-700 border-purple-200' : 'bg-green-50 text-green-700 border-green-200' }} uppercase tracking-wider">
                            {{ $u->role }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.users.edit', $u->id) }}" class="w-8 h-8 rounded-full bg-primary-lighter/30 hover:bg-primary text-primary hover:text-white flex items-center justify-center transition-all duration-200" title="Edit" data-bs-toggle="tooltip">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            <form action="{{ route('admin.users.sendCredentials', $u->id) }}" method="POST" class="inline" onsubmit="return confirm('Password user ini akan di-reset dan dikirim ke email {{ $u->email }}. Lanjutkan?');">
                                @csrf
                                <button type="submit" class="w-8 h-8 rounded-full bg-green-50 hover:bg-green-500 text-green-600 hover:text-white border border-green-100 hover:border-transparent flex items-center justify-center transition-all duration-200" title="Kirim Akun ke Email/WA">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </form>
                            
                            @if(auth()->id() !== $u->id)
                            <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus pengguna ini secara permanen?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-full bg-red-50 hover:bg-red-500 text-red-600 hover:text-white border border-red-100 hover:border-transparent flex items-center justify-center transition-all duration-200" title="Hapus">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center text-gray-400">
                            <i class="fas fa-users-slash text-4xl mb-3 opacity-50"></i>
                            <p class="text-sm font-medium">Belum ada pengguna terdaftar</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
    <div class="px-6 py-4 border-t border-primary-lighter/30 bg-primary-lighter/5">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
