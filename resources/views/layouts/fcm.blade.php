<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>

<script>
    var firebaseConfig = {
        apiKey: "AIzaSyAc7C45bY3AiMdMA0iuCP843PxJu60pAQ8",
        authDomain: "seminar-f832d.firebaseapp.com",
        projectId: "seminar-f832d",
        storageBucket: "seminar-f832d.appspot.com",
        messagingSenderId: "335803793634",
        appId: "1:335803793634:web:8cbdcb6e6a9252fdc29ebb",
        measurementId: "G-772K8CTM81",
    };

    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();

    function startFCM() {
        messaging
            .requestPermission()
            .then(function () {
                return messaging.getToken()
            })
            .then(function (response) {
                console.log(response);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ route("store.token") }}',
                    type: 'POST',
                    data: {
                        token: response
                    },
                    dataType: 'JSON',
                    success: function (response) {
                        console.log(response);
                        alert('Token stored.');
                    },
                    error: function (error) {
                        alert(error);
                    },
                });

            }).catch(function (error) {
                alert(error);
            });
    }

    messaging.onMessage(function (payload) {
        const title = payload.notification.title;
        const options = {
            body: payload.notification.body,
            icon: payload.notification.icon,
        };
        new Notification(title, options);
    });

</script>