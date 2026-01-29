import puppeteer from 'puppeteer';
import fs from 'fs';
import path from 'path';

const BASE_URL = 'http://app-inventaris.test'; // Adjust if needed
const OUTPUT_DIR = path.resolve('public/wireframe');

// Credentials
const ADMIN_EMAIL = 'admin@gmail.com';
const ADMIN_PASS = '12345678';
const HEAD_EMAIL = 'kepala@gmail.com';
const HEAD_PASS = '12345678';

// Wireframe CSS to inject
const WIREFRAME_CSS = `
    *, *::before, *::after {
        background-color: #ffffff !important;
        background-image: none !important;
        color: #000000 !important;
        box-shadow: none !important;
        text-shadow: none !important;
        border-radius: 0 !important;
        border-color: #000000 !important;
        transition: none !important;
    }
    body { background-color: #ffffff !important; }
    
    /* Force borders on cards and containers for structure visibility */
    .bg-white, .bg-slate-50, .card, .p-6, .p-8, .rounded-xl, .rounded-lg, .border {
        border: 1px solid #000000 !important;
    }
    
    /* Hide decorative elements completely */
    .blur-3xl, .animate-pulse, .absolute.top-0, .absolute.bottom-0 {
        display: none !important;
    }
    
    /* Ensure text is black */
    h1, h2, h3, h4, h5, h6, p, span, div, a, th, td, label, input, select, button {
        color: #000000 !important;
        border-color: #000000 !important;
    }

    img, svg { filter: grayscale(100%) contrast(100%); }
    
    /* Links underline */
    a { text-decoration: underline; }
`;

async function capture() {
    console.log('Launching browser...');
    const browser = await puppeteer.launch({ headless: "new" });
    const page = await browser.newPage();
    await page.setViewport({ width: 1440, height: 900 });

    try {
        console.log(`Navigating to ${BASE_URL}/login`);
        await page.goto(`${BASE_URL}/login`, { waitUntil: 'networkidle0' });

        // --- 1. ADMIN DASHBOARD ---
        console.log('Logging in as Admin...');
        await page.type('#email', ADMIN_EMAIL);
        await page.type('#password', ADMIN_PASS);
        await Promise.all([
            page.click('button[type="submit"]'),
            page.waitForNavigation({ waitUntil: 'networkidle0' }),
        ]);

        console.log('Taking Admin Dashboard screenshot...');
        await page.goto(`${BASE_URL}/dashboard`, { waitUntil: 'networkidle0' });
        await page.addStyleTag({content: WIREFRAME_CSS});
        
        if (!fs.existsSync(OUTPUT_DIR)){
            fs.mkdirSync(OUTPUT_DIR, { recursive: true });
        }
        await page.screenshot({ path: path.join(OUTPUT_DIR, 'ui_dashboard_admin.png'), fullPage: true });
        console.log('Saved ui_dashboard_admin.png');

        // Logout
        console.log('Logging out...');
        await page.deleteCookie(...await page.cookies());
        
        // --- 2. HEAD DASHBOARD ---
        console.log('Logging in as Head...');
        await page.goto(`${BASE_URL}/login`, { waitUntil: 'networkidle0' });
        await page.type('#email', HEAD_EMAIL);
        await page.type('#password', HEAD_PASS);
        await Promise.all([
            page.click('button[type="submit"]'),
            page.waitForNavigation({ waitUntil: 'networkidle0' }),
        ]);

        console.log('Taking Head Dashboard screenshot...');
        await page.goto(`${BASE_URL}/dashboard`, { waitUntil: 'networkidle0' });
        await page.addStyleTag({content: WIREFRAME_CSS});
        await page.screenshot({ path: path.join(OUTPUT_DIR, 'ui_dashboard_kepala.png'), fullPage: true });
        console.log('Saved ui_dashboard_kepala.png');

        // --- 3. APPROVAL PENGADAAN (HEAD) ---
        console.log('Taking Approval Pengadaan screenshot...');
        // Fixed URL: /purchases/requests (Plural)
        await page.goto(`${BASE_URL}/purchases/requests`, { waitUntil: 'networkidle0' });
        
        // Inject CSS again (navigation might clear it)
        await page.addStyleTag({content: WIREFRAME_CSS});
        
        await page.screenshot({ path: path.join(OUTPUT_DIR, 'ui_approval_pengadaan.png'), fullPage: true });
        console.log('Saved ui_approval_pengadaan.png');

    } catch (error) {
        console.error('Error:', error);
    } finally {
        await browser.close();
    }
}

capture();
