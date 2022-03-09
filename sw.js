const staticCacheName = 'site-static-v2';

const assets = [
    '/',
    'index.php',
    'css/home.css',
    'fonts/Montserrat-Light.ttf',
    'fonts/Montserrat-Bold.ttf',
    'fonts/Montserrat-SemiBold.ttf',
    'fonts/Montserrat-Medium.ttf',
    'fonts/Roboto-Regular.ttf',
    'fonts/Roboto-Bold.ttf',
    'img/bookings.png',
    'img/locations.png',
    'img/qr_code.png',
    'img/qrcode.png',
    'img/scan.png',
    'js/home_fun.js',
    'js/qrcode.min.js',
    'manifest.json',
];

self.addEventListener('install', evt => {
    // console.log('service worker has been installed');
    evt.waitUntil(
        caches.open(staticCacheName).then(cache => {
            console.log('caching shell assets');
            cache.addAll(assets);
        })
    );
}) 

self.addEventListener('activate', evt => {
    // console.log('service worker is activated');
    evt.waitUntil(
        caches.keys().then(keys => {
            return Promise.all(keys
               .filter(key => key !== staticCacheName)
               .map(key => caches.delete(key)) 
            )
        })
    );
});

self.addEventListener('fetch', evt => {
    // console.log('fetch event', evt);
        evt.respondWith(
            caches.match(evt.request).then(cacheRes => {
                return cacheRes || fetch(evt.request);
            }).catch(() => {
                if(evt.request.url.indexOf('.php') > -1){
                    return caches.match('offline.php');
                }
            
        })
    );
});

self.addEventListener('notificationclick',function(event){
    var notification = event.notification;
    var action = event.action;
    if(action == 'close'){
        notification.close();
    }else{
        clients.openWindow('https://bookbarber.in/salon_pwa/index.php');
    }
});

