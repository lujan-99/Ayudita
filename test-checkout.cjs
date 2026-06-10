const puppeteer = require('puppeteer-core');

(async () => {
    const screenshotDir = 'C:/Users/david/.gemini/antigravity/brain/93656c5a-34d9-452d-b02e-a2692444d768/scratch';
    
    console.log('Launching browser...');
    const browser = await puppeteer.launch({
        headless: true,
        executablePath: 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe',
        args: ['--no-sandbox', '--disable-setuid-sandbox']
    });

    const page = await browser.newPage();
    
    // Log console messages
    page.on('console', msg => console.log('BROWSER CONSOLE:', msg.text()));
    page.on('pageerror', err => console.log('BROWSER ERROR:', err.toString()));

    try {
        console.log('Navigating to login page...');
        await page.goto('http://127.0.0.1:8000/login', { waitUntil: 'networkidle2' });
        await page.screenshot({ path: `${screenshotDir}/01_login_page.png` });

        console.log('Filling login form...');
        await page.type('#email', 'test@example.com');
        await page.type('#password', 'password');
        await page.screenshot({ path: `${screenshotDir}/02_login_filled.png` });

        console.log('Submitting login form...');
        await Promise.all([
            page.click('button[type="submit"]'),
            page.waitForNavigation({ waitUntil: 'networkidle2' })
        ]);
        await page.screenshot({ path: `${screenshotDir}/03_after_login.png` });

        console.log('Navigating to paywall...');
        await page.goto('http://127.0.0.1:8000/premium-paywall', { waitUntil: 'networkidle2' });
        await page.screenshot({ path: `${screenshotDir}/04_paywall_page.png` });

        // Wait for the PayPal buttons iframe to load
        console.log('Waiting for PayPal buttons container...');
        await page.waitForSelector('#paypal-button-container iframe');
        await page.screenshot({ path: `${screenshotDir}/05_paypal_buttons_loaded.png` });

        // Find the iframe
        const iframeElement = await page.$('#paypal-button-container iframe');
        
        console.log('Clicking the PayPal button inside iframe...');
        const boundingBox = await iframeElement.boundingBox();
        // Click the middle of the iframe which corresponds to the first button (yellow PayPal button)
        await page.mouse.click(boundingBox.x + boundingBox.width / 2, boundingBox.y + boundingBox.height / 3);
        console.log('Clicked. Waiting 10 seconds for popup target to register...');
        await new Promise(resolve => setTimeout(resolve, 10000));
        await page.screenshot({ path: `${screenshotDir}/06_after_click.png` });

        // Get the popup target
        const targets = await browser.targets();
        const popupTarget = targets.find(t => t.type() === 'page' && t.url().includes('paypal.com'));
        
        if (!popupTarget) {
            console.log('PayPal popup target not found. Checking all targets:');
            targets.forEach(t => console.log('Target URL:', t.url(), 'Type:', t.type()));
            throw new Error('PayPal popup did not open.');
        }

        console.log('Connecting to PayPal popup...');
        const popupPage = await popupTarget.page();
        popupPage.on('console', msg => console.log('POPUP CONSOLE:', msg.text()));
        popupPage.on('pageerror', err => console.log('POPUP ERROR:', err.toString()));

        await popupPage.screenshot({ path: `${screenshotDir}/07_popup_loaded.png` });

        console.log('Entering PayPal sandbox credentials...');
        await popupPage.waitForSelector('input[type="email"]');
        await popupPage.type('input[type="email"]', 'sb-pqovk51403234@personal.example.com');
        await popupPage.screenshot({ path: `${screenshotDir}/08_popup_email.png` });

        // Click next/submit button
        const nextButton = await popupPage.$('#btnNext');
        if (nextButton) {
            await nextButton.click();
            console.log('Clicked Next button. Waiting for password field...');
            await new Promise(resolve => setTimeout(resolve, 4000));
        }

        await popupPage.waitForSelector('input[type="password"]');
        await popupPage.type('input[type="password"]', '7<mmEz?f');
        await popupPage.screenshot({ path: `${screenshotDir}/09_popup_password.png` });

        console.log('Submitting login...');
        const loginBtn = await popupPage.$('#btnLogin');
        await loginBtn.click();
        
        console.log('Waiting 15 seconds for checkout options...');
        await new Promise(resolve => setTimeout(resolve, 15000));
        await popupPage.screenshot({ path: `${screenshotDir}/10_popup_checkout_options.png` });

        console.log('Looking for payment confirmation button...');
        await popupPage.waitForSelector('#payment-submit-btn');
        await popupPage.screenshot({ path: `${screenshotDir}/11_popup_before_submit.png` });
        
        console.log('Clicking Pay Now...');
        await popupPage.click('#payment-submit-btn');

        console.log('Waiting 15 seconds for transaction to complete...');
        await new Promise(resolve => setTimeout(resolve, 15000));

        await page.screenshot({ path: `${screenshotDir}/12_final_landing.png` });
        console.log('Test completed successfully.');

    } catch (e) {
        console.error('TEST FAILED:', e);
        try {
            await page.screenshot({ path: `${screenshotDir}/error_state.png` });
        } catch(err) {
            console.error('Failed to take error screenshot:', err);
        }
    } finally {
        await browser.close();
    }
})();
