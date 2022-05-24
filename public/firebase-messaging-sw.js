importScripts('https://www.gstatic.com/firebasejs/8.2.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.2.1/firebase-messaging.js');

 var firebaseConfig = {
    apiKey: "AIzaSyByAy754sSsEypZRiG41Xi2eV1vKB_YWhk",
    authDomain: "safwa-295107.firebaseapp.com",
    projectId: "safwa-295107",
    storageBucket: "safwa-295107.appspot.com",
    messagingSenderId: "144192899531",
    appId: "1:144192899531:web:2998fc8c9a5e80dfc6ce4e",
    measurementId: "G-7LQWJLBSVB"
  };

firebase.initializeApp(firebaseConfig);
const messaging=firebase.messaging();

messaging.setBackgroundMessageHandler(function (payload) {
    console.log(payload);
    const notification=JSON.parse(payload);
    const notificationOption={
        body:notification.body,
        icon:notification.icon
    };
    return self.registration.showNotification(payload.notification.title,notificationOption);
});