importScripts('https://www.gstatic.com/firebasejs/10.13.1/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.13.1/firebase-messaging-compat.js');

// Initialize Firebase
const firebaseConfig = {
    apiKey: "AIzaSyAvflfLnljo5aI5wln6wapt28uQOIk-XT4",
    authDomain: "product-catalogue-c802f.firebaseapp.com",
    projectId: "product-catalogue-c802f",
    storageBucket: "product-catalogue-c802f.appspot.com",
    messagingSenderId: "1097562957092",
    appId: "1:1097562957092:web:a34222a70e264758c23fb1",
    measurementId: "G-LRJX66KKSD"
};

firebase.initializeApp(firebaseConfig);

// Initialize messaging
const messaging = firebase.messaging();

// Handle background message
messaging.onBackgroundMessage(function(payload) {
  console.log('[firebase-messaging-sw.js] Received background message ', payload);
  const notificationTitle = payload.notification.title;
  const notificationOptions = {
    title: payload.notification.title,
    body: payload.notification.body,
    icon: payload.notification.icon,
    URL: payload.notification.url
  };

  self.registration.showNotification(notificationTitle, notificationOptions);
});
