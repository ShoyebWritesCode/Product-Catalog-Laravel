import { initializeApp } from "https://www.gstatic.com/firebasejs/10.13.1/firebase-app.js";
import { getAnalytics } from "https://www.gstatic.com/firebasejs/10.13.1/firebase-analytics.js";
import { getMessaging, getToken, onMessage } from "https://www.gstatic.com/firebasejs/10.13.1/firebase-messaging.js";

// Your web app's Firebase configuration
const firebaseConfig = {
    apiKey: "AIzaSyAvflfLnljo5aI5wln6wapt28uQOIk-XT4",
    authDomain: "product-catalogue-c802f.firebaseapp.com",
    projectId: "product-catalogue-c802f",
    storageBucket: "product-catalogue-c802f.appspot.com",
    messagingSenderId: "1097562957092",
    appId: "1:1097562957092:web:a34222a70e264758c23fb1",
    measurementId: "G-LRJX66KKSD"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);

// Initialize Firebase Messaging
const messaging = getMessaging(app);

// Request permission to send notifications
Notification.requestPermission().then(permission => {
  if (permission === 'granted') {
    // Get FCM token
    getToken(messaging, { vapidKey: 'BGJnmNq3LW7qTyD498Avn3l93tGvG3V3fT9gvzWR475SwhdqkZCrGRLmFoJPzd9xC469IQ4W-Sf0GUmm9oOvkUQ' }).then(currentToken => {
      if (currentToken) {
        console.log('FCM Token:', currentToken);

        // Send token to your backend to save it
        axios.post('/store-token', { token: currentToken });
      } else {
        console.log('No registration token available. Request permission to generate one.');
      }
    }).catch(err => {
      console.log('An error occurred while retrieving token. ', err);
    });
  } else {
    console.log('Unable to get permission to notify.');
  }
});

// Handle incoming messages when the app is in the foreground
onMessage(messaging, (payload) => {
  console.log('Message received. ', payload);

  // Show notification
  const notificationTitle = payload.notification.title;
  const notificationOptions = {
    body: payload.notification.body,
    icon: payload.notification.icon
  };

  new Notification(notificationTitle, notificationOptions);
});
