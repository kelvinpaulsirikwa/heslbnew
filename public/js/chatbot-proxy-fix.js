// Override chatbot backend URLs to use local proxy
(function() {
    'use strict';
    
    // Store original fetch
    const originalFetch = window.fetch;
    
    // Override fetch to intercept chatbot requests
    window.fetch = function(url, options = {}) {
        // Replace chatbot backend URLs with proxy URLs
        if (url && typeof url === 'string') {
            if (url.includes('chatbotbackend.heslb.go.tz')) {
                url = url.replace('https://chatbotbackend.heslb.go.tz', '/chatbot-proxy');
                console.log('Chatbot proxy: Redirecting to', url);
            }
        }
        
        // Call original fetch with modified URL
        return originalFetch.call(this, url, options);
    };
    
    // Also override XMLHttpRequest for any AJAX calls
    const originalXHROpen = XMLHttpRequest.prototype.open;
    XMLHttpRequest.prototype.open = function(method, url, async, user, password) {
        if (url && typeof url === 'string' && url.includes('chatbotbackend.heslb.go.tz')) {
            url = url.replace('https://chatbotbackend.heslb.go.tz', '/chatbot-proxy');
            console.log('Chatbot proxy XHR: Redirecting to', url);
        }
        return originalXHROpen.call(this, method, url, async, user, password);
    };
    
    console.log('Chatbot proxy fix loaded');
})();
