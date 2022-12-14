let tokens = [];
document.querySelectorAll("input.plc-name").forEach(plc => {
    fetch('https://192.168.1.104/api/jsonrpc', {
    method: 'POST',
    headers: {
        'Accept': '*/*',
        'Content-Type': 'application/json',
        'Connection': 'keep-alive'
    },
    body: JSON.stringify({
        "id": 0,
        "jsonrpc": "2.0",
        "method": "Api.Login",
        "params": {
        "user": "json",
        "password": "jsonpw"
    } })
})a
.then(response => response.json())
.then(response => tokens[plc.value] = response.result.token)
})

// setInterval(() => {
//     document.querySelectorAll("div.plc-data").forEach(variable => {
//         console.log(variable)
//         fetch('https://192.168.1.104/api/jsonrpc', {
//         method: 'POST',
//         headers: {
//             'Accept': '*/*',
//             'Content-Type': 'application/json',
//             'X-Auth-Token': tokens[variable.children[5].value]
//         },
//         body: JSON.stringify({
//             "id": 0,
//             "jsonrpc": "2.0",
//             "method": "PlcProgram.Read",
//             "params": {
//             "var": "\"GlDb\".Daten"
//         } })
//     })
//     .then(response => response.json())
//     .then(response => console.log(response))
//     })
// }, 100)

document.querySelectorAll("div.plc-data").forEach(variable => {
    console.log(variable)
})