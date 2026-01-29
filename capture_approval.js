import puppeteer from 'puppeteer';
import fs from 'fs';
import path from 'path';

const BASE_URL = 'http://127.0.0.1:8080';
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
    h1, h2, h3, h4, h5, h6, p, span, div, a, th, td { color: #000000 !important; }
    img, svg { filter: grayscale(100%) contrast(100%); }
    table { width: 100%; border: 1px solid #000; }
    td, th { border: 1px solid #000; padding: 4px; }
`;

async function capture() {
    try {
        console.log('Launching browser...');
        const browser = await puppeteer.launch({ headless: "new" });
        const page = await browser.newPage();
        await page.setViewport({ width: 1440, height: 900 });

        console.log(`Navigating to ${BASE_URL}/login`);
        await page.goto(`${BASE_URL}/login`, { waitUntil: 'domcontentloaded', timeout: 60000 });
        
        console.log('Typing credentials...');
        await page.type('#email', HEAD_EMAIL);
        await page.type('#password', HEAD_PASS);
        
        console.log('Clicking login...');
        const nav = page.waitForNavigation({ waitUntil: 'domcontentloaded', timeout: 60000 });
        await page.click('button[type="submit"]');
        await nav;
        
        console.log('Logged in. URL:', page.url());
        await page.screenshot({ path: path.join(OUTPUT_DIR, 'debug_login.png') });
        console.log('Saved debug_login.png');

        // FORCE GO TO APPROVAL
        const targetUrl = `${BASE_URL}/purchases/requests`;
        console.log(`Navigating to ${targetUrl}...`);
        await page.goto(targetUrl, { waitUntil: 'domcontentloaded', timeout: 60000 });
        
        console.log('Target URL reached:', page.url());
        await page.screenshot({ path: path.join(OUTPUT_DIR, 'debug_nav.png') });

        if (page.url().includes('login')) {
            console.error('ERROR: Still on login page or redirected back.');
        } 
        
        // INJECT CSS & SAVE ANYWAY
        await page.addStyleTag({content: WIREFRAME_CSS});
        const finalPath = path.join(OUTPUT_DIR, 'ui_approval_pengadaan.png');
        await page.screenshot({ path: finalPath, fullPage: true });
        console.log(`Saved ${finalPath} (Wireframe Mode)`);
        
        await browser.close();
    } catch (error) {
        console.error('FATAL ERROR:', error);
        process.exit(1);
    }
}

capture();
