<html>

<head>
    <title>Centrifugo quick start</title>
</head>

<body>
<h1>Пустой шаблонный проект DDD-Laravel!</h1>
<h2>Данные из публичного канала channel (имя только что запрошенного пользователя по адресу /user/id)</h2>
<div id="public">-</div>
<h2>Данные из пприватного канала channel.user.1 (имя только что запрошенного пользователя по адресу /user/1)</h2>
<div id="private">-</div>

<script src="https://unpkg.com/centrifuge@3.1.0/dist/centrifuge.js"></script>
<script type="text/javascript">
    const container = document.getElementById('public');
    const containerPrivate = document.getElementById('private');

    const authEndpoint = 'http://<?= request()->getHost() ?>/api/auth/1';
    const endpointCentrifugo = 'ws://<?= request()->getHost() ?>/connection/websocket';
    const subscribeTokenEndpoint = 'http://<?= request()->getHost() ?>/api/broadcasting/auth';


    fetch(authEndpoint)
        .then(response => response.json())
        .then(response => {
            const tokenUser = response.token_access;
            const tokenCentrifugo = response.token_centrifugo;

            const centrifuge = new Centrifuge(endpointCentrifugo, {
                token: tokenCentrifugo
            });

            centrifuge.on('connecting', function (ctx) {
                console.log(`connecting: ${ctx.code}, ${ctx.reason}`);
            }).on('connected', function (ctx) {
                console.log(`connected over ${ctx.transport}`);
            }).on('disconnected', function (ctx) {
                console.log(`disconnected: ${ctx.code}, ${ctx.reason}`);
            }).connect();

            const subPrivate = centrifuge.newSubscription("channel.user.1", {
                    getToken: function (ctx) {
                        return customGetToken(subscribeTokenEndpoint, ctx);
                    }
                }
            );

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

            const sub = centrifuge.newSubscription("channel", {
                    getToken: function (ctx) {
                        return customGetToken(subscribeTokenEndpoint, ctx);
                    }
                }
            );

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

            function customGetToken(endpoint, ctx) {
                return new Promise((resolve, reject) => {
                    fetch(endpoint, {
                        method: 'POST',
                        headers: new Headers({
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer ${tokenUser}`,
                        }),
                        body: JSON.stringify(ctx)
                    })
                        .then(res => {
                            if (!res.ok) {
                                throw new Error(`Unexpected status code ${res.status}`);
                            }
                            return res.json();
                        })
                        .then(data => {
                            resolve(data.token);
                        })
                        .catch(err => {
                            reject(err);
                        });
                });
            }
        })
</script>
</body>

</html>
