<template>
  <div v-if="token" class="min-h-screen flex flex-col pb-12 overflow-x-hidden">
    <!-- Navigation Header & Mobile Side Panel -->
    <AppHeader activePage="riwayat" />

    <!-- Main Content -->
    <main class="flex-1 max-w-[1920px] mx-auto w-full px-4 sm:px-6 lg:px-8 space-y-6 pt-20">
      
      <!-- ===== EXECUTIVE KPI STATS BAR ===== -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 animate-fade-in-up">
        
        <!-- Card 1: Total Omset -->
        <div class="glass-card p-5 sm:p-6 relative overflow-hidden group hover:border-emerald-500/40 transition-all duration-300">
          <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pendapatan (Omset)</span>
            <div class="w-11 h-11 rounded-2xl bg-emerald-500/15 border border-emerald-500/30 flex items-center justify-center text-emerald-400 shadow-lg shadow-emerald-500/10">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
          </div>
          <p class="text-2xl sm:text-3xl lg:text-4xl font-black text-white tracking-tight truncate">
            Rp {{ totalOmzet.toLocaleString('id-ID') }}
          </p>
          <div class="flex items-center gap-1.5 mt-2.5 text-xs text-emerald-400 font-semibold">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
            <span>Total penjualan terakumulasi</span>
          </div>
        </div>

        <!-- Card 2: Total Pesanan -->
        <div class="glass-card p-5 sm:p-6 relative overflow-hidden group hover:border-blue-500/40 transition-all duration-300">
          <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pesanan Selesai</span>
            <div class="w-11 h-11 rounded-2xl bg-blue-500/15 border border-blue-500/30 flex items-center justify-center text-blue-400 shadow-lg shadow-blue-500/10">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
          </div>
          <p class="text-2xl sm:text-3xl lg:text-4xl font-black text-white tracking-tight">
            {{ pagination.total ?? 0 }} <span class="text-base font-medium text-slate-400">Nota</span>
          </p>
          <p class="text-xs text-slate-400 mt-2.5 flex items-center gap-1">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            <span>Status 100% Lunas</span>
          </p>
        </div>

        <!-- Card 3: Total Unit Produk Terjual -->
        <div class="glass-card p-5 sm:p-6 relative overflow-hidden group hover:border-sky-500/40 transition-all duration-300">
          <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Item Terjual</span>
            <div class="w-11 h-11 rounded-2xl bg-sky-500/15 border border-sky-500/30 flex items-center justify-center text-sky-400 shadow-lg shadow-sky-500/10">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
            </div>
          </div>
          <p class="text-2xl sm:text-3xl lg:text-4xl font-black text-white tracking-tight">
            {{ totalItemTerjual }} <span class="text-base font-medium text-slate-400">Unit</span>
          </p>
          <p class="text-xs text-sky-400 font-semibold mt-2.5">
            📦 Produk IT & Komputer
          </p>
        </div>

        <!-- Card 4: Rata-Rata Nilai Order (AOV) -->
        <div class="glass-card p-5 sm:p-6 relative overflow-hidden group hover:border-purple-500/40 transition-all duration-300">
          <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Rata-rata Per Transaksi</span>
            <div class="w-11 h-11 rounded-2xl bg-purple-500/15 border border-purple-500/30 flex items-center justify-center text-purple-300 shadow-lg shadow-purple-500/10">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
            </div>
          </div>
          <p class="text-2xl sm:text-3xl lg:text-4xl font-black text-white tracking-tight truncate">
            Rp {{ rataRataOrder.toLocaleString('id-ID') }}
          </p>
          <p class="text-xs text-purple-300 font-semibold mt-2.5">
            💡 Average Order Value (AOV)
          </p>
        </div>

      </div>

      <!-- ===== LAPORAN DATA TABLE & TOOLBAR ===== -->
      <div class="glass-card p-5 sm:p-7 space-y-6">
        
        <!-- Header Title & Controls -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 border-b border-white/[0.08] pb-6">
          <div>
            <div class="flex items-center gap-2 mb-1">
              <span class="w-2.5 h-2.5 rounded-full bg-blue-500 animate-ping"></span>
              <h2 class="text-xl sm:text-2xl font-black text-white tracking-tight">Laporan Audit Transaksi</h2>
            </div>
            <p class="text-xs sm:text-sm text-slate-400">Daftar rincian riwayat order kasir, status pembayaran, dan rekap produk</p>
          </div>

          <!-- Actions & Export -->
          <div class="flex flex-wrap items-center gap-3">
            <button
              @click="eksporCSV"
              class="px-5 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold flex items-center justify-center gap-2 transition-all shadow-lg shadow-emerald-600/30 active:scale-95"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
              Unduh Laporan CSV
            </button>
            <button
              @click="printRekapLaporan"
              class="px-5 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold flex items-center justify-center gap-2 transition-all shadow-lg shadow-indigo-600/30 active:scale-95"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
              Cetak Rekap Laporan
            </button>
          </div>
        </div>

        <!-- Filter & Period Selector Bar -->
        <div class="glass-card p-4 space-y-4">
          <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
            
            <!-- Search Input -->
            <div class="relative w-full md:w-80">
              <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0" />
              </svg>
              <input
                v-model="search"
                @input="handleSearch"
                type="text"
                placeholder="Cari No. Nota (contoh: TRX-178...)"
                class="input-elegant pl-11 pr-10 py-2.5 text-sm w-full font-mono"
              />
              <button v-if="search" @click="search = ''; handleSearch();" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-white">
                ✕
              </button>
            </div>

            <!-- Quick Period Filter Buttons -->
            <div class="flex flex-wrap items-center gap-1.5 bg-slate-950/60 p-1.5 rounded-xl border border-white/[0.06]">
              <button
                v-for="p in periods"
                :key="p.id"
                @click="setPeriod(p.id)"
                class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-all duration-200"
                :class="selectedPeriod === p.id ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30 font-bold' : 'text-slate-400 hover:text-white hover:bg-white/[0.05]'"
              >
                {{ p.label }}
              </button>
            </div>

          </div>

          <!-- Custom Date Range Inputs (Shown when selectedPeriod === 'custom') -->
          <div v-if="selectedPeriod === 'custom'" class="pt-3 border-t border-white/[0.06] flex flex-wrap items-center gap-3">
            <span class="text-xs font-bold text-slate-300">📅 Rentang Tanggal Custom:</span>
            <div class="flex items-center gap-2">
              <input v-model="startDate" type="date" class="input-elegant py-1.5 px-3 text-xs font-mono text-white bg-slate-900" />
              <span class="text-xs text-slate-500">s/d</span>
              <input v-model="endDate" type="date" class="input-elegant py-1.5 px-3 text-xs font-mono text-white bg-slate-900" />
              <button @click="loadRiwayat(1)" class="px-4 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold shadow-md shadow-blue-600/30">
                Terapkan
              </button>
            </div>
          </div>
        </div>

        <!-- ===== MOBILE CARD LIST (HP & TABLET) ===== -->
        <div class="md:hidden space-y-4">
          <div v-if="isLoading" class="py-16 text-center">
            <div class="w-10 h-10 rounded-full border-3 border-blue-500 border-t-transparent animate-spin mx-auto mb-3"></div>
            <p class="text-slate-400 text-sm font-medium">Memuat data transaksi...</p>
          </div>

          <div v-else-if="transaksi.length === 0" class="py-16 text-center glass-card p-8 space-y-3">
            <div class="w-16 h-16 rounded-2xl bg-white/[0.04] border border-white/[0.08] flex items-center justify-center mx-auto">
              <svg class="w-8 h-8 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
            </div>
            <p class="text-slate-300 font-bold text-base">Tidak ada transaksi ditemukan</p>
            <p class="text-slate-500 text-xs">Coba kata kunci pencarian yang lain.</p>
          </div>

          <div
            v-else
            v-for="item in transaksi"
            :key="item.id"
            class="p-4 rounded-2xl bg-white/[0.03] border border-white/[0.08] space-y-3 shadow-xl hover:border-blue-500/30 transition-all overflow-hidden w-full"
          >
            <!-- Card Header -->
            <div class="flex items-center justify-between border-b border-white/[0.06] pb-3">
              <div>
                <span class="font-mono text-xs font-black text-blue-400 bg-blue-500/15 px-3 py-1 rounded-lg border border-blue-500/30">
                  {{ item.no_nota }}
                </span>
                <p class="text-[11px] text-slate-400 mt-1.5 font-medium">{{ formatTanggal(item.created_at) }}</p>
              </div>
              <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-500/15 text-emerald-300 border border-emerald-500/30">
                ✓ LUNAS (TUNAI)
              </span>
            </div>

            <!-- Item List Breakdown -->
            <div class="space-y-2">
              <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Item Dibeli ({{ item.items?.length || 0 }} Rincian)</p>
              <div v-for="it in item.items" :key="it.id" class="p-2.5 rounded-xl bg-slate-900/60 border border-white/[0.04] flex items-center justify-between">
                <div>
                  <p class="text-xs font-bold text-white">{{ it.nama_barang }}</p>
                  <p class="text-[11px] text-slate-400">{{ it.qty }} unit × Rp {{ Number(it.harga).toLocaleString('id-ID') }}</p>
                </div>
                <span class="text-xs font-bold text-blue-300 font-mono">
                  Rp {{ Number(it.subtotal).toLocaleString('id-ID') }}
                </span>
              </div>
            </div>

            <!-- Payment Summary -->
            <div class="p-3 rounded-xl bg-white/[0.02] border border-white/[0.04] space-y-1.5">
              <div class="flex justify-between text-xs text-slate-400">
                <span>Tunai Dibayar:</span>
                <span class="text-white font-medium">Rp {{ Number(item.bayar).toLocaleString('id-ID') }}</span>
              </div>
              <div class="flex justify-between text-xs text-slate-400">
                <span>Kembalian:</span>
                <span class="text-emerald-400 font-bold">Rp {{ Number(item.kembali).toLocaleString('id-ID') }}</span>
              </div>
              <div class="border-t border-white/[0.06] pt-1.5 flex justify-between items-center">
                <span class="text-xs font-bold text-slate-300">Total Belanja</span>
                <span class="text-lg font-black text-gradient">Rp {{ Number(item.total_harga).toLocaleString('id-ID') }}</span>
              </div>
            </div>

            <!-- Action Button -->
            <button
              @click="bukaStruk(item)"
              class="w-full py-3 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs flex items-center justify-center gap-2 shadow-lg shadow-blue-600/30 transition-all"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
              Cetak Ulang Struk Nota
            </button>
          </div>
        </div>

        <!-- ===== DESKTOP HIGH-DETAIL DATA TABLE (PC & LAPTOP) ===== -->
        <div class="hidden md:block w-full overflow-x-auto rounded-2xl border border-white/[0.08]">
          <table class="w-full min-w-[900px] text-sm">
            <thead>
              <tr class="bg-slate-900/80 border-b border-white/[0.08] text-slate-400">
                <th class="py-4 px-6 text-left text-xs font-bold uppercase tracking-wider w-12">#</th>
                <th class="py-4 px-6 text-left text-xs font-bold uppercase tracking-wider">No. Nota</th>
                <th class="py-4 px-6 text-left text-xs font-bold uppercase tracking-wider">Ringkasan Produk</th>
                <th class="py-4 px-6 text-left text-xs font-bold uppercase tracking-wider">Total Pembelian</th>
                <th class="py-4 px-6 text-left text-xs font-bold uppercase tracking-wider">Nominal Bayar</th>
                <th class="py-4 px-6 text-left text-xs font-bold uppercase tracking-wider">Kembalian</th>
                <th class="py-4 px-6 text-left text-xs font-bold uppercase tracking-wider">Waktu Transaksi</th>
                <th class="py-4 px-6 text-center text-xs font-bold uppercase tracking-wider">Aksi & Struk</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-white/[0.05]">
              <!-- Loading Skeleton -->
              <template v-if="isLoading">
                <tr v-for="n in 5" :key="n" class="animate-pulse">
                  <td class="py-4 px-6"><div class="h-4 w-4 bg-white/10 rounded"></div></td>
                  <td class="py-4 px-6"><div class="h-6 w-28 bg-white/10 rounded-lg"></div></td>
                  <td class="py-4 px-6"><div class="h-6 w-48 bg-white/10 rounded-lg"></div></td>
                  <td class="py-4 px-6"><div class="h-5 w-24 bg-white/10 rounded"></div></td>
                  <td class="py-4 px-6"><div class="h-5 w-20 bg-white/10 rounded"></div></td>
                  <td class="py-4 px-6"><div class="h-5 w-20 bg-white/10 rounded"></div></td>
                  <td class="py-4 px-6"><div class="h-4 w-28 bg-white/10 rounded"></div></td>
                  <td class="py-4 px-6"><div class="h-8 w-20 bg-white/10 rounded-xl mx-auto"></div></td>
                </tr>
              </template>

              <!-- Empty -->
              <tr v-else-if="transaksi.length === 0">
                <td colspan="8" class="py-20 text-center">
                  <div class="flex flex-col items-center gap-3 max-w-sm mx-auto">
                    <div class="w-16 h-16 rounded-2xl bg-white/[0.04] border border-white/[0.08] flex items-center justify-center">
                      <svg class="w-8 h-8 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                    </div>
                    <p class="text-white font-bold text-base">Belum ada riwayat transaksi</p>
                    <p class="text-slate-500 text-xs">Semua transaksi penjualan kasir yang sukses akan tercatat secara detail di tabel ini.</p>
                  </div>
                </td>
              </tr>

              <!-- Rows -->
              <template v-else v-for="(item, index) in transaksi" :key="item.id">
                <tr
                  @click="toggleExpand(item.id)"
                  class="hover:bg-white/[0.04] transition-colors duration-150 cursor-pointer group"
                  :class="expandedId === item.id ? 'bg-blue-500/10' : ''"
                >
                  <td class="py-4 px-6 text-slate-500 text-xs font-mono">
                    {{ (pagination.current_page - 1) * pagination.per_page + index + 1 }}
                  </td>
                  <td class="py-4 px-6">
                    <span class="font-mono text-xs px-3 py-1.5 rounded-xl bg-blue-500/10 border border-blue-500/20 text-blue-300 font-bold group-hover:border-blue-400/50 transition-colors">
                      {{ item.no_nota }}
                    </span>
                  </td>
                  <td class="py-4 px-4">
                    <div class="flex flex-wrap items-center gap-1.5 max-w-[280px]">
                      <span
                        v-for="it in item.items?.slice(0, 2)"
                        :key="it.id"
                        class="text-xs px-2 py-1 rounded-lg bg-white/[0.05] border border-white/[0.08] text-slate-200 font-medium truncate max-w-[160px]"
                      >
                        {{ it.nama_barang }} <span class="text-blue-400 font-bold">×{{ it.qty }}</span>
                      </span>
                      <span
                        v-if="item.items?.length > 2"
                        class="text-xs px-2 py-1 rounded-lg bg-sky-500/15 border border-sky-500/25 text-sky-300 font-bold"
                      >
                        +{{ item.items.length - 2 }} lainnya
                      </span>
                    </div>
                  </td>
                  <td class="py-4 px-6">
                    <span class="text-base font-black text-white">
                      Rp {{ Number(item.total_harga).toLocaleString('id-ID') }}
                    </span>
                  </td>
                  <td class="py-4 px-6 text-slate-300 font-medium">
                    Rp {{ Number(item.bayar).toLocaleString('id-ID') }}
                  </td>
                  <td class="py-4 px-6 font-bold text-emerald-400">
                    Rp {{ Number(item.kembali).toLocaleString('id-ID') }}
                  </td>
                  <td class="py-4 px-6 text-slate-400 text-xs font-medium">
                    {{ formatTanggal(item.created_at) }}
                  </td>
                  <td class="py-4 px-6 text-center">
                    <div class="flex items-center justify-center gap-2">
                      <button
                        @click.stop="bukaStruk(item)"
                        class="px-3.5 py-1.5 rounded-xl bg-blue-500/15 hover:bg-blue-500/25 text-blue-300 border border-blue-500/30 text-xs font-bold flex items-center gap-1.5 transition-all active:scale-95"
                      >
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                        Struk
                      </button>
                      <button
                        class="w-7 h-7 rounded-lg bg-white/[0.05] border border-white/[0.08] flex items-center justify-center text-slate-400 hover:text-white transition-transform"
                        :class="expandedId === item.id ? 'rotate-180 text-blue-400' : ''"
                      >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                      </button>
                    </div>
                  </td>
                </tr>

                <!-- Expanded High-Detail Section -->
                <Transition
                  enter-active-class="transition-all duration-300 ease-out"
                  enter-from-class="opacity-0 translate-y-[-10px]"
                  enter-to-class="opacity-100 translate-y-0"
                  leave-active-class="transition-all duration-200 ease-in"
                  leave-from-class="opacity-100 translate-y-0"
                  leave-to-class="opacity-0 translate-y-[-10px]"
                >
                  <tr v-if="expandedId === item.id" class="bg-slate-900/90 border-b border-white/[0.08]">
                    <td colspan="8" class="p-6">
                      <div class="glass-card p-6 border-l-4 border-l-blue-500 space-y-5">
                        
                        <div class="flex items-center justify-between border-b border-white/[0.08] pb-4">
                          <div>
                            <h4 class="text-base font-extrabold text-white flex items-center gap-2">
                              <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                              Rincian Lengkap Nota {{ item.no_nota }}
                            </h4>
                            <p class="text-xs text-slate-400 mt-0.5">Waktu Transaksi: {{ formatTanggal(item.created_at) }}</p>
                          </div>
                          <span class="px-3.5 py-1.5 rounded-full text-xs font-bold bg-emerald-500/15 text-emerald-300 border border-emerald-500/30">
                            Status: LUNAS / TERBAYAR
                          </span>
                        </div>

                        <!-- Item Detail Grid -->
                        <div class="space-y-3">
                          <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Daftar Barang Dibeli:</p>
                          <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div
                              v-for="it in item.items"
                              :key="it.id"
                              class="p-4 rounded-xl bg-white/[0.03] border border-white/[0.06] flex items-center justify-between"
                            >
                              <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400 font-bold text-sm">
                                  📦
                                </div>
                                <div>
                                  <p class="text-sm font-bold text-white">{{ it.nama_barang }}</p>
                                  <p class="text-xs text-slate-400 mt-0.5">{{ it.qty }} unit × Rp {{ Number(it.harga).toLocaleString('id-ID') }}</p>
                                </div>
                              </div>
                              <span class="text-sm font-extrabold text-blue-300 font-mono">
                                Rp {{ Number(it.subtotal).toLocaleString('id-ID') }}
                              </span>
                            </div>
                          </div>
                        </div>

                        <!-- Financial Summary Box -->
                        <div class="p-4 rounded-xl bg-slate-950/80 border border-white/[0.08] flex flex-col sm:flex-row items-center justify-between gap-4">
                          <div class="flex items-center gap-6 text-xs text-slate-300">
                            <div>
                              <span class="text-slate-500 block">Metode Pembayaran</span>
                              <span class="font-bold text-white">Uang Tunai (Cash)</span>
                            </div>
                            <div>
                              <span class="text-slate-500 block">Nominal Tunai</span>
                              <span class="font-bold text-white">Rp {{ Number(item.bayar).toLocaleString('id-ID') }}</span>
                            </div>
                            <div>
                              <span class="text-slate-500 block">Kembalian</span>
                              <span class="font-bold text-emerald-400">Rp {{ Number(item.kembali).toLocaleString('id-ID') }}</span>
                            </div>
                          </div>

                          <button
                            @click="bukaStruk(item)"
                            class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs flex items-center gap-2 transition-all shadow-lg shadow-blue-600/30"
                          >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                            Cetak Ulang Struk Thermal 80mm
                          </button>
                        </div>

                      </div>
                    </td>
                  </tr>
                </Transition>
              </template>
            </tbody>
          </table>
        </div>

        <!-- Pagination Bar -->
        <div v-if="pagination.last_page > 1" class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 border-t border-white/[0.06]">
          <p class="text-xs sm:text-sm text-slate-400">
            Menampilkan data <span class="text-white font-bold">{{ pagination.from }}</span> sampai <span class="text-white font-bold">{{ pagination.to }}</span> dari total <span class="text-white font-bold">{{ pagination.total }}</span> transaksi
          </p>
          <div class="flex items-center gap-1.5">
            <button
              @click="changePage(pagination.current_page - 1)"
              :disabled="pagination.current_page === 1"
              class="px-3.5 py-2 rounded-xl text-xs font-semibold border transition-all"
              :class="pagination.current_page === 1 ? 'border-white/[0.06] text-slate-600 cursor-not-allowed' : 'border-white/[0.1] text-slate-300 hover:bg-white/[0.08] hover:text-white'"
            >
              ← Prev
            </button>

            <button
              v-for="page in visiblePages"
              :key="page"
              @click="changePage(page)"
              class="w-9 h-9 rounded-xl text-xs font-bold border transition-all"
              :class="page === pagination.current_page ? 'bg-blue-600 border-blue-500 text-white shadow-lg shadow-blue-600/30' : 'border-white/[0.08] text-slate-400 hover:bg-white/[0.06] hover:text-white'"
            >
              {{ page }}
            </button>

            <button
              @click="changePage(pagination.current_page + 1)"
              :disabled="pagination.current_page === pagination.last_page"
              class="px-3.5 py-2 rounded-xl text-xs font-semibold border transition-all"
              :class="pagination.current_page === pagination.last_page ? 'border-white/[0.06] text-slate-600 cursor-not-allowed' : 'border-white/[0.1] text-slate-300 hover:bg-white/[0.08] hover:text-white'"
            >
              Next →
            </button>
          </div>
        </div>

      </div>
    </main>

    <!-- ===== MODAL STRUK PREVIEW REALISTIK (THERMAL 80mm) ===== -->
    <Transition
      enter-active-class="transition-all duration-300 ease-out"
      enter-from-class="opacity-0 scale-95"
      enter-to-class="opacity-100 scale-100"
      leave-active-class="transition-all duration-200 ease-in"
      leave-from-class="opacity-100 scale-100"
      leave-to-class="opacity-0 scale-95"
    >
      <div v-if="struk.show" class="fixed inset-0 z-50 flex items-start justify-center p-4 pt-6 sm:pt-10 pb-12 overflow-y-auto">
        <div class="fixed inset-0 bg-black/85 backdrop-blur-md" @click="tutupStruk"></div>

        <div class="relative z-10 w-full max-w-[390px] my-auto animate-fade-in-up">
          
          <!-- Thermal Paper Container -->
          <div class="bg-amber-50/95 text-slate-900 rounded-t-2xl shadow-2xl p-6 font-mono text-xs relative overflow-hidden border border-amber-200/50 max-h-[85vh] overflow-y-auto elegant-scroll-light">
            
            <!-- Watermark / Background Texture accent -->
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-blue-500/5 rounded-full blur-2xl pointer-events-none"></div>

            <!-- Receipt Header -->
            <div class="text-center pb-4 border-b border-dashed border-slate-400 space-y-1">
              <div class="flex items-center justify-center gap-1.5 mb-1">
                <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                <h3 class="text-lg font-black tracking-widest text-slate-900 uppercase">CLOUVIA DIGITAL</h3>
              </div>
              <p class="text-[10px] font-bold text-slate-600 tracking-wider uppercase">IT & Computer Store Center</p>
              <p class="text-[9px] text-slate-500">Jl. Komputer Raya No. 88, Cyber City</p>
              <p class="text-[9px] text-slate-500">Telp: (021) 555-0199 | CS: 0812-9900-8800</p>
            </div>

            <!-- Meta Details -->
            <div class="py-3 border-b border-dashed border-slate-400 space-y-1 text-[11px]">
              <div class="flex justify-between">
                <span class="text-slate-600">No. Nota:</span>
                <span class="font-bold font-mono text-slate-900">{{ struk.no_nota }}</span>
              </div>
              <div class="flex justify-between">
                <span class="text-slate-600">Waktu:</span>
                <span class="font-semibold text-slate-800">{{ struk.tanggal }}</span>
              </div>
              <div class="flex justify-between">
                <span class="text-slate-600">Kasir:</span>
                <span class="font-semibold text-slate-800">Admin Executive</span>
              </div>
              <div class="flex justify-between">
                <span class="text-slate-600">Status:</span>
                <span class="font-bold text-emerald-700 bg-emerald-100 px-1.5 py-0.5 rounded text-[10px]">LUNAS (TUNAI)</span>
              </div>
            </div>

            <!-- Items Table (Scrollable when items > 4) -->
            <div class="py-3 border-b border-dashed border-slate-400 space-y-2.5 max-h-60 overflow-y-auto pr-1">
              <div v-for="it in struk.items" :key="it.id" class="space-y-0.5">
                <div class="flex justify-between items-start">
                  <span class="font-bold text-slate-900 leading-tight flex-1 pr-2 truncate">{{ it.nama_barang }}</span>
                  <span class="font-bold text-slate-900 font-mono whitespace-nowrap">Rp {{ Number(it.subtotal || (it.harga * it.qty)).toLocaleString('id-ID') }}</span>
                </div>
                <div class="flex justify-between text-[10px] text-slate-600">
                  <span>{{ it.qty }} unit × Rp {{ Number(it.harga).toLocaleString('id-ID') }}</span>
                </div>
              </div>
            </div>

            <!-- Financial Summary -->
            <div class="py-3 space-y-1.5 text-[11px]">
              <div class="flex justify-between text-slate-600">
                <span>Subtotal ({{ struk.items?.reduce((a,c) => a + c.qty, 0) || struk.items?.length || 0 }} item):</span>
                <span class="font-semibold text-slate-800">Rp {{ Number(struk.subtotal || struk.total_harga).toLocaleString('id-ID') }}</span>
              </div>
              <div v-if="struk.diskon > 0" class="flex justify-between font-bold text-amber-700">
                <span>Diskon Promo:</span>
                <span>-Rp {{ Number(struk.diskon).toLocaleString('id-ID') }}</span>
              </div>
              <div class="flex justify-between text-slate-600">
                <span>Tunai Dibayar:</span>
                <span class="font-semibold text-slate-800">Rp {{ Number(struk.bayar).toLocaleString('id-ID') }}</span>
              </div>
              <div class="border-t border-slate-300 pt-1.5 flex justify-between items-center">
                <span class="font-black text-slate-900 text-xs">KEMBALIAN:</span>
                <span class="text-base font-black text-emerald-700 font-mono">Rp {{ Number(struk.kembali).toLocaleString('id-ID') }}</span>
              </div>
            </div>

            <!-- Barcode & Footer -->
            <div class="pt-4 border-t border-dashed border-slate-400 text-center space-y-2">
              <div class="font-mono text-xl font-bold tracking-[6px] text-slate-800 select-none">
                ||||||||||||||||||||||||
              </div>
              <p class="text-[9px] font-bold text-slate-700">Terima kasih atas kunjungan Anda!</p>
              <p class="text-[8px] text-slate-500">Garansi Toko 1 Tahun. Simpan struk ini sebagai bukti klaim garansi yang sah.</p>
            </div>

          </div>

          <!-- Torn Paper Zig-zag Bottom Edge -->
          <div class="w-full h-3 bg-amber-50/95 shadow-lg relative overflow-hidden" style="background-image: radial-gradient(circle, transparent, transparent 50%, #fffbeb 50%, #fffbeb 100%); background-size: 12px 12px; background-position: -6px -6px;"></div>

          <!-- Action Buttons -->
          <div class="flex gap-3 mt-4">
            <button
              @click="tutupStruk"
              class="flex-1 py-3.5 rounded-xl bg-slate-700 hover:bg-slate-600 text-white font-bold text-xs border border-slate-600 transition-all"
            >
              Tutup
            </button>
            <button
              @click="printStruk"
              class="flex-1 py-3.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs flex items-center justify-center gap-2 shadow-lg shadow-indigo-600/40 transition-all active:scale-95"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
              Cetak Struk (Thermal 80mm)
            </button>
          </div>

        </div>
      </div>
    </Transition>

  </div>
</template>

<script setup>
const token = useCookie('token');
const transaksi = ref([]);
const isLoading = ref(false);
const search = ref('');
const expandedId = ref(null);

const selectedPeriod = ref('semua');
const startDate = ref('');
const endDate = ref('');

const periods = [
  { id: 'semua', label: 'Semua Transaksi' },
  { id: 'today', label: 'Hari Ini' },
  { id: '7days', label: '7 Hari Terakhir' },
  { id: 'month', label: 'Bulan Ini' },
  { id: 'custom', label: 'Custom Tanggal' },
];

const setPeriod = (periodId) => {
  selectedPeriod.value = periodId;
  if (periodId !== 'custom') {
    loadRiwayat(1);
  }
};

const pagination = ref({
  current_page: 1,
  last_page: 1,
  per_page: 10,
  total: 0,
  from: 0,
  to: 0,
});

// Struk state
const struk = ref({ show: false, no_nota: '', tanggal: '', items: [], diskon: 0, total_harga: 0, bayar: 0, kembali: 0 });

let searchDebounce = null;

const totalOmzet = computed(() =>
  transaksi.value.reduce((sum, t) => sum + Number(t.total_harga || 0), 0)
);

const totalItemTerjual = computed(() =>
  transaksi.value.reduce((sum, t) => {
    const qtyCount = t.items ? t.items.reduce((q, item) => q + Number(item.qty || 0), 0) : 0;
    return sum + qtyCount;
  }, 0)
);

const rataRataOrder = computed(() => {
  if (transaksi.value.length === 0) return 0;
  return Math.round(totalOmzet.value / transaksi.value.length);
});

const visiblePages = computed(() => {
  const current = pagination.value.current_page;
  const last = pagination.value.last_page;
  const pages = [];
  const start = Math.max(1, current - 2);
  const end = Math.min(last, current + 2);
  for (let i = start; i <= end; i++) pages.push(i);
  return pages;
});

const formatTanggal = (dateStr) => {
  if (!dateStr) return '-';
  const d = new Date(dateStr);
  return d.toLocaleString('id-ID', {
    day: '2-digit', month: 'short', year: 'numeric',
    hour: '2-digit', minute: '2-digit',
  });
};

const toggleExpand = (id) => {
  expandedId.value = expandedId.value === id ? null : id;
};

const loadRiwayat = async (page = 1) => {
  isLoading.value = true;
  expandedId.value = null;
  try {
    const params = new URLSearchParams({ page });
    if (search.value) params.append('search', search.value);

    if (selectedPeriod.value === 'custom' && startDate.value && endDate.value) {
      params.append('start_date', startDate.value);
      params.append('end_date', endDate.value);
    } else if (selectedPeriod.value !== 'semua' && selectedPeriod.value !== 'custom') {
      params.append('period', selectedPeriod.value);
    }

    const res = await $fetch(
      `http://localhost/crud-laravel/public/api/transaksi?${params.toString()}`,
      { headers: { Authorization: `Bearer ${token.value}` } }
    );

    transaksi.value = res.data;
    pagination.value = {
      current_page: res.current_page,
      last_page: res.last_page,
      per_page: res.per_page,
      total: res.total,
      from: res.from ?? 0,
      to: res.to ?? 0,
    };
  } catch (err) {
    if (err.status === 401 || err.status === 403) navigateTo('/');
  } finally {
    isLoading.value = false;
  }
};

const changePage = (page) => {
  if (page < 1 || page > pagination.value.last_page) return;
  loadRiwayat(page);
};

const handleSearch = () => {
  clearTimeout(searchDebounce);
  searchDebounce = setTimeout(() => loadRiwayat(1), 400);
};

// Fitur Ekspor CSV Laporan Transaksi
const eksporCSV = () => {
  if (transaksi.value.length === 0) return alert('Tidak ada data transaksi untuk diekspor.');
  
  let csvContent = 'data:text/csv;charset=utf-8,';
  csvContent += 'No. Nota,Tanggal,Item Dibeli,Total Harga (Rp),Bayar (Rp),Kembalian (Rp)\n';

  transaksi.value.forEach(t => {
    const items = t.items ? t.items.map(i => `${i.nama_barang} (x${i.qty})`).join('; ') : '';
    const row = `"${t.no_nota}","${formatTanggal(t.created_at)}","${items}",${t.total_harga},${t.bayar},${t.kembali}`;
    csvContent += row + '\n';
  });

  const encodedUri = encodeURI(csvContent);
  const link = document.createElement('a');
  link.setAttribute('href', encodedUri);
  link.setAttribute('download', `laporan_transaksi_${new Date().toISOString().slice(0, 10)}.csv`);
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
};

// Fitur Cetak Rekap Laporan
const printRekapLaporan = () => {
  if (transaksi.value.length === 0) return alert('Tidak ada data transaksi untuk dicetak.');

  const rowsHtml = transaksi.value.map((t, i) => `
    <tr>
      <td style="padding:8px;border-bottom:1px solid #eee;">${i + 1}</td>
      <td style="padding:8px;border-bottom:1px solid #eee;font-family:monospace;font-weight:bold;">${t.no_nota}</td>
      <td style="padding:8px;border-bottom:1px solid #eee;">${t.items?.map(item => `${item.nama_barang} (${item.qty}x)`).join(', ')}</td>
      <td style="padding:8px;border-bottom:1px solid #eee;font-weight:bold;">Rp ${Number(t.total_harga).toLocaleString('id-ID')}</td>
      <td style="padding:8px;border-bottom:1px solid #eee;">${formatTanggal(t.created_at)}</td>
    </tr>
  `).join('');

  const html = `<!DOCTYPE html>
<html>
<head>
  <title>Rekap Laporan Transaksi - CLOUVIA Digital Service</title>
  <style>
    body { font-family: sans-serif; padding: 20px; color: #333; }
    h2 { margin-bottom: 5px; }
    p { font-size: 12px; color: #666; margin-bottom: 20px; }
    table { width: 100%; border-collapse: collapse; font-size: 13px; }
    th { background: #2563eb; color: #fff; padding: 10px; text-align: left; }
    .total-box { margin-top: 20px; padding: 15px; background: #f3f4f6; border-radius: 8px; font-weight: bold; }
  </style>
</head>
<body>
  <h2>CLOUVIA DIGITAL SERVICE</h2>
  <p>REKAP LAPORAN PENJUALAN AUDIT TRANSAKSI</p>

  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>No. Nota</th>
        <th>Rincian Produk</th>
        <th>Total Pembelian</th>
        <th>Waktu Transaksi</th>
      </tr>
    </thead>
    <tbody>
      ${rowsHtml}
    </tbody>
  </table>

  <div class="total-box">
    TOTAL OMSET PENJUALAN: Rp ${totalOmzet.value.toLocaleString('id-ID')} (Dari ${transaksi.value.length} Transaksi)
  </div>
</body>
</html>`;

  const printWin = window.open('', '_blank', 'width=800,height=600');
  printWin.document.write(html);
  printWin.document.close();
  printWin.focus();
  setTimeout(() => { printWin.print(); printWin.close(); }, 400);
};

onMounted(() => {
  if (!token.value) navigateTo('/');
  loadRiwayat();
});

const bukaStruk = (item) => {
  struk.value = {
    show: true,
    no_nota: item.no_nota,
    tanggal: formatTanggal(item.created_at),
    items: item.items ?? [],
    total_harga: item.total_harga,
    bayar: item.bayar,
    kembali: item.kembali,
  };
};

const tutupStruk = () => {
  struk.value.show = false;
};

const printStruk = () => {
  const s = struk.value;
  const itemsHtml = s.items.map(i => `
    <div style="margin-bottom:6px;">
      <div style="display:flex;justify-content:space-between;font-weight:bold;font-size:11px;">
        <span style="flex:1;padding-right:4px;">${i.nama_barang}</span>
        <span>Rp ${Number(i.subtotal || (i.harga * i.qty)).toLocaleString('id-ID')}</span>
      </div>
      <div style="font-size:10px;color:#444;">${i.qty} unit x Rp ${Number(i.harga).toLocaleString('id-ID')}</div>
    </div>
  `).join('');

  const html = `<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>Struk - ${s.no_nota}</title>
  <style>
    @page { size: 80mm auto; margin: 0; }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Courier New', Courier, monospace, sans-serif;
      width: 80mm;
      max-width: 80mm;
      margin: 0 auto;
      padding: 12px 10px;
      color: #000;
      background: #fff;
      font-size: 11px;
      line-height: 1.3;
    }
    .text-center { text-align: center; }
    .bold { font-weight: bold; }
    .brand { font-size: 15px; font-weight: 900; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 2px; }
    .sub { font-size: 9px; font-weight: bold; letter-spacing: 1px; text-transform: uppercase; color: #333; }
    .info { font-size: 9px; color: #444; margin-top: 2px; }
    .dashed { border-bottom: 1px dashed #000; margin: 8px 0; }
    .row { display: flex; justify-content: space-between; font-size: 10px; margin-bottom: 2px; }
    .total-row { display: flex; justify-content: space-between; font-size: 11px; margin-bottom: 3px; }
    .grand { display: flex; justify-content: space-between; font-size: 13px; font-weight: 900; padding: 4px 0; border-top: 1px dashed #000; border-bottom: 1px dashed #000; margin: 6px 0; }
    .barcode { margin: 8px auto 4px auto; text-align: center; letter-spacing: 4px; font-size: 16px; font-weight: bold; }
  </style>
</head>
<body>
  <div class="text-center">
    <div class="brand">CLOUVIA DIGITAL</div>
    <div class="sub">IT &amp; Computer Center</div>
    <div class="info">Jl. Komputer Raya No. 88, Cyber City</div>
    <div class="info">Telp: (021) 555-0199 | CS: 0812-9900-8800</div>
  </div>

  <div class="dashed"></div>

  <div class="row"><span>No. Nota:</span><span class="bold">${s.no_nota}</span></div>
  <div class="row"><span>Waktu:</span><span>${s.tanggal}</span></div>
  <div class="row"><span>Kasir:</span><span>Admin Executive</span></div>
  <div class="row"><span>Status:</span><span class="bold">LUNAS (TUNAI)</span></div>

  <div class="dashed"></div>

  ${itemsHtml}

  <div class="dashed"></div>

  <div class="total-row"><span>Subtotal (${s.items.length} item):</span><span>Rp ${Number(s.total_harga).toLocaleString('id-ID')}</span></div>
  <div class="total-row"><span>Tunai Dibayar:</span><span>Rp ${Number(s.bayar).toLocaleString('id-ID')}</span></div>
  <div class="grand"><span>KEMBALIAN:</span><span>Rp ${Number(s.kembali).toLocaleString('id-ID')}</span></div>

  <div class="dashed"></div>

  <div class="text-center">
    <div class="barcode">||||||||||||||||||||||</div>
    <p style="font-size:9px;font-weight:bold;margin-top:4px;">Terima kasih atas kunjungan Anda!</p>
    <p style="font-size:8px;color:#555;margin-top:2px;">Garansi Toko 1 Tahun. Simpan struk ini sebagai bukti resmi.</p>
  </div>
</body>
</html>`;

  const printWindow = window.open('', '_blank', 'width=400,height=700');
  printWindow.document.write(html);
  printWindow.document.close();
  printWindow.focus();
  setTimeout(() => { printWindow.print(); printWindow.close(); }, 400);
};
</script>