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
  <script>
    MsgElem = document.getElementById("msg")
    TokenElem = document.getElementById("token")
    NotisElem = document.getElementById("notis")
    ErrElem = document.getElementById("err")
  </script>

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>
  {{-- <script src="/js/firebase-messaging-sw.js"></script> --}}
  <script>
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

    function startFCM() {
      messaging
        .requestPermission()
        .then(function() {
          return messaging.getToken()
        })
        .then(function(response) {
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
          $.ajax({
            url: '{{ route('store.token') }}',
            type: 'POST',
            data: {
              token: response
            },
            dataType: 'JSON',
            success: function(response) {
              alert('Token stored.');
            },
            error: function(error) {
              alert(...error);
            },
          });
        }).catch(function(error) {
          alert(...error);
        });
    }
    messaging.onMessage(function(payload) {
      const title = payload.notification.title;
      const options = {
        body: payload.notification.body,
        icon: payload.notification.icon,
      };
      new Notification(title, options);
    });
  </script>
</body>

</html>
