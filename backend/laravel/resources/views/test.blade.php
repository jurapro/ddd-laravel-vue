<html>

<head>
    <title>Centrifugo quick start</title>
</head>

<body>
<h2>Данные из публичного канала channel (имя только что запрошенного пользователя по адресу /user/id)</h2>
<div id="public">-</div>
<h2>Данные из пприватного канала channel.user.1 (имя только что запрошенного пользователя по адресу /user/1)</h2>
<div id="private">-</div>

<script src="https://unpkg.com/centrifuge@3.1.0/dist/centrifuge.js"></script>
<script type="text/javascript">
    const container = document.getElementById('public');
    const containerPrivate = document.getElementById('private');

    const centrifuge = new Centrifuge("ws://localhost/connection/websocket", {
        token: "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiIyIiwiZXhwIjoxNjk4MzgxNzcwLCJpbmZvIjp7Im5hbWUiOm51bGx9fQ.lucBvLUyU6qwRzJOkOQUnFkwKkq_PzavFK_NEzpUw0o"
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


    const subPrivate = centrifuge.newSubscription("channel.user.1");

    subPrivate.on('publication', function (ctx) {
        containerPrivate.innerHTML = ctx.data.value;
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
