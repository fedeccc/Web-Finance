<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Finance Tracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                },
            },
        };
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="min-h-full bg-slate-950 font-sans text-slate-100 antialiased">
    <div class="pointer-events-none fixed inset-0 overflow-hidden">
        <div class="absolute -left-32 top-0 h-96 w-96 rounded-full bg-emerald-500/10 blur-3xl"></div>
        <div class="absolute -right-32 top-1/3 h-96 w-96 rounded-full bg-indigo-500/10 blur-3xl"></div>
    </div>

    <div class="relative mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        {{-- Header --}}
        <header class="mb-10">
            <p class="text-sm font-medium uppercase tracking-wider text-emerald-400">Dashboard</p>
            <h1 class="mt-1 text-3xl font-bold tracking-tight text-white sm:text-4xl">
                Personal Finance Tracker
            </h1>
            <p class="mt-2 max-w-xl text-slate-400">
                Catat pemasukan dan pengeluaran Anda dalam satu tempat.
            </p>
        </header>

        {{-- Flash & errors --}}
        @if (session('success'))
            <div class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-emerald-300">
                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3">
                <ul class="list-inside list-disc space-y-1 text-sm text-red-300">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Summary cards --}}
        <section class="mb-10 grid gap-4 sm:grid-cols-3">
            <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-6 shadow-xl backdrop-blur">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-slate-400">Total Saldo</p>
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-500/20 text-indigo-400">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 11.42 12.768 11 12 11s-1.536.42-2.121 1.121c-1.172.879-1.172 2.303 0 3.182.879.659 1.879.659 2.659 0M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                </div>
                <p class="mt-3 text-2xl font-bold {{ $totalBalance >= 0 ? 'text-white' : 'text-red-400' }}">
                    Rp {{ number_format($totalBalance, 0, ',', '.') }}
                </p>
            </div>

            <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-6 shadow-xl backdrop-blur">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-slate-400">Total Pemasukan</p>
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500/20 text-emerald-400">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </span>
                </div>
                <p class="mt-3 text-2xl font-bold text-emerald-400">
                    Rp {{ number_format($totalIncome, 0, ',', '.') }}
                </p>
            </div>

            <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-6 shadow-xl backdrop-blur">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-slate-400">Total Pengeluaran</p>
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-rose-500/20 text-rose-400">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" />
                        </svg>
                    </span>
                </div>
                <p class="mt-3 text-2xl font-bold text-rose-400">
                    Rp {{ number_format($totalExpense, 0, ',', '.') }}
                </p>
            </div>
        </section>

        <div class="grid gap-8 lg:grid-cols-5">
            {{-- Add transaction form --}}
            <section class="lg:col-span-2">
                <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-6 shadow-xl backdrop-blur">
                    <h2 class="text-lg font-semibold text-white">Tambah Transaksi</h2>
                    <p class="mt-1 text-sm text-slate-400">Isi detail transaksi baru di bawah.</p>

                    <form action="{{ route('transactions.store') }}" method="POST" class="mt-6 space-y-5">
                        @csrf

                        <div>
                            <label for="description" class="mb-1.5 block text-sm font-medium text-slate-300">
                                Deskripsi
                            </label>
                            <input
                                type="text"
                                name="description"
                                id="description"
                                value="{{ old('description') }}"
                                placeholder="Contoh: Gaji bulanan, Makan siang"
                                required
                                class="w-full rounded-xl border border-slate-700 bg-slate-800/50 px-4 py-2.5 text-sm text-white placeholder-slate-500 outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                            >
                        </div>

                        <div>
                            <label for="amount" class="mb-1.5 block text-sm font-medium text-slate-300">
                                Jumlah Uang
                            </label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-sm text-slate-500">Rp</span>
                                <input
                                    type="number"
                                    name="amount"
                                    id="amount"
                                    value="{{ old('amount') }}"
                                    min="1"
                                    placeholder="0"
                                    required
                                    class="w-full rounded-xl border border-slate-700 bg-slate-800/50 py-2.5 pl-12 pr-4 text-sm text-white placeholder-slate-500 outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                                >
                            </div>
                        </div>

                        <div>
                            <label for="type" class="mb-1.5 block text-sm font-medium text-slate-300">
                                Tipe Transaksi
                            </label>
                            <select
                                name="type"
                                id="type"
                                required
                                class="w-full rounded-xl border border-slate-700 bg-slate-800/50 px-4 py-2.5 text-sm text-white outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                            >
                                <option value="income" @selected(old('type') === 'income')>Pemasukan</option>
                                <option value="expense" @selected(old('type', 'expense') === 'expense')>Pengeluaran</option>
                            </select>
                        </div>

                        <button
                            type="submit"
                            class="w-full rounded-xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-600/25 transition hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-offset-slate-900"
                        >
                            Simpan Transaksi
                        </button>
                    </form>
                </div>
            </section>

            {{-- Transaction history --}}
            <section class="lg:col-span-3">
                <div class="rounded-2xl border border-slate-800 bg-slate-900/80 shadow-xl backdrop-blur">
                    <div class="border-b border-slate-800 px-6 py-5">
                        <h2 class="text-lg font-semibold text-white">Riwayat Transaksi</h2>
                        <p class="mt-1 text-sm text-slate-400">
                            {{ $transactions->count() }} transaksi tercatat
                        </p>
                    </div>

                    @if ($transactions->isEmpty())
                        <div class="flex flex-col items-center justify-center px-6 py-16 text-center">
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-800 text-slate-500">
                                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                            </div>
                            <p class="mt-4 font-medium text-slate-300">Belum ada transaksi</p>
                            <p class="mt-1 text-sm text-slate-500">Tambahkan transaksi pertama Anda lewat form di samping.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full min-w-[520px] text-left text-sm">
                                <thead>
                                    <tr class="border-b border-slate-800 text-xs uppercase tracking-wider text-slate-500">
                                        <th class="px-6 py-4 font-medium">Deskripsi</th>
                                        <th class="px-6 py-4 font-medium">Jumlah</th>
                                        <th class="px-6 py-4 font-medium">Tipe</th>
                                        <th class="px-6 py-4 font-medium">Tanggal</th>
                                        <th class="px-6 py-4 font-medium text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-800/80">
                                    @foreach ($transactions as $transaction)
                                        <tr class="transition hover:bg-slate-800/30">
                                            <td class="px-6 py-4 font-medium text-white">
                                                {{ $transaction->description }}
                                            </td>
                                            <td class="px-6 py-4 font-semibold {{ $transaction->type === 'income' ? 'text-emerald-400' : 'text-rose-400' }}">
                                                {{ $transaction->type === 'income' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4">
                                                @if ($transaction->type === 'income')
                                                    <span class="inline-flex items-center rounded-full bg-emerald-500/15 px-2.5 py-0.5 text-xs font-medium text-emerald-400">
                                                        Pemasukan
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center rounded-full bg-rose-500/15 px-2.5 py-0.5 text-xs font-medium text-rose-400">
                                                        Pengeluaran
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-slate-400">
                                                {{ $transaction->created_at->format('d M Y, H:i') }}
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <form
                                                    action="{{ route('transactions.destroy', $transaction->id) }}"
                                                    method="POST"
                                                    class="inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus transaksi ini?');"
                                                >
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="submit"
                                                        class="inline-flex items-center gap-1.5 rounded-lg border border-red-500/30 bg-red-500/10 px-3 py-1.5 text-xs font-medium text-red-400 transition hover:bg-red-500/20"
                                                    >
                                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                        </svg>
                                                        Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </div>
</body>
</html>
