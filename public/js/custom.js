/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";


/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

// Fungsi untuk mendapatkan sapaan berdasarkan waktu
function getGreeting() {
    const hour = new Date().getHours();
    let greeting;

    if (hour >= 3 && hour < 11) {
        greeting = "Selamat Pagi"; // 03:00 - 10:59 WIB
    } else if (hour >= 11 && hour < 15) {
        greeting = "Selamat Siang"; // 11:00 - 14:59 WIB
    } else if (hour >= 15 && hour < 18) {
        greeting = "Selamat Sore"; // 15:00 - 17:59 WIB
    } else {
        greeting = "Selamat Malam"; // 18:00 - 02:59 WIB
    }

    document.getElementById("greeting").innerHTML = greeting;
}

// Fungsi untuk mendapatkan URL gambar berdasarkan waktu
function getImageUrl(hour) {
    if (hour >= 3 && hour < 11) {
        return "https://cdn-icons-png.flaticon.com/512/4814/4814268.png"; // Pagi
    } else if (hour >= 11 && hour < 15) {
        return "https://cdn-icons-png.flaticon.com/512/3175/3175147.png"; // Siang
    } else if (hour >= 15 && hour < 18) {
        return "https://cdn-icons-png.flaticon.com/512/3892/3892928.png"; // Sore
    } else {
        return "https://cdn-icons-png.flaticon.com/256/2024/2024058.png"; // Malam
    }
}

// Fungsi untuk memformat angka dengan leading zero
function formatTimeUnit(unit) {
    return unit.toString().padStart(2, '0');
}

// Fungsi untuk mengupdate waktu dan sapaan
function updateTimeAndGreeting() {
    const now = new Date();
    const hour = now.getHours();
    const minute = now.getMinutes();
    const second = now.getSeconds();

    // Update jam, menit, detik
    document.getElementById('hours').textContent = formatTimeUnit(hour);
    document.getElementById('minutes').textContent = formatTimeUnit(minute);
    document.getElementById('seconds').textContent = formatTimeUnit(second);

    // Update sapaan dan gambar
    let greeting;
    if (hour >= 3 && hour < 11) {
        greeting = "Selamat Pagi";
    } else if (hour >= 11 && hour < 15) {
        greeting = "Selamat Siang";
    } else if (hour >= 15 && hour < 18) {
        greeting = "Selamat Sore";
    } else {
        greeting = "Selamat Malam";
    }

    document.getElementById("greeting").innerHTML = greeting;
    document.getElementById("clockImage").src = getImageUrl(hour);
}

// Fungsi inisialisasi
function initClock() {
    // Initial update
    getGreeting();
    updateTimeAndGreeting();

    // Set interval untuk update setiap detik
    setInterval(updateTimeAndGreeting, 1000);
}

// Jalankan ketika dokumen sudah siap
document.addEventListener('DOMContentLoaded', initClock);
