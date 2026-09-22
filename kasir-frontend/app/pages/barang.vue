<template>
  <div v-if="token" class="min-h-screen flex flex-col pb-12">
    <!-- Navigation Header & Side Panel -->
    <AppHeader activePage="barang" />

    <!-- Main Content -->
    <main class="flex-1 max-w-[1920px] mx-auto w-full px-4 sm:px-6 lg:px-8 space-y-6 pt-20">
      
      <!-- ===== EXECUTIVE INVENTORY KPI BAR ===== -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 animate-fade-in-up">
        
        <!-- Total Jenis Produk -->
        <div class="glass-card p-5 sm:p-6 relative overflow-hidden group hover:border-blue-500/40 transition-all duration-300">
          <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Katalog Barang</span>
            <div class="w-11 h-11 rounded-2xl bg-blue-500/15 border border-blue-500/30 flex items-center justify-center text-blue-400 shadow-lg shadow-blue-500/10">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
            </div>
          </div>
          <p class="text-2xl sm:text-3xl lg:text-4xl font-black text-white tracking-tight">
            {{ barangList.length }} <span class="text-base font-medium text-slate-400">SKU / Item</span>
          </p>
          <p class="text-xs text-blue-400 font-semibold mt-2.5">📦 Master Data Terdaftar</p>
        </div>

        <!-- Total Nilai Aset Stok -->
        <div class="glass-card p-5 sm:p-6 relative overflow-hidden group hover:border-emerald-500/40 transition-all duration-300">
          <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Nilai Total Aset Inventaris</span>
            <div class="w-11 h-11 rounded-2xl bg-emerald-500/15 border border-emerald-500/30 flex items-center justify-center text-emerald-400 shadow-lg shadow-emerald-500/10">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
          </div>
          <p class="text-2xl sm:text-3xl lg:text-4xl font-black text-white tracking-tight truncate">
            Rp {{ totalNilaiAset.toLocaleString('id-ID') }}
          </p>
          <p class="text-xs text-emerald-400 font-semibold mt-2.5">💰 Estimasi Nilai Stok Gudang</p>
        </div>

        <!-- Stok Menipis Warning -->
        <div class="glass-card p-5 sm:p-6 relative overflow-hidden group hover:border-amber-500/40 transition-all duration-300">
          <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Stok Menipis (≤ 3 Unit)</span>
            <div class="w-11 h-11 rounded-2xl bg-amber-500/15 border border-amber-500/30 flex items-center justify-center text-amber-400 shadow-lg shadow-amber-500/10">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            </div>
          </div>
          <p class="text-2xl sm:text-3xl lg:text-4xl font-black text-white tracking-tight">
            {{ stokMenipisCount }} <span class="text-base font-medium text-slate-400">Produk</span>
          </p>
          <p class="text-xs text-amber-400 font-semibold mt-2.5">⚠️ Perlu Restok Segera</p>
        </div>

        <!-- Stok Habis Alert -->
        <div class="glass-card p-5 sm:p-6 relative overflow-hidden group hover:border-red-500/40 transition-all duration-300">
          <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Stok Habis (0 Unit)</span>
            <div class="w-11 h-11 rounded-2xl bg-red-500/15 border border-red-500/30 flex items-center justify-center text-red-400 shadow-lg shadow-red-500/10">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" /></svg>
            </div>
          </div>
          <p class="text-2xl sm:text-3xl lg:text-4xl font-black text-white tracking-tight">
            {{ stokHabisCount }} <span class="text-base font-medium text-slate-400">Produk</span>
          </p>
          <p class="text-xs text-red-400 font-semibold mt-2.5">🛑 Kosong di Gudang</p>
        </div>

      </div>

      <!-- ===== MASTER FORM TAMBAH BARANG ===== -->
      <div class="glass-card p-5 sm:p-7 space-y-6">
        
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-white/[0.08] pb-5">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-2xl bg-blue-600/20 border border-blue-500/30 flex items-center justify-center text-blue-400 font-bold">
              +
            </div>
            <div>
              <h2 class="text-lg sm:text-xl font-extrabold text-white">Tambah Produk Komputer Baru</h2>
              <p class="text-xs text-slate-400">Masukkan detail data master produk, kategori, harga, dan stok barang</p>
            </div>
          </div>

          <!-- Kelola Kategori Button -->
          <button
            @click="bukaModalKategori"
            class="px-4 py-2.5 rounded-xl bg-amber-500/15 hover:bg-amber-500/25 border border-amber-500/30 text-amber-300 font-bold text-xs flex items-center justify-center gap-2 transition-all active:scale-95 self-start sm:self-auto"
          >
            🏷️ Kelola Daftar Kategori
          </button>
        </div>

        <form @submit.prevent="tambahBarang" class="space-y-4">
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            
            <!-- Kode Barang -->
            <div class="col-span-1">
              <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Kode Barang</label>
              <input
                v-model="form.kode_barang"
                @input="formatKodeInput"
                placeholder="COMP-001"
                class="input-elegant text-sm uppercase font-mono"
                :class="kodeError ? 'border-amber-500/60 focus:border-amber-400' : ''"
                required
              />
              <p v-if="kodeError" class="text-[10px] text-amber-400 font-medium mt-1 truncate">{{ kodeError }}</p>
            </div>

            <!-- Nama Barang -->
            <div class="col-span-1 sm:col-span-2 lg:col-span-2">
              <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Nama Barang</label>
              <input
                v-model="form.nama_barang"
                placeholder="Nama produk (mis: RTX 4090 24GB)"
                class="input-elegant text-sm"
                :class="namaError ? 'border-amber-500/60 focus:border-amber-400' : ''"
                required
              />
              <p v-if="namaError" class="text-[10px] text-amber-400 font-medium mt-1 truncate">{{ namaError }}</p>
            </div>

            <!-- Kategori (Dinamis dari DB) -->
            <div class="col-span-1">
              <div class="flex items-center justify-between mb-2">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Kategori</label>
                <button type="button" @click="bukaModalKategori" class="text-[10px] text-amber-400 hover:text-amber-300 font-bold underline">+ Kelola</button>
              </div>
              <select v-model="form.kategori" class="input-elegant text-sm bg-slate-900 text-white cursor-pointer" required>
                <option v-for="c in categoriesList" :key="c.id" :value="c.nama" class="bg-slate-900 text-white">
                  {{ c.icon }} {{ c.nama }}
                </option>
              </select>
            </div>

            <!-- Harga & Stok -->
            <div class="col-span-1 grid grid-cols-2 gap-2">
              <div>
                <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Harga (Rp)</label>
                <input v-model.number="form.harga" type="number" placeholder="0" class="input-elegant text-sm font-semibold" required />
              </div>
              <div>
                <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Stok</label>
                <input v-model.number="form.stok" type="number" placeholder="0" class="input-elegant text-sm font-semibold" required />
              </div>
            </div>

          </div>

          <!-- Foto Barang (Full Width Row) -->
          <div class="border border-white/[0.06] rounded-2xl p-4 bg-white/[0.02]">
            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">📷 Foto Barang <span class="text-slate-600 normal-case font-medium">(opsional)</span></label>
            <div class="flex flex-col md:flex-row gap-4">

              <!-- Preview -->
              <div class="flex-shrink-0">
                <div
                  class="relative w-32 h-32 rounded-xl border-2 border-dashed overflow-hidden flex items-center justify-center transition-all"
                  :class="addGambarPreview ? 'border-blue-500/50 bg-slate-900/60' : 'border-white/[0.08] bg-white/[0.02]'"
                >
                  <img v-if="addGambarPreview" :src="addGambarPreview" class="w-full h-full object-contain" />
                  <div v-else class="text-center">
                    <svg class="w-8 h-8 text-slate-600 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    <p class="text-[9px] text-slate-600">Belum ada foto</p>
                  </div>
                  <button
                    v-if="addGambarPreview"
                    type="button"
                    @click="hapusGambarAdd"
                    class="absolute top-1 right-1 w-6 h-6 rounded-lg bg-red-500/90 text-white flex items-center justify-center text-xs font-bold shadow transition-all hover:bg-red-500"
                  >✕</button>
                </div>
              </div>

              <!-- Inputs -->
              <div class="flex-1 space-y-3">
                <!-- Upload File -->
                <div>
                  <label class="block text-[10px] text-slate-500 font-bold uppercase mb-1.5">Upload File (JPG / PNG / WebP, max 4MB)</label>
                  <input
                    ref="addGambarInput"
                    type="file"
                    accept="image/*"
                    @change="onAddGambarChange"
                    class="block w-full text-xs text-slate-400 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-500 cursor-pointer transition-all"
                  />
                </div>

                <!-- URL Eksternal -->
                <div v-if="!addGambarFile">
                  <label class="block text-[10px] text-slate-500 font-bold uppercase mb-1.5">atau Tempel URL Gambar Eksternal</label>
                  <input
                    v-model="form.gambar"
                    @input="addGambarPreview = form.gambar"
                    type="url"
                    placeholder="https://example.com/gambar.jpg"
                    class="input-elegant text-xs"
                  />
                </div>
              </div>

            </div>
          </div>

          <!-- Submit Action -->
          <div class="flex justify-end pt-2">
            <button
              type="submit"
              :disabled="isLoadingAdd || kodeError !== '' || namaError !== ''"
              class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs flex items-center justify-center gap-2 shadow-lg shadow-blue-600/30 transition-all active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed"
            >
              <svg v-if="isLoadingAdd" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
              <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
              <span>{{ isLoadingAdd ? 'Menyimpan...' : 'Simpan Produk Baru' }}</span>
            </button>
          </div>
        </form>

      </div>

      <!-- ===== MASTER DATA TABLE CATALOG ===== -->
      <div class="glass-card p-5 sm:p-7 space-y-6">
        
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 border-b border-white/[0.08] pb-5">
          <div>
            <h3 class="text-lg font-black text-white tracking-tight">Katalog Stok Barang Gudang</h3>
            <p class="text-xs text-slate-400">Daftar inventaris lengkap dengan filter pencarian dan kontrol aksi</p>
          </div>

          <!-- Search & Filter Controls -->
          <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            <div class="relative flex-1 md:w-72">
              <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0" /></svg>
              <input
                v-model="search"
                type="text"
                placeholder="Cari barang atau kode..."
                class="input-elegant pl-10 pr-4 py-2 text-xs"
              />
            </div>

            <!-- Category Filter Dropdown -->
            <select v-model="selectedCategory" class="input-elegant text-xs py-2 bg-slate-900 text-white cursor-pointer w-auto">
              <option value="Semua">Semua Kategori</option>
              <option v-for="c in categoriesList" :key="c.id" :value="c.nama">{{ c.icon }} {{ c.nama }}</option>
            </select>
          </div>
        </div>

        <!-- Table Catalog -->
        <div class="overflow-x-auto rounded-2xl border border-white/[0.08]">
          <table class="w-full text-sm text-left">
            <thead>
              <tr class="bg-slate-900/80 border-b border-white/[0.08] text-slate-400">
                <th class="py-4 px-6 text-xs font-bold uppercase tracking-wider w-12">#</th>
                <th class="py-4 px-6 text-xs font-bold uppercase tracking-wider w-16">Foto</th>
                <th class="py-4 px-6 text-xs font-bold uppercase tracking-wider">Kode</th>
                <th class="py-4 px-6 text-xs font-bold uppercase tracking-wider">Nama & Kategori Produk</th>
                <th class="py-4 px-6 text-xs font-bold uppercase tracking-wider">Harga Satuan</th>
                <th class="py-4 px-6 text-xs font-bold uppercase tracking-wider">Stok Tersedia</th>
                <th class="py-4 px-6 text-center text-xs font-bold uppercase tracking-wider">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-white/[0.05]">
              <template v-if="isLoading">
                <tr v-for="n in 5" :key="n" class="animate-pulse">
                  <td class="py-4 px-6"><div class="h-4 w-4 bg-white/10 rounded"></div></td>
                  <td class="py-4 px-6"><div class="w-12 h-12 rounded-xl bg-white/10"></div></td>
                  <td class="py-4 px-6"><div class="h-6 w-24 bg-white/10 rounded-lg"></div></td>
                  <td class="py-4 px-6"><div class="h-5 w-40 bg-white/10 rounded mb-1"></div><div class="h-3 w-16 bg-white/5 rounded"></div></td>
                  <td class="py-4 px-6"><div class="h-5 w-28 bg-white/10 rounded"></div></td>
                  <td class="py-4 px-6"><div class="h-6 w-20 bg-white/10 rounded-full"></div></td>
                  <td class="py-4 px-6"><div class="h-8 w-24 bg-white/10 rounded-xl mx-auto"></div></td>
                </tr>
              </template>

              <tr v-else-if="barangFiltered.length === 0">
                <td colspan="7" class="py-16 text-center text-slate-400">
                  Tidak ada barang ditemukan.
                </td>
              </tr>

              <tr v-else v-for="(item, index) in barangFiltered" :key="item.id" class="hover:bg-white/[0.03] transition-colors">
                <td class="py-4 px-6 text-slate-500 text-xs font-mono">{{ index + 1 }}</td>
                <td class="py-4 px-6">
                  <div class="w-12 h-12 rounded-xl bg-slate-950 border border-white/[0.08] flex items-center justify-center overflow-hidden cursor-pointer group" @click="bukaLightbox(item.gambar_url || getGambarUrl(item.gambar))">
                    <img v-if="item.gambar_url || item.gambar" :src="item.gambar_url || getGambarUrl(item.gambar)" class="w-full h-full object-contain p-1 group-hover:scale-110 transition-transform" />
                    <span v-else class="text-[10px] text-slate-600 font-bold">POS</span>
                  </div>
                </td>
                <td class="py-4 px-6">
                  <span class="font-mono text-xs px-3 py-1 rounded-lg bg-blue-500/10 border border-blue-500/20 text-blue-300 font-bold">
                    {{ item.kode_barang }}
                  </span>
                </td>
                <td class="py-4 px-6">
                  <p class="font-bold text-white text-sm">{{ item.nama_barang }}</p>
                  <span class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-white/[0.05] text-slate-400 border border-white/[0.08] mt-1 inline-block">
                    {{ item.kategori || 'Komputer' }}
                  </span>
                </td>
                <td class="py-4 px-6 font-black text-white">
                  Rp {{ Number(item.harga).toLocaleString('id-ID') }}
                </td>
                <td class="py-4 px-6">
                  <span
                    class="px-3 py-1 rounded-full text-xs font-bold border"
                    :class="item.stok === 0 ? 'bg-red-500/15 text-red-400 border-red-500/30' : (item.stok <= 3 ? 'bg-amber-500/15 text-amber-400 border-amber-500/30' : 'bg-emerald-500/15 text-emerald-300 border-emerald-500/30')"
                  >
                    {{ item.stok === 0 ? 'Habis (0)' : (item.stok <= 3 ? `🔥 Sisa ${item.stok}` : `${item.stok} Unit`) }}
                  </span>
                </td>
                <td class="py-4 px-6 text-center">
                  <div class="flex items-center justify-center gap-2">
                    <button
                      @click="bukaModalEdit(item)"
                      class="px-3 py-1.5 rounded-xl bg-blue-500/15 hover:bg-blue-500/25 text-blue-300 border border-blue-500/30 text-xs font-bold transition-all"
                    >
                      Edit
                    </button>
                    <button
                      @click="hapusBarang(item)"
                      class="px-3 py-1.5 rounded-xl bg-red-500/15 hover:bg-red-500/25 text-red-400 border border-red-500/30 text-xs font-bold transition-all"
                    >
                      Hapus
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

      </div>

    </main>

    <!-- ===== MODAL KELOLA KATEGORI MASTER ===== -->
    <Transition enter-active-class="transition-all duration-300 ease-out" enter-from-class="opacity-0 scale-95" enter-to-class="opacity-100 scale-100" leave-active-class="transition-all duration-200 ease-in" leave-to-class="opacity-0 scale-95">
      <div v-if="showKategoriModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto">
        <div class="fixed inset-0 bg-black/80 backdrop-blur-md" @click="showKategoriModal = false"></div>
        <div class="relative z-10 w-full max-w-xl glass-card p-6 border-amber-500/30 shadow-2xl space-y-5 my-8">
          
          <div class="flex items-center justify-between border-b border-white/10 pb-4">
            <div class="flex items-center gap-2.5">
              <span class="text-2xl">🏷️</span>
              <div>
                <h3 class="text-lg font-black text-white">Kelola Kategori Produk Master</h3>
                <p class="text-xs text-slate-400">Tambah, ubah nama, atau hapus kategori barang toko</p>
              </div>
            </div>
            <button @click="showKategoriModal = false" class="text-slate-400 hover:text-white text-lg font-bold">✕</button>
          </div>

          <!-- Form Tambah Kategori Baru -->
          <form @submit.prevent="tambahKategori" class="p-4 rounded-2xl bg-white/[0.03] border border-white/[0.06] space-y-3">
            <h4 class="text-xs font-bold text-slate-300 uppercase tracking-wider">+ Tambah Kategori Baru</h4>
            <div class="flex flex-col sm:flex-row gap-2">
              <input v-model="newKatIcon" type="text" placeholder="Icon Emoji" class="input-elegant w-full sm:w-24 text-center text-sm" />
              <input v-model="newKatNama" type="text" placeholder="Nama Kategori (mis: Laptop Gaming)" class="input-elegant text-sm flex-1" required />
              <button type="submit" :disabled="isLoadingKatAdd" class="px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-xs shadow-lg transition-all disabled:opacity-50">
                {{ isLoadingKatAdd ? 'Simpan...' : 'Tambah Kategori' }}
              </button>
            </div>

            <!-- Emoji Quick Picker -->
            <div class="pt-1 flex items-center gap-1.5 flex-wrap">
              <span class="text-[10px] text-slate-500 font-bold uppercase mr-1">Pilih Icon:</span>
              <button
                v-for="e in ['🎮', '⚡', '🖥️', '💾', '💽', '⌨️', '🔌', '💻', '📦', '🎧', '📱', '🖨️', '🖱️']"
                :key="e"
                type="button"
                @click="newKatIcon = e"
                class="w-7 h-7 rounded-lg bg-white/[0.05] hover:bg-amber-500/20 hover:border-amber-500/40 border border-white/10 text-xs flex items-center justify-center transition-all"
                :class="newKatIcon === e ? 'bg-amber-500/30 border-amber-500 text-amber-300 scale-110' : ''"
              >
                {{ e }}
              </button>
            </div>
          </form>

          <!-- Table List Kategori -->
          <div class="space-y-2">
            <div class="flex justify-between items-center text-xs text-slate-400 px-1 font-bold">
              <span>Daftar Kategori Terdaftar ({{ categoriesList.length }})</span>
              <span>Jumlah Barang Terhubung</span>
            </div>

            <div class="max-h-72 overflow-y-auto elegant-scroll space-y-2 pr-1">
              <div
                v-for="cat in categoriesList"
                :key="cat.id"
                class="p-3 rounded-xl bg-slate-900/80 border border-white/[0.06] flex items-center justify-between gap-3 hover:border-white/20 transition-all"
              >
                <!-- Inline Edit Form -->
                <template v-if="editingKatId === cat.id">
                  <div class="flex items-center gap-2 flex-1">
                    <input v-model="editingKatIcon" type="text" class="input-elegant w-14 text-center text-xs py-1" />
                    <input v-model="editingKatNama" type="text" class="input-elegant text-xs py-1 flex-1 font-bold" required />
                  </div>
                  <div class="flex items-center gap-1.5">
                    <button @click="simpanEditKategori(cat)" class="px-3 py-1 rounded-lg bg-emerald-600 text-white text-xs font-bold">Simpan</button>
                    <button @click="editingKatId = null" class="px-2.5 py-1 rounded-lg bg-white/10 text-slate-300 text-xs">Batal</button>
                  </div>
                </template>

                <!-- Normal Row Display -->
                <template v-else>
                  <div class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-white/[0.05] border border-white/10 flex items-center justify-center text-sm">{{ cat.icon }}</span>
                    <div>
                      <span class="text-sm font-bold text-white">{{ cat.nama }}</span>
                    </div>
                  </div>

                  <div class="flex items-center gap-3">
                    <span class="px-2.5 py-1 rounded-full bg-blue-500/15 text-blue-300 border border-blue-500/30 text-xs font-mono font-bold">
                      {{ cat.item_count }} Barang
                    </span>

                    <button @click="mulaiEditKategori(cat)" class="p-1.5 rounded-lg bg-white/[0.05] text-slate-400 hover:text-white" title="Edit Kategori">
                      ✏️
                    </button>
                    <button @click="hapusKategori(cat)" class="p-1.5 rounded-lg bg-red-500/15 text-red-400 hover:bg-red-500 hover:text-white" title="Hapus Kategori">
                      🗑️
                    </button>
                  </div>
                </template>
              </div>
            </div>
          </div>

          <div class="pt-2 flex justify-end">
            <button @click="showKategoriModal = false" class="px-5 py-2.5 rounded-xl bg-white/10 text-xs font-bold text-white hover:bg-white/20">
              Selesai & Tutup
            </button>
          </div>

        </div>
      </div>
    </Transition>

    <!-- ===== MODAL EDIT BARANG ===== -->
    <Transition enter-active-class="transition-all duration-300 ease-out" enter-from-class="opacity-0 scale-95" enter-to-class="opacity-100 scale-100" leave-active-class="transition-all duration-200 ease-in" leave-to-class="opacity-0 scale-95">
      <div v-if="showEditModal" class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/80 backdrop-blur-md" @click="showEditModal = false"></div>
        <div class="relative z-10 w-full max-w-lg glass-card p-6 border-blue-500/30 shadow-2xl">
          <h3 class="text-lg font-black text-white mb-4">Edit Data Produk</h3>
          <form @submit.prevent="updateBarang" class="space-y-4">
            <div>
              <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Nama Barang</label>
              <input v-model="editForm.nama_barang" class="input-elegant text-sm" required />
            </div>

            <div class="grid grid-cols-2 gap-3">
              <div>
                <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Kategori</label>
                <select v-model="editForm.kategori" class="input-elegant text-sm bg-slate-900 text-white cursor-pointer" required>
                  <option v-for="c in categoriesList" :key="c.id" :value="c.nama" class="bg-slate-900 text-white">
                    {{ c.icon }} {{ c.nama }}
                  </option>
                </select>
              </div>
              <div>
                <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Harga (Rp)</label>
                <input v-model.number="editForm.harga" type="number" class="input-elegant text-sm font-semibold" required />
              </div>
            </div>

            <div>
              <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Stok Tersedia</label>
              <input v-model.number="editForm.stok" type="number" class="input-elegant text-sm font-semibold" required />
            </div>

            <!-- Gambar Barang -->
            <div>
              <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Foto Barang</label>

              <!-- Preview -->
              <div v-if="editGambarPreview" class="relative mb-3 w-full h-40 rounded-xl overflow-hidden border border-white/[0.08] bg-slate-900/60">
                <img :src="editGambarPreview" class="w-full h-full object-contain" />
                <button
                  type="button"
                  @click="hapusGambarEdit"
                  class="absolute top-2 right-2 w-7 h-7 rounded-lg bg-red-500/80 hover:bg-red-500 text-white flex items-center justify-center text-xs font-bold shadow-lg transition-all"
                  title="Hapus Gambar"
                >✕</button>
              </div>

              <!-- Upload File -->
              <div class="mb-2">
                <label class="block text-[10px] text-slate-500 font-bold uppercase mb-1">Upload File (JPG/PNG/WebP)</label>
                <input
                  ref="editGambarInput"
                  type="file"
                  accept="image/*"
                  @change="onEditGambarChange"
                  class="block w-full text-xs text-slate-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-500 cursor-pointer"
                />
              </div>

              <!-- URL Eksternal -->
              <div v-if="!editGambarFile">
                <label class="block text-[10px] text-slate-500 font-bold uppercase mb-1">atau Pakai URL Gambar</label>
                <input
                  v-model="editForm.gambar"
                  @input="editGambarPreview = editForm.gambar"
                  type="url"
                  placeholder="https://..."
                  class="input-elegant text-xs"
                />
              </div>
            </div>

            <div class="flex justify-end gap-3 pt-3">
              <button type="button" @click="showEditModal = false" class="px-4 py-2 rounded-xl bg-white/10 text-xs font-bold text-white hover:bg-white/20">Batal</button>
              <button type="submit" class="px-5 py-2 rounded-xl bg-blue-600 text-xs font-bold text-white hover:bg-blue-500 shadow-lg shadow-blue-600/30">Simpan Perubahan</button>
            </div>
          </form>
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
const categoriesList = ref([]);
const search = ref("");
const selectedCategory = ref("Semua");
const isLoading = ref(false);
const isLoadingAdd = ref(false);
const showEditModal = ref(false);

const showKategoriModal = ref(false);
const newKatNama = ref("");
const newKatIcon = ref("📦");
const isLoadingKatAdd = ref(false);

const editingKatId = ref(null);
const editingKatNama = ref("");
const editingKatIcon = ref("");

const form = ref({ kode_barang: '', nama_barang: '', kategori: 'VGA Card', harga: 0, stok: 0, gambar: '' });
const addGambarFile = ref(null);
const addGambarPreview = ref('');
const addGambarInput = ref(null);
const editForm = ref({ id: null, kode_barang: '', nama_barang: '', kategori: 'VGA Card', harga: 0, stok: 0, gambar: '' });
const editGambarFile = ref(null);
const editGambarPreview = ref('');
const editGambarInput = ref(null);

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

const loadKategori = async () => {
  try {
    const res = await $fetch("http://localhost/crud-laravel/public/api/kategori", {
      headers: { Authorization: `Bearer ${token.value}` },
    });
    categoriesList.value = res;
    if (res.length > 0 && (!form.value.kategori || !res.some(c => c.nama === form.value.kategori))) {
      form.value.kategori = res[0].nama;
    }
  } catch (err) {
    // Fail silently
  }
};

const bukaModalKategori = () => {
  loadKategori();
  showKategoriModal.value = true;
};

const tambahKategori = async () => {
  if (!newKatNama.value.trim()) return;
  isLoadingKatAdd.value = true;
  try {
    await $fetch("http://localhost/crud-laravel/public/api/kategori", {
      method: "POST",
      headers: { Authorization: `Bearer ${token.value}` },
      body: { nama: newKatNama.value, icon: newKatIcon.value || '📦' },
    });
    showToast("Kategori baru berhasil ditambahkan!", "success");
    newKatNama.value = "";
    newKatIcon.value = "📦";
    loadKategori();
  } catch (err) {
    showToast(err.data?.message || "Gagal menambah kategori.", "error");
  } finally {
    isLoadingKatAdd.value = false;
  }
};

const mulaiEditKategori = (cat) => {
  editingKatId.value = cat.id;
  editingKatNama.value = cat.nama;
  editingKatIcon.value = cat.icon || '📦';
};

const simpanEditKategori = async (cat) => {
  try {
    await $fetch(`http://localhost/crud-laravel/public/api/kategori/${cat.id}`, {
      method: "PUT",
      headers: { Authorization: `Bearer ${token.value}` },
      body: { nama: editingKatNama.value, icon: editingKatIcon.value },
    });
    showToast("Kategori berhasil diperbarui!", "success");
    editingKatId.value = null;
    loadKategori();
    loadBarang();
  } catch (err) {
    showToast(err.data?.message || "Gagal memperbarui kategori.", "error");
  }
};

const hapusKategori = async (cat) => {
  if (!confirm(`Yakin ingin menghapus kategori '${cat.nama}'?`)) return;
  try {
    await $fetch(`http://localhost/crud-laravel/public/api/kategori/${cat.id}`, {
      method: "DELETE",
      headers: { Authorization: `Bearer ${token.value}` },
    });
    showToast("Kategori berhasil dihapus.", "success");
    loadKategori();
  } catch (err) {
    showToast(err.data?.message || "Gagal menghapus kategori.", "error");
  }
};

const loadBarang = async () => {
  isLoading.value = true;
  try {
    const res = await $fetch("http://localhost/crud-laravel/public/api/barang", {
      headers: { Authorization: `Bearer ${token.value}` },
    });
    barangList.value = res;
    if (!form.value.kode_barang) generateAutoKode();
  } catch (err) {
    if (err.status === 401 || err.status === 403) navigateTo("/");
  } finally {
    isLoading.value = false;
  }
};

const generateAutoKode = () => {
  const nextNum = barangList.value.length + 1;
  form.value.kode_barang = `COMP-${String(nextNum).padStart(3, '0')}`;
};

onMounted(() => {
  if (!token.value) navigateTo("/");
  loadKategori();
  loadBarang();
});

const totalNilaiAset = computed(() => barangList.value.reduce((sum, b) => sum + (b.harga * b.stok), 0));
const stokMenipisCount = computed(() => barangList.value.filter(b => b.stok > 0 && b.stok <= 3).length);
const stokHabisCount = computed(() => barangList.value.filter(b => b.stok === 0).length);

const barangFiltered = computed(() => {
  return barangList.value.filter((item) => {
    const matchSearch = item.nama_barang.toLowerCase().includes(search.value.toLowerCase()) || item.kode_barang.toLowerCase().includes(search.value.toLowerCase());
    const matchCategory = selectedCategory.value === "Semua" || String(item.kategori || "").trim().toLowerCase() === selectedCategory.value.trim().toLowerCase();
    return matchSearch && matchCategory;
  });
});

const kodeError = computed(() => {
  if (!form.value.kode_barang) return "";
  if (!form.value.kode_barang.toUpperCase().startsWith("COMP-")) return "Wajib diawali COMP-";
  if (barangList.value.some(b => b.kode_barang.toUpperCase() === form.value.kode_barang.toUpperCase())) return "⚠️ Kode sudah digunakan!";
  return "";
});

const namaError = computed(() => {
  if (!form.value.nama_barang) return "";
  if (form.value.nama_barang.trim().length < 3) return "Minimal 3 karakter!";
  if (barangList.value.some(b => b.nama_barang.toLowerCase() === form.value.nama_barang.trim().toLowerCase())) return "⚠️ Nama sudah ada!";
  return "";
});

const formatKodeInput = () => {
  if (form.value.kode_barang) form.value.kode_barang = form.value.kode_barang.toUpperCase();
};

const onAddGambarChange = (e) => {
  const file = e.target.files[0];
  if (!file) return;
  addGambarFile.value = file;
  const reader = new FileReader();
  reader.onload = (ev) => { addGambarPreview.value = ev.target.result; };
  reader.readAsDataURL(file);
};

const hapusGambarAdd = () => {
  addGambarFile.value = null;
  addGambarPreview.value = '';
  form.value.gambar = '';
  if (addGambarInput.value) addGambarInput.value.value = '';
};

const tambahBarang = async () => {
  isLoadingAdd.value = true;
  try {
    const fd = new FormData();
    fd.append('kode_barang', form.value.kode_barang);
    fd.append('nama_barang', form.value.nama_barang);
    fd.append('kategori', form.value.kategori);
    fd.append('harga', form.value.harga);
    fd.append('stok', form.value.stok);
    if (addGambarFile.value) {
      fd.append('gambar_file', addGambarFile.value);
    } else if (form.value.gambar) {
      fd.append('gambar', form.value.gambar);
    }
    await $fetch('http://localhost/crud-laravel/public/api/barang', {
      method: 'POST',
      headers: { Authorization: `Bearer ${token.value}` },
      body: fd,
    });
    showToast('Produk berhasil ditambahkan!', 'success');
    form.value = { kode_barang: '', nama_barang: '', kategori: 'VGA Card', harga: 0, stok: 0, gambar: '' };
    addGambarFile.value = null;
    addGambarPreview.value = '';
    if (addGambarInput.value) addGambarInput.value.value = '';
    loadBarang();
  } catch (err) {
    showToast(err.data?.message || 'Gagal menambah barang.', 'error');
  } finally {
    isLoadingAdd.value = false;
  }
};

const bukaModalEdit = (item) => {
  editForm.value = { ...item };
  editGambarFile.value = null;
  editGambarPreview.value = getGambarUrl(item.gambar);
  showEditModal.value = true;
};

const onEditGambarChange = (e) => {
  const file = e.target.files[0];
  if (!file) return;
  editGambarFile.value = file;
  const reader = new FileReader();
  reader.onload = (ev) => { editGambarPreview.value = ev.target.result; };
  reader.readAsDataURL(file);
};

const hapusGambarEdit = () => {
  editGambarFile.value = null;
  editGambarPreview.value = '';
  editForm.value.gambar = '';
  if (editGambarInput.value) editGambarInput.value.value = '';
};

const updateBarang = async () => {
  try {
    const fd = new FormData();
    fd.append('_method', 'PUT');
    fd.append('kode_barang', editForm.value.kode_barang);
    fd.append('nama_barang', editForm.value.nama_barang);
    fd.append('kategori', editForm.value.kategori);
    fd.append('harga', editForm.value.harga);
    fd.append('stok', editForm.value.stok);
    if (editGambarFile.value) {
      // Upload file baru
      fd.append('gambar_file', editGambarFile.value);
    } else {
      // Pertahankan URL lama atau kosongkan jika sudah dihapus
      fd.append('gambar', editForm.value.gambar ?? '');
    }
    await $fetch(`http://localhost/crud-laravel/public/api/barang/${editForm.value.id}`, {
      method: 'POST',
      headers: { Authorization: `Bearer ${token.value}` },
      body: fd,
    });
    showToast('Data barang berhasil diperbarui!', 'success');
    showEditModal.value = false;
    loadBarang();
  } catch (err) {
    showToast(err.data?.message || 'Gagal memperbarui barang.', 'error');
  }
};

const hapusBarang = async (item) => {
  if (item.stok > 0) return showToast(`Penghapusan ditolak! Produk '${item.nama_barang}' masih memiliki stok (${item.stok} unit).`, "error");
  if (!confirm(`Yakin ingin menghapus ${item.nama_barang}?`)) return;

  try {
    await $fetch(`http://localhost/crud-laravel/public/api/barang/${item.id}`, {
      method: "DELETE",
      headers: { Authorization: `Bearer ${token.value}` },
    });
    showToast("Barang berhasil dihapus.", "success");
    loadBarang();
  } catch (err) {
    showToast(err.data?.message || "Gagal menghapus barang.", "error");
  }
};
</script>