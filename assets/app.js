import './bootstrap.js';
import 'bootstrap/dist/css/bootstrap.min.css';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

document.getElementById('random').addEventListener('click', async () => {
    document.getElementById('seed').value = Math.floor(Math.random() * 1000);
    let parameters = getParameters();
    console.log();
    let request = await fetch("{{ path('app_index') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(Array.from(parameters.entries()))
    });
});

document.getElementById('seed').addEventListener('input', async () => {
    console.log('Change seed');

    let request = await fetch("{{ path('app_index') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },

    });
});

document.getElementById('errors-slider').addEventListener('input', async () => {
    document.getElementById('errors-input').value = document.getElementById('errors-slider').value;
    console.log('Change error slider');
    let request = await fetch("{{ path('app_index') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },

    });
});

document.getElementById('errors-input').addEventListener('input', async () => {
    document.getElementById('errors-slider').value = document.getElementById('errors-input').value;
    console.log('Change error input');
    let request = await fetch("{{ path('app_index') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },

    });
});

document.getElementById('region').addEventListener('input', async () => {
    document.getElementById('errors-slider').value = document.getElementById('errors-input').value;
    console.log('Change region');
    let request = await fetch("{{ path('app_index') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },

    });
});

window.addEventListener("scrollend", async () => {
    let parameters = getParameters();
    console.log("Scroll End");
    let request = await fetch("{{ path('app_update') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(Array.from(parameters.entries()))
    });
});
function getParameters()
{
    let parameters = new Map();
    parameters.set('seed', document.getElementById('seed').value);
    parameters.set('region', document.getElementById('region').value);
    parameters.set('error', document.getElementById('errors-input').value);
    return parameters;
}

