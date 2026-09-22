<template>
  <div v-if="token" class="min-h-screen pb-12">
    <!-- Navbar Header & Mobile Side Panel -->
    <AppHeader activePage="dashboard" />

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6 pt-24 sm:pt-28">
      
      <!-- Welcome Banner & Quick Action Shortcuts -->
      <div class="glass-card p-6 sm:p-8 relative overflow-hidden flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
        <div class="relative z-10 max-w-xl">
          <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 mb-3">
            <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span>
            <span class="text-xs font-semibold text-blue-300">CLOUVIA Executive Monitor</span>
          </div>
          <h2 class="text-2xl sm:text-3xl font-black text-white tracking-tight">Selamat Datang, Admin! 👋</h2>
          <p class="text-xs sm:text-sm text-slate-400 mt-2 leading-relaxed">
            Monitor seluruh aktivitas toko komputer, performa pendapatan, stok inventaris produk, dan riwayat transaksi secara real-time.
          </p>
        </div>

        <div class="relative z-10 flex flex-wrap gap-2.5 w-full md:w-auto">
          <NuxtLink to="/kasir" class="btn-primary py-3 px-5 text-xs font-bold flex items-center justify-center gap-2 shadow-lg shadow-blue-600/30">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z" /></svg>
            Buka Kasir POS
          </NuxtLink>
          <NuxtLink to="/barang" class="px-4 py-3 rounded-xl bg-white/[0.05] border border-white/[0.08] hover:bg-white/[0.1] text-xs font-semibold text-white flex items-center justify-center gap-2 transition-all">
            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
            Kelola Stok
          </NuxtLink>
        </div>

        <!-- Decorative background glow -->
        <div class="absolute -top-24 -right-24 w-72 h-72 rounded-full bg-blue-600/10 blur-3xl pointer-events-none"></div>
      </div>

      <!-- ===== SKELETON LOADING STATE FOR CARDS & CHARTS ===== -->
      <div v-if="isLoading" class="space-y-6 animate-pulse">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          <div v-for="n in 4" :key="n" class="h-32 rounded-2xl bg-white/[0.04] border border-white/[0.06] p-5 space-y-3">
            <div class="h-4 w-24 bg-white/10 rounded"></div>
            <div class="h-8 w-36 bg-white/20 rounded"></div>
            <div class="h-3 w-28 bg-white/10 rounded"></div>
          </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
          <div class="lg:col-span-8 h-80 rounded-2xl bg-white/[0.04] border border-white/[0.06] p-6 space-y-4">
            <div class="h-5 w-48 bg-white/10 rounded"></div>
            <div class="h-56 bg-white/5 rounded-xl"></div>
          </div>
          <div class="lg:col-span-4 h-80 rounded-2xl bg-white/[0.04] border border-white/[0.06] p-6 space-y-4">
            <div class="h-5 w-40 bg-white/10 rounded"></div>
            <div class="h-56 bg-white/5 rounded-xl"></div>
          </div>
        </div>
      </div>

      <!-- ===== DASHBOARD CONTENT ===== -->
      <template v-else>
        <!-- Key Analytics Metrics (4 Cards) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          <!-- Card 1: Total Omset -->
          <div class="glass-card p-5 relative overflow-hidden group hover:border-blue-500/30 transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
              <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Omset</span>
              <div class="w-10 h-10 rounded-xl bg-blue-500/15 border border-blue-500/20 flex items-center justify-center text-blue-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
              </div>
            </div>
            <p class="text-2xl sm:text-3xl font-black text-white truncate">Rp {{ Number(stats.total_omset || 0).toLocaleString('id-ID') }}</p>
            <div class="flex items-center gap-1.5 mt-2 text-xs text-emerald-400 font-medium">
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
              <span>Total Pendapatan Terakumulasi</span>
            </div>
          </div>

          <!-- Card 2: Total Transaksi -->
          <div class="glass-card p-5 relative overflow-hidden group hover:border-sky-500/30 transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
              <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Pesanan</span>
              <div class="w-10 h-10 rounded-xl bg-sky-500/15 border border-sky-500/20 flex items-center justify-center text-sky-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
              </div>
            </div>
            <p class="text-2xl sm:text-3xl font-black text-white">{{ stats.total_transaksi || 0 }} <span class="text-sm font-normal text-slate-400">Order</span></p>
            <p class="text-xs text-slate-500 mt-2">Berhasil diproses kasir</p>
          </div>

          <!-- Card 3: Omset Hari Ini -->
          <div class="glass-card p-5 relative overflow-hidden group hover:border-emerald-500/30 transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
              <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Omset Hari Ini</span>
              <div class="w-10 h-10 rounded-xl bg-emerald-500/15 border border-emerald-500/20 flex items-center justify-center text-emerald-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
              </div>
            </div>
            <p class="text-2xl sm:text-3xl font-black text-white truncate">Rp {{ Number(stats.omset_hari_ini || 0).toLocaleString('id-ID') }}</p>
            <p class="text-xs text-emerald-400 font-medium mt-2 flex items-center gap-1">
              <span>⚡ {{ stats.transaksi_hari_ini || 0 }} transaksi hari ini</span>
            </p>
          </div>

          <!-- Card 4: Total Produk & Stok Alert -->
          <div class="glass-card p-5 relative overflow-hidden group hover:border-purple-500/30 transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
              <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Katalog Produk</span>
              <div class="w-10 h-10 rounded-xl bg-purple-500/15 border border-purple-500/20 flex items-center justify-center text-purple-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
              </div>
            </div>
            <p class="text-2xl sm:text-3xl font-black text-white">{{ stats.total_produk || 0 }} <span class="text-sm font-normal text-slate-400">Item</span></p>
            <div class="flex items-center gap-2 mt-2 text-xs">
              <span v-if="stats.stok_menipis_count > 0" class="px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-300 border border-amber-500/30 font-semibold">
                ⚠️ {{ stats.stok_menipis_count }} Stok Menipis
              </span>
              <span v-else class="text-slate-500">Stok inventaris aman</span>
            </div>
          </div>
        </div>

        <!-- ===== CHARTS SECTION (2 COLUMNS) ===== -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
          
          <!-- Chart 1: Daily Revenue Trend (8 Columns) -->
          <div class="lg:col-span-8 glass-card p-5 sm:p-6 space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-white/[0.06] pb-4">
              <div>
                <h3 class="text-base font-bold text-white flex items-center gap-2">
                  <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" /></svg>
                  Grafik Penjualan 7 Hari Terakhir
                </h3>
                <p class="text-xs text-slate-400 mt-0.5">Tren statistik omset harian toko</p>
              </div>
              <span class="text-xs px-3 py-1 rounded-full bg-blue-500/10 text-blue-300 border border-blue-500/20 font-mono font-semibold self-start sm:self-auto">
                7 Hari Terakhir
              </span>
            </div>

            <!-- SVG Area Chart -->
            <div class="relative h-64 w-full pt-4">
              <svg class="w-full h-full overflow-visible" viewBox="0 0 700 220" preserveAspectRatio="none">
                <!-- Definitions for Gradients -->
                <defs>
                  <linearGradient id="areaGradient" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0%" stop-color="#2563eb" stop-opacity="0.45" />
                    <stop offset="100%" stop-color="#2563eb" stop-opacity="0.0" />
                  </linearGradient>
                  <linearGradient id="lineGradient" x1="0" y1="0" x2="1" y2="0">
                    <stop offset="0%" stop-color="#3b82f6" />
                    <stop offset="50%" stop-color="#06b6d4" />
                    <stop offset="100%" stop-color="#10b981" />
                  </linearGradient>
                </defs>

                <!-- Grid Horizontal Lines -->
                <line x1="0" y1="0" x2="700" y2="0" stroke="rgba(255,255,255,0.06)" stroke-dasharray="4 4" />
                <line x1="0" y1="55" x2="700" y2="55" stroke="rgba(255,255,255,0.06)" stroke-dasharray="4 4" />
                <line x1="0" y1="110" x2="700" y2="110" stroke="rgba(255,255,255,0.06)" stroke-dasharray="4 4" />
                <line x1="0" y1="165" x2="700" y2="165" stroke="rgba(255,255,255,0.06)" stroke-dasharray="4 4" />

                <!-- Filled Area -->
                <path :d="chartAreaPath" fill="url(#areaGradient)" />

                <!-- Smooth Line -->
                <path :d="chartLinePath" fill="none" stroke="url(#lineGradient)" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" />

                <!-- Interactive Data Dots -->
                <g v-for="(point, idx) in chartPoints" :key="idx" class="cursor-pointer group/dot">
                  <circle
                    :cx="point.x"
                    :cy="point.y"
                    r="6"
                    fill="#0f172a"
                    stroke="#3b82f6"
                    stroke-width="3"
                    class="transition-all duration-200 group-hover/dot:r-8 group-hover/dot:stroke-emerald-400"
                  />
                  <!-- Hover Value Label -->
                  <text
                    :x="point.x"
                    :y="point.y - 12"
                    text-anchor="middle"
                    fill="#38bdf8"
                    font-size="11"
                    font-weight="bold"
                    class="opacity-0 group-hover/dot:opacity-100 transition-opacity font-mono"
                  >
                    Rp {{ Number(point.omset).toLocaleString('id-ID') }}
                  </text>
                </g>
              </svg>

              <!-- X-Axis Date Labels -->
              <div class="flex justify-between text-[11px] font-mono text-slate-400 pt-2 border-t border-white/[0.06]">
                <span v-for="(d, idx) in stats.daily_omset" :key="idx" class="text-center">
                  {{ d.date }}
                </span>
              </div>
            </div>
          </div>

          <!-- Chart 2: Revenue Share by Category (4 Columns) -->
          <div class="lg:col-span-4 glass-card p-5 sm:p-6 space-y-4 flex flex-col justify-between">
            <div class="border-b border-white/[0.06] pb-4">
              <h3 class="text-base font-bold text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" /></svg>
                Distribusi Kategori
              </h3>
              <p class="text-xs text-slate-400 mt-0.5">Proporsi omset per kategori produk</p>
            </div>

            <div v-if="stats.category_revenue && stats.category_revenue.length > 0" class="space-y-3.5 flex-1 flex flex-col justify-center">
              <div v-for="(c, idx) in stats.category_revenue.slice(0, 5)" :key="idx" class="space-y-1.5">
                <div class="flex justify-between text-xs font-semibold">
                  <span class="text-white">{{ c.kategori || 'Lainnya' }}</span>
                  <span class="text-emerald-400 font-mono">Rp {{ Number(c.total_revenue).toLocaleString('id-ID') }}</span>
                </div>
                <div class="w-full h-2 rounded-full bg-white/[0.06] overflow-hidden">
                  <div
                    class="h-full rounded-full transition-all duration-700"
                    :style="{ width: `${getCategoryPercent(c.total_revenue)}%` }"
                    :class="categoryColorClass(idx)"
                  ></div>
                </div>
              </div>
            </div>
            <div v-else class="py-8 text-center text-slate-500 text-xs">
              Belum ada data penjualan kategori.
            </div>
          </div>

        </div>

        <!-- Grid 2 Columns: Top Selling Products & Recent Transactions -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
          
          <!-- Left: Produk Terlaris (5 Columns) -->
          <div class="col-span-1 lg:col-span-5 glass-card p-5 sm:p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-white/[0.06] pb-4">
              <h3 class="text-base font-bold text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" /></svg>
                Produk Terlaris
              </h3>
              <span class="text-xs text-slate-500 font-semibold">Top Selling</span>
            </div>

            <div v-if="stats.produk_terlaris && stats.produk_terlaris.length > 0" class="space-y-3">
              <div
                v-for="(item, idx) in stats.produk_terlaris"
                :key="idx"
                class="flex items-center justify-between p-3 rounded-xl bg-white/[0.02] border border-white/[0.05] hover:bg-white/[0.04] transition-all"
              >
                <div class="flex items-center gap-3 min-w-0">
                  <span class="w-7 h-7 rounded-lg flex items-center justify-center text-xs font-bold font-mono" :class="idx === 0 ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : 'bg-white/[0.05] text-slate-400'">
                    #{{ idx + 1 }}
                  </span>
                  <div class="min-w-0">
                    <h4 class="text-xs sm:text-sm font-semibold text-white truncate">{{ item.nama_barang }}</h4>
                    <p class="text-[11px] text-slate-400">Total Pendapatan: Rp {{ Number(item.total_pendapatan || 0).toLocaleString('id-ID') }}</p>
                  </div>
                </div>
                <span class="px-2.5 py-1 rounded-lg bg-blue-500/10 text-blue-400 border border-blue-500/20 text-xs font-bold whitespace-nowrap ml-2">
                  {{ item.total_terjual }} Terjual
                </span>
              </div>
            </div>
            <div v-else class="py-8 text-center text-slate-500 text-xs">
              Belum ada data penjualan produk.
            </div>
          </div>

          <!-- Right: Transaksi Terbaru (7 Columns) -->
          <div class="col-span-1 lg:col-span-7 glass-card p-5 sm:p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-white/[0.06] pb-4">
              <h3 class="text-base font-bold text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Transaksi Terbaru
              </h3>
              <NuxtLink to="/riwayat" class="text-xs text-blue-400 hover:text-blue-300 font-semibold underline">
                Lihat Semua →
              </NuxtLink>
            </div>

            <div v-if="stats.transaksi_terbaru && stats.transaksi_terbaru.length > 0" class="space-y-3">
              <div
                v-for="trx in stats.transaksi_terbaru"
                :key="trx.id"
                class="p-3.5 rounded-xl bg-white/[0.02] border border-white/[0.05] hover:bg-white/[0.04] transition-all flex flex-col sm:flex-row sm:items-center justify-between gap-3 min-w-0 overflow-hidden"
              >
                <div class="min-w-0 flex-1">
                  <div class="flex items-center gap-2 flex-wrap">
                    <span class="font-mono text-xs font-bold text-blue-400 bg-blue-500/10 px-2 py-0.5 rounded border border-blue-500/20 whitespace-nowrap">
                      {{ trx.no_nota }}
                    </span>
                    <span class="text-[11px] text-slate-400 whitespace-nowrap">
                      {{ new Date(trx.created_at).toLocaleString('id-ID', { dateStyle: 'short', timeStyle: 'short' }) }}
                    </span>
                  </div>
                  <p class="text-xs text-slate-300 mt-1 truncate max-w-full">
                    {{ trx.items?.map(i => `${i.nama_barang} (${i.qty})`).join(', ') }}
                  </p>
                </div>

                <div class="flex items-center justify-between sm:justify-end gap-3 border-t sm:border-t-0 pt-2 sm:pt-0 border-white/[0.04] flex-shrink-0">
                  <span class="text-sm font-black text-white font-mono whitespace-nowrap">
                    Rp {{ Number(trx.total_harga || 0).toLocaleString('id-ID') }}
                  </span>
                  <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-500/15 text-emerald-300 border border-emerald-500/25 whitespace-nowrap">
                    Selesai
                  </span>
                </div>
              </div>
            </div>
            <div v-else class="py-8 text-center text-slate-500 text-xs">
              Belum ada transaksi yang dilakukan.
            </div>
          </div>

        </div>
      </template>

    </main>
  </div>
</template>

<script setup>
const token = useCookie("token");
const role = useCookie("role");
const isLoading = ref(true);

const stats = ref({
  total_omset: 0,
  total_transaksi: 0,
  omset_hari_ini: 0,
  transaksi_hari_ini: 0,
  total_produk: 0,
  stok_menipis_count: 0,
  stok_habis_count: 0,
  transaksi_terbaru: [],
  produk_terlaris: [],
  daily_omset: [],
  category_revenue: [],
});

const loadDashboardStats = async () => {
  isLoading.value = true;
  try {
    const res = await $fetch("http://localhost/crud-laravel/public/api/dashboard", {
      headers: { Authorization: `Bearer ${token.value}` },
    });
    stats.value = res;
  } catch (error) {
    if (error.status === 401 || error.status === 403) navigateTo("/");
    console.error("Gagal memuat statistik dashboard:", error);
  } finally {
    isLoading.value = false;
  }
};

onMounted(() => {
  if (!token.value) navigateTo("/");
  loadDashboardStats();
});

// Chart math calculations
const maxDailyOmset = computed(() => {
  if (!stats.value.daily_omset || stats.value.daily_omset.length === 0) return 1;
  const max = Math.max(...stats.value.daily_omset.map(d => d.omset));
  return max > 0 ? max : 1;
});

const chartPoints = computed(() => {
  if (!stats.value.daily_omset || stats.value.daily_omset.length === 0) return [];
  const items = stats.value.daily_omset;
  const width = 700;
  const height = 180;
  const stepX = width / (items.length - 1 || 1);

  return items.map((item, idx) => {
    const x = idx * stepX;
    const y = height - (item.omset / maxDailyOmset.value) * (height - 30) - 10;
    return { x, y, omset: item.omset, date: item.date };
  });
});

const chartLinePath = computed(() => {
  const points = chartPoints.value;
  if (points.length === 0) return "";
  return points.reduce((acc, p, idx) => (idx === 0 ? `M ${p.x} ${p.y}` : `${acc} L ${p.x} ${p.y}`), "");
});

const chartAreaPath = computed(() => {
  const points = chartPoints.value;
  if (points.length === 0) return "";
  const line = chartLinePath.value;
  const lastX = points[points.length - 1].x;
  const firstX = points[0].x;
  return `${line} L ${lastX} 200 L ${firstX} 200 Z`;
});

const totalCategoryRevenueSum = computed(() => {
  if (!stats.value.category_revenue) return 1;
  const sum = stats.value.category_revenue.reduce((a, c) => a + Number(c.total_revenue || 0), 0);
  return sum > 0 ? sum : 1;
});

const getCategoryPercent = (val) => {
  return Math.min(100, Math.max(5, Math.round((Number(val || 0) / totalCategoryRevenueSum.value) * 100)));
};

const categoryColorClass = (idx) => {
  const colors = [
    "bg-gradient-to-r from-blue-500 to-indigo-500",
    "bg-gradient-to-r from-emerald-500 to-teal-500",
    "bg-gradient-to-r from-purple-500 to-pink-500",
    "bg-gradient-to-r from-amber-500 to-orange-500",
    "bg-gradient-to-r from-sky-500 to-cyan-500",
  ];
  return colors[idx % colors.length];
};
</script>
