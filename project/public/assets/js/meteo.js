const url = 'https://api.open-meteo.com/v1/forecast?latitude=48.8567&longitude=2.3510&hourly=temperature_2m';

async function getMeteo(url) {
    try {
        const response = await fetch(url);
        let data = await response.json();
        return data;
    } catch (error) {
        console.log(error);
    }
}

async function renderMeteo() {
    let meteo = await getMeteo(url);

    // Get date
    let d = new Date();
    // Convert date
    let datestring = d.getFullYear() + "-" + (
        d.getMonth() + 1
    ) + "-" + d.getDate() + "T" + d.getHours() + ":00";


    // Get array time
    let time = meteo.hourly.time;
    // Get index
    let indexOfTime = time.indexOf(datestring);
    // Get current temperature
    let temperature = meteo.hourly.temperature_2m[indexOfTime];

    let html = '';

    let htmlSegment = `
                        <div class="card mt-5">
                            <div class="card-body">
                            <h5 class="card-title">The outside temperature is : </h5>
                            <h3 class="card-title">${temperature}°C</h3>
                            </div>
                      </div>`;

    html += htmlSegment;


    let container = document.querySelector('.row');
    container.innerHTML = html;
}

renderMeteo();