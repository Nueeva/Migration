export default defineNuxtRouteMiddleware((to, from) => {
  const token = useCookie('token');

  // Jika belum login dan mengakses halaman kasir/barang/riwayat, cegah render & langsung lempar ke login
  if (!token.value && to.path !== '/') {
    return navigateTo('/', { replace: true });
  }

  // Jika sudah login dan mengakses halaman login (/), langsung lempar ke /kasir
  if (token.value && to.path === '/') {
    return navigateTo('/kasir', { replace: true });
  }
});
