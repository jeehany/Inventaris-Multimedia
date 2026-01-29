import puppeteer from 'puppeteer';
import fs from 'fs';
import path from 'path';

const BASE_URL = 'http://app-inventaris.test';
const OUTPUT_DIR = path.resolve('public/wireframe');

const HEAD_EMAIL = 'kepala@gmail.com';
const HEAD_PASS = '12345678';

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
    .bg-white, .bg-slate-50, .card, .p-6, .p-8, .rounded-xl, .rounded-lg, .border {
        border: 1px solid #000000 !important;
    }
    .blur-3xl, .animate-pulse, .absolute.top-0, .absolute.bottom-0 {
        display: none !important;
    }
    h1, h2, h3, h4, h5, h6, p, span, div, a, th, td {
        color: #000000 !important;
    }
    img, svg { filter: grayscale(100%) contrast(100%); }
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
        
        console.log('Logging in as Head...');
        await page.type('#email', HEAD_EMAIL);
        await page.type('#password', HEAD_PASS);
        
        // Wait for navigation after click
        const nav = page.waitForNavigation({ waitUntil: 'networkidle0' });
        await page.click('button[type="submit"]');
        await nav;
        
        console.log('Logged in. Navigating to Approval Page...');
        // Use networkidle0 for safety, like dashboard script
        await page.goto(`${BASE_URL}/purchases/requests`, { waitUntil: 'networkidle0' });
        
        // CHECK IF REDIRECTED TO LOGIN
        if (page.url().includes('login')) {
             console.error('ERROR: Redirected to login page!');
        }

        // INJECT WIREFRAME CSS
        await page.addStyleTag({content: WIREFRAME_CSS});
        
        if (!fs.existsSync(OUTPUT_DIR)){
            fs.mkdirSync(OUTPUT_DIR, { recursive: true });
        }

        const outputPath = path.join(OUTPUT_DIR, 'ui_approval_pengadaan.png');
        await page.screenshot({ path: outputPath, fullPage: true });
        console.log(`Saved ${outputPath} (Wireframe Mode)`);

    } catch (error) {
        console.error('Error:', error);
    } finally {
        await browser.close();
    }
}

capture();
