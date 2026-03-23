const { chromium } = require('playwright');
const fs = require('fs');

(async () => {
    const outDir = 'Screenshots';
    if (!fs.existsSync(outDir)) {
        fs.mkdirSync(outDir);
    }

    console.log('Launching browser...');
    const browser = await chromium.launch({ headless: true });
    const context = await browser.newContext({
        viewport: { width: 1440, height: 900 }
    });
    const page = await context.newPage();

    console.log('Logging in as Kepala...');
    await page.goto('http://127.0.0.1:8000/login');
    await page.fill('input[name="email"]', 'kepala@gmail.com');
    await page.fill('input[name="password"]', '12345678');
    
    await Promise.all([
        page.waitForNavigation({ waitUntil: 'networkidle' }),
        page.click('button[type="submit"]')
    ]);
    console.log('Login successful.');

    // Enable wireframe mode in local storage
    await page.evaluate(() => {
        localStorage.setItem('wireframeMode', 'true');
    });

    async function capture(url, filename) {
        console.log(`Navigating to ${url}...`);
        await page.goto(url, { waitUntil: 'load' });
        
        // Let animations complete and fonts load
        await page.waitForTimeout(1500); 

        // Apply tailwind wireframe class if not already there since localstorage might not fully trigger without reload or Alpine watcher trigger.
        await page.evaluate(() => {
            document.body.classList.add('wireframe-mode');
        });
        await page.waitForTimeout(500); // give alpine/CSS time to react
        
        await page.screenshot({ path: `${outDir}/${filename}`, fullPage: true });
        console.log(`Saved: ${filename}`);
    }

    // 1. Gambar 3.28
    await capture('http://127.0.0.1:8000/tools', 'Gambar_3_28_Rancangan_Laporan_Data_Master_Inventaris.png');

    // 2. Gambar 3.29
    await capture('http://127.0.0.1:8000/borrowings', 'Gambar_3_29_Rancangan_Laporan_Riwayat_Peminjaman_Alat.png');

    // 3. Gambar 3.30
    await capture('http://127.0.0.1:8000/purchases/requests', 'Gambar_3_30_Rancangan_Laporan_Status_Pengajuan_RAB.png');

    // 4. Gambar 3.31
    await capture('http://127.0.0.1:8000/maintenances', 'Gambar_3_31_Rancangan_Laporan_Rekapitulasi_Pemeliharaan.png');

    // 5. Gambar 3.32 (QR Codes render)
    await capture('http://127.0.0.1:8000/dev/screenshot/qr', 'Gambar_3_32_Rancangan_Cetak_Label_Stiker_QR_Code.png');

    // 6. Gambar 3.33 (PDF Pengesahan RAB HTML Version)
    await capture('http://127.0.0.1:8000/dev/screenshot/rab', 'Gambar_3_33_Rancangan_Cetak_Dokumen_Pengesahan_RAB.png');

    // 7. Gambar 3.34 (PDF Bukti Transaksi Peminjaman HTML Version)
    await capture('http://127.0.0.1:8000/dev/screenshot/bukti-pinjam', 'Gambar_3_34_Rancangan_Cetak_Bukti_Transaksi_Peminjaman.png');

    // 8. Gambar 3.35 (Rekapitulasi Laporan / Pusat Analitik Laporan)
    await capture('http://127.0.0.1:8000/reports', 'Gambar_3_35_Rancangan_Cetak_Rekapitulasi_Laporan.png');

    console.log('All screenshots captured successfully.');
    await browser.close();
})();
