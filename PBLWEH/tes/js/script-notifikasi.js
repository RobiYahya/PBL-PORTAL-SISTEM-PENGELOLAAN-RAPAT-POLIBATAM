/* KODE JAVASCRIPT UNTUK js/script-notification.js */

function toggleNotifications() {
  document.getElementById("notificationDropdown").classList.toggle("show");
}

// Tutup notifikasi jika pengguna mengklik di luar area notifikasi
window.onclick = function (event) {
  if (
    !event.target.matches(".notification-icon") &&
    !event.target.closest(".notification-icon")
  ) {
    const dropdown = document.getElementById("notificationDropdown");
    if (dropdown && dropdown.classList.contains("show")) {
      dropdown.classList.remove("show");
    }
  }
};
