module.exports = {
    apps: [{
            name: "AS1",
            script: "./que.js",
            cron: "*/15 * * * *",
            args: "-s 1"
        }, {
            name: "AS2",
            script: "./que.js",
            cron: "*/15 * * * *",
            args: "-s 2"
        },
        {
            name: "AS3",
            script: "./que.js",
            cron: "*/15 * * * *",
            args: "-s 3"
        },
        {
            name: "AS4",
            script: "./que.js",
            cron: "*/15 * * * *",
            args: "-s 4"
        },
        {
            name: "AS5",
            script: "./que.js",
            cron: "*/15 * * * *",
            args: "-s 5"
        },
        {
            name: "CALLBACK_WA",
            script: "./script/callbackAPIWA.js",
            cron: "*/15 * * * *",
            args: "-p 5500"
        }
    ]
}