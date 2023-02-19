<html>
<title>Firebase Messaging Demo</title>
<style>
  div {
    margin-bottom: 15px;
  }
</style>

<body>
  <div id="token"></div>
  <div id="msg"></div>
  <div id="notis"></div>
  <div id="err"></div>
  <!-- The core Firebase JS SDK is always required and must be listed first -->
  <script src="https://www.gstatic.com/firebasejs/8.4.2/firebase-app.js"></script>

  <script src="https://www.gstatic.com/firebasejs/7.16.1/firebase-messaging.js"></script>
  <script>
    MsgElem = document.getElementById('msg');
    TokenElem = document.getElementById('token');
    NotisElem = document.getElementById('notis');
    ErrElem = document.getElementById('err');

    // TODO: Replace firebaseConfig you get from Firebase Console
    var firebaseConfig = {
      apiKey: "AIzaSyBSomLWfzFMaP7LVwZCEX3mcpfMl5BYZjs",
      authDomain: "test-push-notif-e03c6.firebaseapp.com",
      projectId: "test-push-notif-e03c6",
      storageBucket: "test-push-notif-e03c6.appspot.com",
      messagingSenderId: "234028666070",
      appId: "1:234028666070:web:ac311d121b154382324d77",
      measurementId: "G-M1B5NKQR9J"
    };
    firebase.initializeApp(firebaseConfig);

    const messaging = firebase.messaging();
    messaging
      .requestPermission()
      .then(function() {
        MsgElem.innerHTML = 'Notification permission granted.';
        console.log('Notification permission granted.ss');

        // get the token in the form of promise
        return messaging.getToken();
      })
      .then(function(token) {
        TokenElem.innerHTML = 'Device token is : <br>' + token;
      })
      .catch(function(err) {
        ErrElem.innerHTML = ErrElem.innerHTML + '; ' + err;
        console.log('Unable to get permission to notify.', err);
      });

    let enableForegroundNotification = true;
    messaging.onMessage(function(payload) {
      console.log('Message received. ', payload);
      NotisElem.innerHTML =
        NotisElem.innerHTML + JSON.stringify(payload);

      if (enableForegroundNotification) {
        let notification = payload.notification;
        navigator.serviceWorker
          .getRegistrations()
          .then((registration) => {
            registration[0].showNotification(notification.title, {
              body: notification.body,
              icon: "../images/touch/chrome-touch-icon-192x192.png",
              vibrate: [200, 100, 200, 100, 200, 100, 200],
              tag: "vibration-sample",
            });
          });
      }
    });
  </script>
</body>

</html>
