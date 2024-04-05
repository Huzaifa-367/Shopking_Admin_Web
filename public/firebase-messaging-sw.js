importScripts('https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.10.1/firebase-messaging.js');
let config = {
        apiKey: "AIzaSyAbu_hYQEX6FmyrJDfeVwPUUyLmXwuAX20",
        authDomain: "sahulat-shopping.firebaseapp.com",
        projectId: "sahulat-shopping",
        storageBucket: "sahulat-shopping.appspot.com",
        messagingSenderId: "814493246737",
        appId: "1:814493246737:web:eb5fe7733df90b019ad8b0",
        measurementId: "G-ZS4VNP9ZH0",
 };
firebase.initializeApp(config);
const messaging = firebase.messaging();
messaging.onBackgroundMessage((payload) => {
    const notificationTitle = payload.notification.title;
    const notificationOptions = {
        body: payload.notification.body,
        icon: '/images/required/firebase-logo.png'
    };
    self.registration.showNotification(notificationTitle, notificationOptions);
});
