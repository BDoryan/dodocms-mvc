// function loadScripts(scripts) {
//     for (let i = 0; i < scripts.length; i++) {
//         let script = document.createElement('script');
//         script.src = scripts[i];
//         script.type = 'text/javascript';
//         document.getElementsByTagName('head')[0].appendChild(script);
//     }
// }

async function start() {
    await DODOCMS_APPLICATION.load();
}
start().then(r => {
    DODOCMS_APPLICATION.run();
});