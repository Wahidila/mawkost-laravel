@extends('layouts.admin')

@section('title', 'Manage Users')
@section('header', 'Data Pengguna')

@section('content')
<div class="bg-white w-full shadow rounded-lg p-6">
    <div class="flex justify-between items-center mb-4 border-b pb-4">
        <h3 class="text-lg font-semibold text-gray-800">Daftar Pengguna</h3>
        <a href="{{ route('admin.users.create') }}" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded text-sm">
            <i class="fas fa-plus mr-1"></i> Tambah Pengguna
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 rounded mb-4 text-sm"><i class="fas fa-check-circle mr-1"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 rounded mb-4 text-sm"><i class="fas fa-exclamation-circle mr-1"></i> {{ session('error') }}</div>
    @endif
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">WhatsApp</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($users as $u)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $u->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $u->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $u->whatsapp ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $u->isAdmin() ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                            {{ ucfirst($u->role) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex gap-3">
                        <a href="{{ route('admin.users.edit', $u->id) }}" class="text-blue-600 hover:text-blue-900"><i class="fas fa-edit"></i> Edit</a>
                        <form action="{{ route('admin.users.sendCredentials', $u->id) }}" method="POST" class="inline" onsubmit="return confirm('Password user ini akan di-reset dan dikirim ke email {{ $u->email }}. Lanjutkan?');">
                            @csrf
                            <button type="submit" class="text-green-600 hover:text-green-900"><i class="fas fa-paper-plane"></i> Kirim Akun</button>
                        </form>
                        @if(auth()->id() !== $u->id)
                        <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900"><i class="fas fa-trash"></i> Hapus</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada pengguna terdaftar</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection
