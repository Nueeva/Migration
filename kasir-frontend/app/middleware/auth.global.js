export default defineNuxtRouteMiddleware((to, from) => {
  const token = useCookie('token');
  const role = useCookie('role');

  // Jika belum login dan mengakses selain halaman login (/), alihkan langsung ke /
  if (!token.value && to.path !== '/') {
    return navigateTo('/');
  }

  // Jika sudah login dan mengakses halaman login (/)
  if (token.value && to.path === '/') {
    if (role.value === 'kasir') {
      return navigateTo('/kasir');
    }
    return navigateTo('/dashboard');
  }

  // Proteksi Akses Role Kasir: Tidak boleh mengakses /dashboard atau /barang
  if (token.value && role.value === 'kasir') {
    if (to.path === '/dashboard' || to.path === '/barang') {
      return navigateTo('/kasir');
    }
  }
});
