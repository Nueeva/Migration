<template>
  <header class="glass-header fixed top-0 left-0 right-0 z-50 mb-6">
    <div class="max-w-[1920px] mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
      
      <!-- Brand Logo -->
      <div class="flex items-center gap-3">
        <NuxtLink :to="role === 'kasir' ? '/kasir' : '/dashboard'" class="flex items-center gap-3 group">
          <div class="w-9 h-9 flex items-center justify-center flex-shrink-0 transition-transform group-hover:scale-105">
            <svg class="w-9 h-9" viewBox="0 0 100 100" fill="none">
              <!-- Blue top-right box -->
              <path d="M 56 10 L 88 10 A 4 4 0 0 1 92 14 L 78 54 A 4 4 0 0 1 74 58 L 42 58 A 4 4 0 0 1 38 54 L 52 14 A 4 4 0 0 1 56 10 Z" fill="#2563eb" />
              <path d="M 57 23 L 73 34 L 57 45" stroke="#0f172a" stroke-width="6.5" stroke-linecap="round" stroke-linejoin="round" fill="none" />
              <!-- White bottom-left box -->
              <path d="M 26 42 L 54 42 A 4 4 0 0 1 58 46 L 44 86 A 4 4 0 0 1 40 90 L 12 90 A 4 4 0 0 1 8 86 L 22 46 A 4 4 0 0 1 26 42 Z" fill="#ffffff" />
              <path d="M 41 55 L 25 66 L 41 77" stroke="#0f172a" stroke-width="6.5" stroke-linecap="round" stroke-linejoin="round" fill="none" />
            </svg>
          </div>
          <div>
            <h1 class="text-base font-black tracking-wider leading-none text-white">
              CLOU<span class="text-blue-500">VIA</span>
            </h1>
            <span class="text-[10px] text-blue-400 font-bold tracking-widest uppercase">Digital Service</span>
          </div>
        </NuxtLink>
      </div>

      <!-- Desktop Navigation Links (Hidden on Mobile) -->
      <nav class="hidden md:flex items-center gap-1.5 bg-white/[0.03] p-1.5 rounded-xl border border-white/[0.06]">
        <!-- Dashboard Link (Khusus Admin) -->
        <NuxtLink
          v-if="role !== 'kasir'"
          to="/dashboard"
          class="px-4 py-2 rounded-lg text-xs font-semibold flex items-center gap-2 transition-all duration-200"
          :class="activePage === 'dashboard' ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-400 hover:text-white hover:bg-white/[0.05]'"
        >
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
          Dashboard
        </NuxtLink>

        <!-- Kasir Link (Tampil untuk Semua) -->
        <NuxtLink
          to="/kasir"
          class="px-4 py-2 rounded-lg text-xs font-semibold flex items-center gap-2 transition-all duration-200"
          :class="activePage === 'kasir' ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-400 hover:text-white hover:bg-white/[0.05]'"
        >
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z" /></svg>
          Kasir POS
        </NuxtLink>

        <!-- Kelola Barang Link (Khusus Admin) -->
        <NuxtLink
          v-if="role !== 'kasir'"
          to="/barang"
          class="px-4 py-2 rounded-lg text-xs font-semibold flex items-center gap-2 transition-all duration-200"
          :class="activePage === 'barang' ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-400 hover:text-white hover:bg-white/[0.05]'"
        >
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
          Kelola Barang
        </NuxtLink>

        <!-- Riwayat Link (Tampil untuk Semua) -->
        <NuxtLink
          to="/riwayat"
          class="px-4 py-2 rounded-lg text-xs font-semibold flex items-center gap-2 transition-all duration-200"
          :class="activePage === 'riwayat' ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-400 hover:text-white hover:bg-white/[0.05]'"
        >
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
          Riwayat
        </NuxtLink>
      </nav>

      <!-- Right Side Actions & Hamburger Toggle -->
      <div class="flex items-center gap-2 sm:gap-3">

        <!-- Stock Alert Bell Notification Button -->
        <div class="relative">
          <button
            @click="isNotifOpen = !isNotifOpen"
            class="relative w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-white/[0.05] border border-white/[0.1] text-slate-300 hover:text-white hover:bg-white/[0.1] flex items-center justify-center transition-all"
            title="Notifikasi Peringatan Stok"
          >
            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            <span v-if="lowStockItems.length > 0" class="absolute -top-1 -right-1 w-5 h-5 rounded-full bg-red-500 text-white text-[10px] font-black flex items-center justify-center animate-bounce shadow-lg shadow-red-500/50">
              {{ lowStockItems.length }}
            </span>
          </button>

          <!-- Notification Dropdown Popover -->
          <Transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="opacity-0 scale-95 -translate-y-2"
            enter-to-class="opacity-100 scale-100 translate-y-0"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="opacity-100 scale-100 translate-y-0"
            leave-to-class="opacity-0 scale-95 -translate-y-2"
          >
            <div
              v-if="isNotifOpen"
              class="absolute right-0 mt-3 w-80 sm:w-96 rounded-2xl bg-slate-900 border border-white/10 shadow-2xl p-4 z-50 backdrop-blur-xl"
            >
              <div class="flex items-center justify-between pb-3 border-b border-white/10 mb-3">
                <div class="flex items-center gap-2">
                  <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
                  <h3 class="text-xs font-bold text-white uppercase tracking-wider">⚠️ Peringatan Stok Menipis</h3>
                </div>
                <span class="text-[10px] px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-300 font-bold border border-amber-500/30">
                  {{ lowStockItems.length }} Produk
                </span>
              </div>

              <div v-if="lowStockItems.length > 0" class="space-y-2 max-h-64 overflow-y-auto pr-1">
                <div
                  v-for="item in lowStockItems"
                  :key="item.id"
                  class="p-2.5 rounded-xl bg-white/[0.03] border border-white/[0.06] flex items-center justify-between gap-3 hover:bg-white/[0.06] transition-all"
                >
                  <div class="min-w-0">
                    <p class="text-xs font-bold text-white truncate">{{ item.nama_barang }}</p>
                    <p class="text-[10px] text-slate-400 font-mono">{{ item.kode_barang }}</p>
                  </div>
                  <span
                    class="px-2.5 py-1 rounded-lg text-xs font-black whitespace-nowrap"
                    :class="item.stok === 0 ? 'bg-red-500/20 text-red-400 border border-red-500/30' : 'bg-amber-500/20 text-amber-400 border border-amber-500/30'"
                  >
                    {{ item.stok === 0 ? 'HABIS (0)' : `Sisa ${item.stok}` }}
                  </span>
                </div>
              </div>

              <div v-else class="py-6 text-center text-slate-500 text-xs font-medium">
                ✅ Seluruh stok barang aman.
              </div>

              <div v-if="role !== 'kasir'" class="mt-3 pt-3 border-t border-white/10 text-center">
                <NuxtLink
                  to="/barang"
                  @click="isNotifOpen = false"
                  class="text-xs font-bold text-blue-400 hover:text-blue-300 transition-colors inline-flex items-center gap-1"
                >
                  Kelola & Restok Barang →
                </NuxtLink>
              </div>
            </div>
          </Transition>
        </div>

        <!-- Role Badge -->
        <div v-if="role === 'kasir'" class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/20">
          <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
          <span class="text-xs font-semibold text-emerald-300">👤 Staff Kasir</span>
        </div>
        <div v-else class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-500/10 border border-blue-500/20">
          <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span>
          <span class="text-xs font-semibold text-blue-300">👑 Admin Executive</span>
        </div>

        <button @click="logout" class="hidden md:flex btn-danger text-xs px-3.5 py-2 items-center gap-1.5">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
          Logout
        </button>

        <!-- Hamburger Button (Garis 3) -->
        <button
          @click="isSidePanelOpen = true"
          class="md:hidden w-9 h-9 rounded-xl bg-white/[0.05] border border-white/[0.1] text-white flex items-center justify-center hover:bg-white/[0.1] active:scale-95 transition-all"
          aria-label="Buka Menu"
        >
          <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>

    </div>

    <!-- ===== MOBILE SIDE PANEL (DRAWER GARIS 3) ===== -->
    <Transition
      enter-active-class="transition-opacity duration-300 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition-opacity duration-200 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div v-if="isSidePanelOpen" class="fixed inset-0 z-[100] md:hidden flex">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/90 backdrop-blur-md" @click="isSidePanelOpen = false"></div>

        <!-- Sliding Panel (Full width on mobile phone, 80% on tablet) -->
        <Transition
          enter-active-class="transition-transform duration-300 ease-out"
          enter-from-class="translate-x-full"
          enter-to-class="translate-x-0"
          leave-active-class="transition-transform duration-200 ease-in"
          leave-from-class="translate-x-0"
          leave-to-class="translate-x-full"
        >
          <div class="relative ml-auto w-full sm:w-4/5 sm:max-w-sm h-full bg-slate-950 border-l border-white/15 p-6 flex flex-col justify-between shadow-2xl z-[101] overflow-y-auto">
            
            <!-- Drawer Header -->
            <div>
              <div class="flex items-center justify-between pb-6 border-b border-white/10 mb-6">
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 flex items-center justify-center">
                    <svg class="w-8 h-8" viewBox="0 0 100 100" fill="none">
                      <path d="M 56 10 L 88 10 A 4 4 0 0 1 92 14 L 78 54 A 4 4 0 0 1 74 58 L 42 58 A 4 4 0 0 1 38 54 L 52 14 A 4 4 0 0 1 56 10 Z" fill="#2563eb" />
                      <path d="M 57 23 L 73 34 L 57 45" stroke="#0f172a" stroke-width="6.5" stroke-linecap="round" stroke-linejoin="round" fill="none" />
                      <path d="M 26 42 L 54 42 A 4 4 0 0 1 58 46 L 44 86 A 4 4 0 0 1 40 90 L 12 90 A 4 4 0 0 1 8 86 L 22 46 A 4 4 0 0 1 26 42 Z" fill="#ffffff" />
                      <path d="M 41 55 L 25 66 L 41 77" stroke="#0f172a" stroke-width="6.5" stroke-linecap="round" stroke-linejoin="round" fill="none" />
                    </svg>
                  </div>
                  <div>
                    <h2 class="text-sm font-black text-white">CLOUVIA POS</h2>
                    <p class="text-[10px] text-blue-400 font-bold uppercase">Navigasi Utama</p>
                  </div>
                </div>

                <!-- Close Button -->
                <button
                  @click="isSidePanelOpen = false"
                  class="w-8 h-8 rounded-lg bg-white/10 border border-white/10 text-slate-400 hover:text-white flex items-center justify-center"
                >
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
              </div>

              <!-- Drawer Navigation Links -->
              <nav class="space-y-2">
                <NuxtLink
                  v-if="role !== 'kasir'"
                  to="/dashboard"
                  @click="isSidePanelOpen = false"
                  class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all"
                  :class="activePage === 'dashboard' ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30 font-bold' : 'text-slate-300 hover:bg-white/[0.05] hover:text-white'"
                >
                  <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                  Dashboard Overview
                </NuxtLink>

                <NuxtLink
                  to="/kasir"
                  @click="isSidePanelOpen = false"
                  class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all"
                  :class="activePage === 'kasir' ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30 font-bold' : 'text-slate-300 hover:bg-white/[0.05] hover:text-white'"
                >
                  <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z" /></svg>
                  Mesin Kasir POS
                </NuxtLink>

                <NuxtLink
                  v-if="role !== 'kasir'"
                  to="/barang"
                  @click="isSidePanelOpen = false"
                  class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all"
                  :class="activePage === 'barang' ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30 font-bold' : 'text-slate-300 hover:bg-white/[0.05] hover:text-white'"
                >
                  <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                  Kelola Stok Produk
                </NuxtLink>

                <NuxtLink
                  to="/riwayat"
                  @click="isSidePanelOpen = false"
                  class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all"
                  :class="activePage === 'riwayat' ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30 font-bold' : 'text-slate-300 hover:bg-white/[0.05] hover:text-white'"
                >
                  <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                  Laporan Riwayat
                </NuxtLink>
              </nav>
            </div>

            <!-- Drawer Footer -->
            <div class="pt-6 border-t border-white/10 space-y-3">
              <div class="flex items-center gap-3 p-3 rounded-xl bg-white/[0.03] border border-white/[0.05]">
                <div
                  class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs"
                  :class="role === 'kasir' ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : 'bg-blue-500/20 text-blue-400 border border-blue-500/30'"
                >
                  {{ role === 'kasir' ? 'KS' : 'AD' }}
                </div>
                <div>
                  <p class="text-xs font-bold text-white">{{ role === 'kasir' ? 'Staff Kasir' : 'Administrator' }}</p>
                  <p class="text-[10px] text-emerald-400">● Sesi Aktif</p>
                </div>
              </div>

              <button
                @click="logout"
                class="w-full py-3 rounded-xl bg-red-500/15 border border-red-500/25 text-red-400 hover:bg-red-500/25 font-bold text-xs flex items-center justify-center gap-2 transition-all"
              >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                Keluar / Logout
              </button>
            </div>

          </div>
        </Transition>
      </div>
    </Transition>
  </header>
</template>

<script setup>
defineProps({
  activePage: {
    type: String,
    default: 'dashboard',
  },
});

const token = useCookie("token");
const role = useCookie("role");
const isSidePanelOpen = ref(false);
const isNotifOpen = ref(false);
const lowStockItems = ref([]);

const fetchLowStockAlerts = async () => {
  if (!token.value) return;
  try {
    const res = await $fetch("http://localhost/crud-laravel/public/api/barang", {
      headers: { Authorization: `Bearer ${token.value}` },
    });
    if (Array.isArray(res)) {
      lowStockItems.value = res.filter(b => Number(b.stok) <= 3);
    }
  } catch (err) {
    // Fail silently
  }
};

onMounted(() => {
  fetchLowStockAlerts();
});

const logout = async () => {
  try {
    await $fetch("http://localhost/crud-laravel/public/api/logout", {
      method: "POST",
      headers: { Authorization: `Bearer ${token.value}` },
    });
  } catch (err) {
    // Abaikan jika token sudah tidak valid
  } finally {
    token.value = null;
    role.value = null;
    navigateTo("/");
  }
};
</script>
