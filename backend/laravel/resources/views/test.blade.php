<html>

<head>
    <title>Centrifugo quick start</title>
</head>

<body>
<h2>Данные из публичного канала channel (имя только что запрошенного пользователя по адресу /user/id)</h2>
<div id="counter">-</div>
<script src="https://unpkg.com/centrifuge@3.1.0/dist/centrifuge.js"></script>
<script type="text/javascript">
    const container = document.getElementById('counter');

    const centrifuge = new Centrifuge("ws://localhost/connection/websocket", {
        token: "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM3MjIiLCJleHAiOjE2OTg0NjUzODcsImlhdCI6MTY5Nzg2MDU4N30.PFcDvNtRmFp115s7ijw7fIcKymbQB6jnD4dxhUm-8SU"
    });

    centrifuge.on('connecting', function (ctx) {
        console.log(`connecting: ${ctx.code}, ${ctx.reason}`);
    }).on('connected', function (ctx) {
        console.log(`connected over ${ctx.transport}`);
    }).on('disconnected', function (ctx) {
        console.log(`disconnected: ${ctx.code}, ${ctx.reason}`);
    }).connect();

    const sub = centrifuge.newSubscription("channel");

    sub.on('publication', function (ctx) {
        container.innerHTML = ctx.data.value;
        document.title = ctx.data.value;
    }).on('subscribing', function (ctx) {
        console.log(`subscribing: ${ctx.code}, ${ctx.reason}`);
    }).on('subscribed', function (ctx) {
        console.log('subscribed', ctx);
    }).on('unsubscribed', function (ctx) {
        console.log(`unsubscribed: ${ctx.code}, ${ctx.reason}`);
    }).subscribe();
</script>
</body>

</html>
