<template>
  <div v-if="token" class="min-h-screen flex flex-col pb-12">
    <!-- Navigation Header & Side Panel -->
    <AppHeader activePage="kasir" />

    <!-- Main Content -->
    <main class="flex-1 max-w-[1920px] mx-auto w-full px-3 sm:px-6 lg:px-8 space-y-5 pt-20">
      
      <!-- Top POS Info Bar -->
      <div class="glass-card p-4 sm:p-5 flex flex-col md:flex-row md:items-center justify-between gap-4 animate-fade-in-up">
        <div class="flex items-center gap-3.5">
          <div class="w-11 h-11 rounded-2xl bg-blue-500/15 border border-blue-500/30 flex items-center justify-center text-blue-400 shadow-lg shadow-blue-500/10">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z" /></svg>
          </div>
          <div>
            <h2 class="text-lg sm:text-xl font-black text-white tracking-tight flex items-center gap-2">
              Terminal Kasir POS
              <span class="text-xs px-2.5 py-0.5 rounded-full bg-emerald-500/15 text-emerald-400 border border-emerald-500/30 font-semibold">● Ready</span>
            </h2>
            <p class="text-xs text-slate-400">Pilih produk, terapkan diskon, dan proses pembayaran kilat</p>
          </div>
        </div>

        <!-- Hotkey Legend Badges -->
        <div class="flex flex-wrap items-center gap-2">
          <div class="px-2.5 py-1.5 rounded-lg bg-white/[0.04] border border-white/[0.08] text-[11px] text-slate-300 font-semibold flex items-center gap-1.5">
            <kbd class="px-1.5 py-0.5 rounded bg-slate-800 text-blue-400 border border-slate-700 font-mono font-bold text-[10px]">/</kbd> Focus Cari
          </div>
          <div class="px-2.5 py-1.5 rounded-lg bg-white/[0.04] border border-white/[0.08] text-[11px] text-slate-300 font-semibold flex items-center gap-1.5">
            <kbd class="px-1.5 py-0.5 rounded bg-slate-800 text-amber-400 border border-slate-700 font-mono font-bold text-[10px]">F2</kbd> Bayar Kilat
          </div>
          <div class="px-2.5 py-1.5 rounded-lg bg-white/[0.04] border border-white/[0.08] text-[11px] text-slate-300 font-semibold flex items-center gap-1.5">
            <kbd class="px-1.5 py-0.5 rounded bg-slate-800 text-emerald-400 border border-slate-700 font-mono font-bold text-[10px]">Esc</kbd> Tutup Struk
          </div>
        </div>
      </div>

      <!-- POS Main Grid (2 Columns: Left Catalog, Right Cart) -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
        
        <!-- LEFT SIDE: PRODUCT CATALOG & FILTER (7 Columns on Large Screens) -->
        <div class="lg:col-span-7 space-y-4">
          
          <!-- Search & Filter Category Bar -->
          <div class="glass-card p-4 space-y-3">
            <!-- Search Bar -->
            <div class="relative">
              <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0" />
              </svg>
              <input
                ref="searchInputRef"
                v-model="search"
                type="text"
                placeholder="Cari kode barang (COMP-001) atau nama produk... (Tekan '/')"
                class="input-elegant pl-11 pr-10 py-3 text-sm w-full"
              />
              <button v-if="search" @click="search = ''" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-white">
                ✕
              </button>
            </div>

            <!-- Category Pills Filter -->
            <div class="flex items-center gap-2 overflow-x-auto pb-1 elegant-scroll">
              <button
                v-for="cat in categories"
                :key="cat"
                @click="selectedCategory = cat"
                class="px-3.5 py-1.5 rounded-xl text-xs font-semibold whitespace-nowrap transition-all duration-200"
                :class="selectedCategory === cat ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30 font-bold' : 'bg-white/[0.04] text-slate-400 hover:text-white hover:bg-white/[0.08] border border-white/[0.06]'"
              >
                {{ cat }}
              </button>
            </div>
          </div>

          <!-- Product Catalog Grid -->
          <!-- Skeleton Loading -->
          <div v-if="isLoading" class="grid grid-cols-2 sm:grid-cols-3 gap-3 animate-pulse">
            <div v-for="n in 6" :key="n" class="h-48 rounded-2xl bg-white/[0.04] border border-white/[0.06] p-4 space-y-3">
              <div class="h-20 bg-white/10 rounded-xl"></div>
              <div class="h-4 w-28 bg-white/10 rounded"></div>
              <div class="h-4 w-16 bg-white/20 rounded"></div>
            </div>
          </div>

          <!-- Empty Catalog Alert -->
          <div v-else-if="barangFiltered.length === 0" class="py-16 text-center glass-card p-8 space-y-3">
            <div class="w-16 h-16 rounded-2xl bg-white/[0.04] border border-white/[0.08] flex items-center justify-center mx-auto">
              <svg class="w-8 h-8 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
            </div>
            <p class="text-slate-300 font-bold text-base">Tidak Ada Produk Ditemukan</p>
            <p class="text-slate-500 text-xs">Coba ubah kata kunci pencarian atau kategori filter.</p>
          </div>

          <!-- Catalog Cards -->
          <div v-else class="grid grid-cols-2 sm:grid-cols-3 gap-3 max-h-[620px] overflow-y-auto elegant-scroll pr-1">
            <div
              v-for="item in barangFiltered"
              :key="item.id"
              @click="tambahKeKeranjang(item)"
              class="glass-card p-3.5 flex flex-col justify-between cursor-pointer group hover:border-blue-500/50 hover:bg-white/[0.06] transition-all duration-200 relative overflow-hidden"
              :class="item.stok === 0 ? 'opacity-50 cursor-not-allowed' : ''"
            >
              <!-- Thumbnail Image Container -->
              <div class="w-full h-28 rounded-xl bg-slate-950/80 border border-white/[0.06] mb-2.5 overflow-hidden flex items-center justify-center relative">
                <img
                  v-if="item.gambar_url || item.gambar"
                  :src="item.gambar_url || getGambarUrl(item.gambar)"
                  class="w-full h-full object-contain p-2 group-hover:scale-105 transition-transform duration-300"
                  alt="Foto Produk"
                />
                <div v-else class="text-center p-2">
                  <svg class="w-8 h-8 text-slate-700 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                  <span class="text-[9px] text-slate-600 font-bold">NO IMAGE</span>
                </div>

                <!-- Category Badge Tag -->
                <span class="absolute top-1.5 left-1.5 px-2 py-0.5 rounded-md bg-slate-900/80 border border-white/10 text-[9px] font-bold text-slate-300 backdrop-blur-sm">
                  {{ item.kategori || 'Komputer' }}
                </span>
              </div>

              <!-- Product Details -->
              <div class="space-y-1">
                <p class="text-[10px] font-mono font-bold text-blue-400 uppercase tracking-wider">{{ item.kode_barang }}</p>
                <h4 class="text-xs font-bold text-white line-clamp-2 leading-tight group-hover:text-blue-300 transition-colors">{{ item.nama_barang }}</h4>
              </div>

              <!-- Price & Stock Footer -->
              <div class="pt-2.5 mt-2 border-t border-white/[0.06] flex items-center justify-between">
                <div>
                  <span class="text-[10px] text-slate-400 block">Harga</span>
                  <span class="text-xs sm:text-sm font-extrabold text-white font-mono">Rp {{ Number(item.harga).toLocaleString('id-ID') }}</span>
                </div>

                <span
                  class="px-2 py-0.5 rounded-md text-[10px] font-bold border"
                  :class="item.stok === 0 ? 'bg-red-500/15 text-red-400 border-red-500/20' : (item.stok <= 3 ? 'bg-amber-500/15 text-amber-400 border-amber-500/20' : 'bg-emerald-500/15 text-emerald-300 border-emerald-500/20')"
                >
                  {{ item.stok === 0 ? 'Habis' : (item.stok <= 3 ? `🔥 ${item.stok}` : `${item.stok} Stok`) }}
                </span>
              </div>
            </div>
          </div>

        </div>

        <!-- RIGHT SIDE: CART SIDEBAR & CHECKOUT (5 Columns on Large Screens) -->
        <div class="lg:col-span-5 space-y-4">
          <div class="glass-card p-4 sm:p-5 space-y-4 sticky top-24">
            
            <!-- Cart Header -->
            <div class="flex items-center justify-between border-b border-white/[0.08] pb-3.5">
              <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-blue-500/15 border border-blue-500/30 flex items-center justify-center text-blue-400 font-bold text-xs">
                  🛒
                </div>
                <div>
                  <h3 class="text-sm font-black text-white uppercase tracking-wider">Keranjang Belanja</h3>
                  <p class="text-xs text-slate-400">{{ keranjang.length }} jenis barang dipilih</p>
                </div>
              </div>

              <button
                v-if="keranjang.length > 0"
                @click="kosongkanKeranjang"
                class="text-xs text-red-400 hover:text-red-300 font-semibold hover:underline"
              >
                Kosongkan
              </button>
            </div>

            <!-- Cart Items List -->
            <div v-if="keranjang.length === 0" class="py-12 text-center space-y-2 border-2 border-dashed border-white/[0.06] rounded-2xl">
              <p class="text-slate-400 text-sm font-semibold">Keranjang Masih Kosong</p>
              <p class="text-slate-500 text-xs px-4">Klik pada produk di sebelah kiri untuk memasukkan barang ke keranjang.</p>
            </div>

            <div v-else class="space-y-3 max-h-[300px] overflow-y-auto elegant-scroll pr-1">
              <div
                v-for="item in keranjang"
                :key="item.id"
                class="p-3.5 rounded-xl bg-white/[0.03] border border-white/[0.06] flex items-center justify-between gap-3 group hover:border-blue-500/30 transition-all"
              >
                <!-- Thumbnail & Details -->
                <div class="flex items-center gap-3 min-w-0 flex-1">
                  <div class="w-10 h-10 rounded-lg bg-slate-950 border border-white/[0.08] flex-shrink-0 flex items-center justify-center overflow-hidden">
                    <img v-if="item.gambar_url || item.gambar" :src="item.gambar_url || getGambarUrl(item.gambar)" class="w-full h-full object-contain p-1" />
                    <span v-else class="text-[10px] text-slate-600 font-bold">POS</span>
                  </div>
                  <div class="min-w-0 flex-1">
                    <h4 class="text-xs font-bold text-white truncate leading-tight">{{ item.nama_barang }}</h4>
                    <p class="text-[11px] text-blue-400 font-semibold mt-0.5">Rp {{ Number(item.harga).toLocaleString('id-ID') }}</p>
                  </div>
                </div>

                <!-- Quantity Controls -->
                <div class="flex items-center gap-1.5 bg-slate-900/80 p-1 rounded-xl border border-white/[0.08]">
                  <button
                    @click="kurangiQty(item)"
                    class="w-6 h-6 rounded-lg bg-white/[0.05] hover:bg-white/10 text-white flex items-center justify-center text-xs font-bold transition-all"
                  >
                    -
                  </button>
                  <span class="w-7 text-center text-xs font-black text-white font-mono">{{ item.qty }}</span>
                  <button
                    @click="tambahQty(item)"
                    class="w-6 h-6 rounded-lg bg-blue-600 hover:bg-blue-500 text-white flex items-center justify-center text-xs font-bold transition-all"
                  >
                    +
                  </button>
                </div>

                <!-- Subtotal & Remove -->
                <div class="text-right flex-shrink-0 pl-1">
                  <p class="text-xs font-extrabold text-white font-mono">Rp {{ (item.harga * item.qty).toLocaleString('id-ID') }}</p>
                  <button @click="hapusItem(item)" class="text-[10px] text-red-400 hover:text-red-300 font-semibold mt-0.5">
                    Hapus
                  </button>
                </div>
              </div>
            </div>

            <!-- Financial Breakdown & Discount Box -->
            <div class="pt-4 border-t border-white/[0.08] space-y-3">
              
              <!-- Subtotal Belanja -->
              <div class="flex justify-between items-center text-xs text-slate-400">
                <span>Subtotal Items ({{ keranjang.reduce((a,c) => a + c.qty, 0) }} unit)</span>
                <span class="text-white font-semibold font-mono">Rp {{ subtotalBelanja.toLocaleString('id-ID') }}</span>
              </div>

              <!-- DISKON SECTION -->
              <div class="p-3 rounded-xl bg-white/[0.02] border border-white/[0.06] space-y-2">
                <div class="flex items-center justify-between">
                  <label class="text-xs font-bold text-slate-300 flex items-center gap-1">
                    <span>🏷️ Diskon Promo</span>
                  </label>
                  
                  <!-- Diskon Type Selector -->
                  <div class="flex rounded-lg bg-slate-900 border border-white/10 p-0.5">
                    <button
                      type="button"
                      @click="diskonTipe = 'nominal'"
                      class="px-2 py-0.5 rounded text-[10px] font-bold transition-all"
                      :class="diskonTipe === 'nominal' ? 'bg-blue-600 text-white' : 'text-slate-400 hover:text-white'"
                    >
                      Rp (Nominal)
                    </button>
                    <button
                      type="button"
                      @click="diskonTipe = 'persen'"
                      class="px-2 py-0.5 rounded text-[10px] font-bold transition-all"
                      :class="diskonTipe === 'persen' ? 'bg-blue-600 text-white' : 'text-slate-400 hover:text-white'"
                    >
                      % (Persen)
                    </button>
                  </div>
                </div>

                <div class="flex items-center gap-2">
                  <input
                    v-model.number="diskonInput"
                    type="number"
                    min="0"
                    :placeholder="diskonTipe === 'persen' ? 'Contoh: 10 (%)' : 'Contoh: 50000 (Rp)'"
                    class="input-elegant py-1.5 px-3 text-xs font-bold font-mono flex-1"
                  />
                  <span v-if="diskonNominal > 0" class="text-xs font-bold text-amber-400 whitespace-nowrap">
                    -Rp {{ diskonNominal.toLocaleString('id-ID') }}
                  </span>
                </div>
              </div>

              <!-- Total Tagihan Akhir -->
              <div class="flex justify-between items-center p-3.5 rounded-xl bg-blue-600/10 border border-blue-500/20">
                <span class="text-xs font-bold text-slate-300">Total Tagihan (Grand Total)</span>
                <span class="text-xl font-black text-white tracking-tight">
                  Rp {{ totalHarga.toLocaleString('id-ID') }}
                </span>
              </div>

              <!-- Payment Input Deck -->
              <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Nominal Tunai (Bayar)</label>
                <div class="relative">
                  <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-blue-400 font-black text-xs pointer-events-none">Rp</span>
                  <input
                    ref="bayarInputRef"
                    v-model.number="bayar"
                    type="number"
                    placeholder="0"
                    class="input-elegant pl-10 pr-3 py-3 text-base font-black tracking-wide"
                  />
                </div>
              </div>

              <!-- Process Button -->
              <button
                @click="prosesTransaksi"
                :disabled="bayar < totalHarga || totalHarga === 0 || keranjang.length === 0"
                class="w-full py-3.5 rounded-xl font-black text-sm text-white shadow-xl transition-all duration-200 flex items-center justify-center gap-2 active:scale-95"
                :class="bayar >= totalHarga && totalHarga > 0 && keranjang.length > 0 ? 'bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 shadow-emerald-600/30' : 'bg-slate-800 text-slate-500 cursor-not-allowed border border-white/[0.05]'"
              >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                {{ bayar < totalHarga && totalHarga > 0 ? 'Uang Belum Cukup' : 'Bayar & Selesaikan Transaksi (F2)' }}
              </button>

            </div>

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

            <!-- Items List Breakdown (Scrollable when items > 4) -->
            <div class="py-3 border-b border-dashed border-slate-400 space-y-2.5 max-h-60 overflow-y-auto pr-1">
              <div v-for="item in struk.items" :key="item.id" class="space-y-0.5">
                <div class="flex justify-between font-bold text-slate-900">
                  <span class="flex-1 pr-2 truncate">{{ item.nama_barang }}</span>
                  <span class="font-mono whitespace-nowrap">Rp {{ Number(item.harga * item.qty).toLocaleString('id-ID') }}</span>
                </div>
                <div class="text-[10px] text-slate-500">
                  {{ item.qty }} unit × Rp {{ Number(item.harga).toLocaleString('id-ID') }}
                </div>
              </div>
            </div>

            <!-- Summary Totals & Discount -->
            <div class="py-3 border-b border-dashed border-slate-400 space-y-1.5 text-[11px]">
              <div class="flex justify-between text-slate-600">
                <span>Subtotal ({{ struk.items?.reduce((a,c) => a + c.qty, 0) || 0 }} item):</span>
                <span>Rp {{ Number(struk.subtotal || struk.total_harga).toLocaleString('id-ID') }}</span>
              </div>
              
              <div v-if="struk.diskon > 0" class="flex justify-between font-bold text-amber-700">
                <span>Diskon Promo:</span>
                <span>-Rp {{ Number(struk.diskon).toLocaleString('id-ID') }}</span>
              </div>

              <div class="flex justify-between text-slate-600">
                <span>Tunai Dibayar:</span>
                <span>Rp {{ Number(struk.bayar).toLocaleString('id-ID') }}</span>
              </div>
              <div class="flex justify-between text-sm font-black text-slate-900 pt-1 border-t border-slate-300">
                <span>KEMBALIAN:</span>
                <span class="text-emerald-700">Rp {{ Number(struk.kembali).toLocaleString('id-ID') }}</span>
              </div>
            </div>

            <!-- Barcode & Footer -->
            <div class="pt-4 text-center space-y-2">
              <div class="font-mono text-base font-black tracking-widest text-slate-800 select-none">
                ||||||||||||||||||||||||||||
              </div>
              <p class="text-[10px] font-bold text-slate-800 uppercase tracking-wider">Terima kasih atas kunjungan Anda!</p>
              <p class="text-[8px] text-slate-500 leading-tight">
                Garansi Toko 1 Tahun. Simpan struk ini sebagai bukti klaim garansi yang sah.
              </p>
            </div>

            <!-- Jagged Edge Tear Effect Bottom -->
            <div class="absolute -bottom-2 left-0 right-0 h-4 bg-slate-900" style="clip-path: polygon(0% 100%, 5% 0%, 10% 100%, 15% 0%, 20% 100%, 25% 0%, 30% 100%, 35% 0%, 40% 100%, 45% 0%, 50% 100%, 55% 0%, 60% 100%, 65% 0%, 70% 100%, 75% 0%, 80% 100%, 85% 0%, 90% 100%, 95% 0%, 100% 100%);"></div>
          </div>

          <!-- Action Buttons -->
          <div class="flex gap-3 mt-4">
            <button
              @click="tutupStruk"
              class="flex-1 py-3.5 rounded-xl bg-slate-700 hover:bg-slate-600 text-white font-bold text-xs border border-slate-600 transition-all"
            >
              Tutup (Esc)
            </button>
            <button
              @click="printStruk"
              class="flex-1 py-3.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs flex items-center justify-center gap-2 shadow-lg shadow-indigo-600/40 transition-all active:scale-95"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
              Cetak Struk
            </button>
          </div>

        </div>
      </div>
    </Transition>

    <!-- TOAST NOTIFICATION -->
    <Transition enter-active-class="transition duration-300" enter-from-class="opacity-0 translate-y-4" leave-active-class="transition duration-200" leave-to-class="opacity-0 translate-y-4">
      <div v-if="toast?.show" class="fixed bottom-6 right-6 z-50 flex items-center gap-3 px-5 py-3.5 rounded-2xl shadow-2xl text-xs font-bold border backdrop-blur-md" :class="toast.type === 'error' ? 'bg-red-500/90 text-white border-red-400' : 'bg-emerald-500/90 text-white border-emerald-400'">
        <span>{{ toast.message }}</span>
      </div>
    </Transition>

  </div>
</template>

<script setup>
const token = useCookie("token");
const barangList = ref([]);
const keranjang = ref([]);
const search = ref("");
const selectedCategory = ref("Semua");
const bayar = ref(0);
const isLoading = ref(false);

const diskonTipe = ref("nominal"); // 'nominal' or 'persen'
const diskonInput = ref(0);

const searchInputRef = ref(null);
const bayarInputRef = ref(null);

const categories = ref(["Semua"]);

const loadKategori = async () => {
  try {
    const res = await $fetch("http://localhost/crud-laravel/public/api/kategori", {
      headers: { Authorization: `Bearer ${token.value}` },
    });
    if (Array.isArray(res)) {
      categories.value = ["Semua", ...res.map(c => c.nama)];
    }
  } catch (err) {
    // Fallback if error
  }
};

const struk = ref({ show: false, no_nota: "", tanggal: "", items: [], subtotal: 0, diskon: 0, total_harga: 0, bayar: 0, kembali: 0 });
const toast = ref({ show: false, message: "", type: "success" });

const showToast = (msg, type = "success") => {
  toast.value = { show: true, message: msg, type };
  setTimeout(() => (toast.value.show = false), 3500);
};

const getGambarUrl = (path) => {
  if (!path) return '';
  if (path.startsWith('http://') || path.startsWith('https://')) return path;
  return `http://localhost/crud-laravel/public/storage/${path}`;
};

// KEYBOARD SHORTCUTS
const handleKeydown = (e) => {
  // Hotkey '/' to focus search input
  if (e.key === '/' && document.activeElement !== searchInputRef.value && document.activeElement !== bayarInputRef.value) {
    e.preventDefault();
    searchInputRef.value?.focus();
    return;
  }

  // Hotkey 'Esc' to close modal
  if (e.key === 'Escape') {
    if (struk.value.show) {
      tutupStruk();
    }
    return;
  }

  // Hotkey 'F2' or 'Ctrl+Enter' to process payment
  if (e.key === 'F2' || (e.ctrlKey && e.key === 'Enter')) {
    e.preventDefault();
    if (bayar.value >= totalHarga.value && totalHarga.value > 0 && keranjang.value.length > 0) {
      prosesTransaksi();
    } else {
      bayarInputRef.value?.focus();
    }
  }
};

const loadBarang = async () => {
  isLoading.value = true;
  try {
    const res = await $fetch("http://localhost/crud-laravel/public/api/barang", {
      headers: { Authorization: `Bearer ${token.value}` },
    });
    barangList.value = res;
  } catch (err) {
    if (err.status === 401 || err.status === 403) navigateTo("/");
  } finally {
    isLoading.value = false;
  }
};

onMounted(() => {
  if (!token.value) navigateTo("/");
  loadKategori();
  loadBarang();
  window.addEventListener('keydown', handleKeydown);
});

onUnmounted(() => {
  window.removeEventListener('keydown', handleKeydown);
});

const barangFiltered = computed(() => {
  return barangList.value.filter((item) => {
    const matchSearch =
      item.nama_barang.toLowerCase().includes(search.value.toLowerCase()) ||
      item.kode_barang.toLowerCase().includes(search.value.toLowerCase());
    
    const matchCategory =
      selectedCategory.value === "Semua" ||
      String(item.kategori || "").trim().toLowerCase() === selectedCategory.value.trim().toLowerCase();

    return matchSearch && matchCategory;
  });
});

const subtotalBelanja = computed(() => keranjang.value.reduce((sum, item) => sum + item.harga * item.qty, 0));

const diskonNominal = computed(() => {
  if (!diskonInput.value || diskonInput.value <= 0) return 0;
  if (diskonTipe.value === 'persen') {
    return Math.round((subtotalBelanja.value * Math.min(100, diskonInput.value)) / 100);
  }
  return Math.min(subtotalBelanja.value, diskonInput.value);
});

const totalHarga = computed(() => Math.max(0, subtotalBelanja.value - diskonNominal.value));
const kembalian = computed(() => Math.max(0, bayar.value - totalHarga.value));

const tambahKeKeranjang = (item) => {
  if (item.stok === 0) return showToast("Stok barang ini telah habis!", "error");

  const exist = keranjang.value.find((i) => i.id === item.id);
  if (exist) {
    if (exist.qty >= item.stok) return showToast(`Stok ${item.nama_barang} hanya tersisa ${item.stok} unit!`, "error");
    exist.qty++;
  } else {
    keranjang.value.push({ ...item, qty: 1 });
  }
};

const tambahQty = (item) => {
  const original = barangList.value.find((b) => b.id === item.id);
  if (original && item.qty >= original.stok) return showToast(`Stok ${item.nama_barang} hanya tersisa ${original.stok} unit!`, "error");
  item.qty++;
};

const kurangiQty = (item) => {
  if (item.qty > 1) item.qty--;
  else hapusItem(item);
};

const hapusItem = (item) => {
  keranjang.value = keranjang.value.filter((i) => i.id !== item.id);
};

const kosongkanKeranjang = () => {
  keranjang.value = [];
  diskonInput.value = 0;
  bayar.value = 0;
};

const prosesTransaksi = async () => {
  try {
    const snapshotItems = keranjang.value.map((i) => ({ ...i }));
    const snapshotBayar = bayar.value;
    const snapshotSubtotal = subtotalBelanja.value;
    const snapshotDiskon = diskonNominal.value;
    const snapshotTotal = totalHarga.value;

    const response = await $fetch("http://localhost/crud-laravel/public/api/transaksi", {
      method: "POST",
      headers: { Authorization: `Bearer ${token.value}` },
      body: {
        bayar: bayar.value,
        diskon: snapshotDiskon,
        items: keranjang.value.map((item) => ({ id: item.id, qty: item.qty })),
      },
    });

    const trxData = response.transaksi || response.data || response;
    const now = new Date();
    struk.value = {
      show: true,
      no_nota: trxData.no_nota,
      tanggal: now.toLocaleString('id-ID', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' }),
      items: snapshotItems,
      subtotal: snapshotSubtotal,
      diskon: snapshotDiskon,
      total_harga: snapshotTotal,
      bayar: snapshotBayar,
      kembali: trxData.kembali,
    };

    keranjang.value = [];
    diskonInput.value = 0;
    bayar.value = 0;
    showToast("Pembayaran Berhasil! Struk telah diterbitkan.", "success");
    loadBarang();
  } catch (error) {
    const msg = error.data?.message || error.response?._data?.message || "Terjadi kesalahan pada server";
    showToast(msg, "error");
  }
};

const tutupStruk = () => { struk.value.show = false; };

const printStruk = () => {
  const s = struk.value;
  const itemsHtml = s.items.map(i => `
    <div style="margin-bottom:6px;">
      <div style="display:flex;justify-content:space-between;font-weight:bold;font-size:11px;">
        <span style="flex:1;padding-right:4px;">${i.nama_barang}</span>
        <span>Rp ${Number(i.harga * i.qty).toLocaleString('id-ID')}</span>
      </div>
      <div style="font-size:10px;color:#444;">${i.qty} unit x Rp ${Number(i.harga).toLocaleString('id-ID')}</div>
    </div>
  `).join('');

  const diskonHtml = s.diskon > 0 ? `
    <div class="total-row bold" style="color:#b45309;"><span>Diskon Promo:</span><span>-Rp ${Number(s.diskon).toLocaleString('id-ID')}</span></div>
  ` : '';

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

  <div class="total-row"><span>Subtotal (${s.items.length} item):</span><span>Rp ${Number(s.subtotal || s.total_harga).toLocaleString('id-ID')}</span></div>
  ${diskonHtml}
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
