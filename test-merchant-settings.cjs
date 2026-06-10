const puppeteer = require('puppeteer-core');
const fs = require('fs');

(async () => {
    const screenshotDir = 'C:/Users/david/.gemini/antigravity/brain/93656c5a-34d9-452d-b02e-a2692444d768/scratch/merchant_inspect';
    if (!fs.existsSync(screenshotDir)) {
        fs.mkdirSync(screenshotDir, { recursive: true });
    }

    console.log('Launching browser...');
    const browser = await puppeteer.launch({
        headless: true,
        executablePath: 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe',
        args: ['--no-sandbox', '--disable-setuid-sandbox']
    });

    const page = await browser.newPage();
    page.on('console', msg => console.log('BROWSER CONSOLE:', msg.text()));
    page.on('pageerror', err => console.log('BROWSER ERROR:', err.toString()));

    try {
        console.log('Navigating to sandbox.paypal.com/signin...');
        await page.goto('https://sandbox.paypal.com/signin', { waitUntil: 'load' });
        await page.screenshot({ path: `${screenshotDir}/01_signin.png` });

        console.log('Entering email...');
        await page.waitForSelector('#email');
        await page.type('#email', 'sb-vgesz51435828@business.example.com');

        const nextBtn = await page.$('#btnNext');
        if (nextBtn) {
            await nextBtn.click();
            await new Promise(resolve => setTimeout(resolve, 4000));
        }

        console.log('Entering password...');
        await page.waitForSelector('#password');
        await page.type('#password', 'yvu<=Ur4');
        await page.screenshot({ path: `${screenshotDir}/02_password_entered.png` });

        console.log('Clicking Log In...');
        await page.click('#btnLogin');
        
        console.log('Waiting 12 seconds for main page...');
        await new Promise(resolve => setTimeout(resolve, 12000));
        await page.screenshot({ path: `${screenshotDir}/03_merchant_home.png` });

        console.log('Navigating to account settings...');
        await page.goto('https://sandbox.paypal.com/businessprofile/settings', { waitUntil: 'load' });
        console.log('Waiting 8 seconds for profile settings...');
        await new Promise(resolve => setTimeout(resolve, 8000));
        await page.screenshot({ path: `${screenshotDir}/04_merchant_settings.png` });

        console.log('Navigating to website payments...');
        await page.goto('https://sandbox.paypal.com/cgi-bin/customerprofileweb?cmd=_profile-website-payments', { waitUntil: 'load' });
        console.log('Waiting 8 seconds for website payments...');
        await new Promise(resolve => setTimeout(resolve, 8000));
        await page.screenshot({ path: `${screenshotDir}/05_website_payments.png` });

    } catch (e) {
        console.error('TEST FAILED:', e);
        await page.screenshot({ path: `${screenshotDir}/error_state.png` });
    } finally {
        await browser.close();
    }
})();
