const puppeteer = require('puppeteer-core');
const fs = require('fs');

(async () => {
    const screenshotDir = 'C:/Users/david/.gemini/antigravity/brain/8e74d1cd-3e8a-4d2d-944a-e0099b6e4c9c/scratch/merchant_inspect';
    if (!fs.existsSync(screenshotDir)) {
        fs.mkdirSync(screenshotDir, { recursive: true });
    }

    console.log('Launching browser...');
    const browser = await puppeteer.launch({
        headless: false,
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
        try {
            await page.evaluate(() => {
                const buttons = Array.from(document.querySelectorAll('button'));
                const acceptBtn = buttons.find(b => b.textContent.includes('Sí, acepto') || b.textContent.includes('Aceptar') || b.textContent.includes('Accept'));
                if (acceptBtn) acceptBtn.click();
            });
            await new Promise(resolve => setTimeout(resolve, 1500));
            console.log('Dismissed cookie banner.');
        } catch (e) {
            console.log('Cookie banner dismissal failed/skipped:', e.message);
        }
        
        await page.screenshot({ path: `${screenshotDir}/02.5_before_login_click.png` });
        await page.click('#btnLogin');
        await page.keyboard.press('Enter');
        
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
        await page.screenshot({ path: `${screenshotDir}/05_website_payments.png`, fullPage: true });

    } catch (e) {
        console.error('TEST FAILED:', e);
        await page.screenshot({ path: `${screenshotDir}/error_state.png` });
    } finally {
        await browser.close();
    }
})();
