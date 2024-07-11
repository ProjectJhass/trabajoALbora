function getRandomColor() {
    const red = Math.floor(Math.random() * 141) + 100;
    const green = Math.floor(Math.random() * 141) + 100;
    const blue = Math.floor(Math.random() * 141) + 100;
    return '#' + red.toString(16).padStart(2, '0') + green.toString(16).padStart(2, '0') + blue.toString(16)
        .padStart(2, '0');
}
function loadCausalesGraph() {
    const container = document.getElementById('myPieChart');
    if(!container){
        return;
    }
    const incomingData = JSON.parse(document.getElementById('myPieChart').dataset.data);
    const objetoOrdenadoDescendente = Object.fromEntries(Object.entries(incomingData).sort((a, b) => b[1] - a[1]));

    const labels = [];
    const portions = [];
    const colors = [];

    for (const [key, value] of Object.entries(objetoOrdenadoDescendente)) {
        labels.push(key);
        portions.push(value);
    }

    colors.push(...Array.from({
        length: labels.length
    }, getRandomColor));

    const data = {
        labels: labels,
        datasets: [{
            label: 'My Dataset',
            data: portions,
            backgroundColor: colors,
            borderColor: 'rgba(255, 255, 255, 0.5)'
        }]
    };

    const options = {
        responsive: false,
        maintainAspectRatio: true,
        legend: {
            display: false,
        },
        title: {
            display: true,
            text: 'causales por orden de servicio'
        },
    };


    const ctx = document.getElementById('myPieChart').getContext('2d');

    const myPieChart = new Chart(ctx, {
        type: 'pie',
        data: data,
        options: options
    });



    const legend = document.getElementById('legend');

    data.labels.forEach((label, index) => {
        console.log(data);
        const quantity = data.datasets[0].data[index];
        const color = data.datasets[0].backgroundColor[index];
        const legendItem = `
    <div class="legend-item"  width: 100%;>
      <button onclick="mostrarProductos(this)" data-bs-toggle="tooltip" data-bs-offset="0,4"
            data-bs-placement="top" data-bs-html="true"  class="legend-color" style="background-color: ${color};">
      <div class="ledend-quantity text-white  text-shadow-top" >${quantity}</div>
      </button>
      <div class="legend-text" >${label}</div>
    </div>
  `;
        legend.innerHTML += legendItem;
    });
}
mostrarProductos = (element) => {
    const causalidad = $(element).closest('.legend-item').find('.legend-text').text();
    $('#ModalDetalleCausalidad').modal('show')
    buscarArticulos(causalidad);
}
