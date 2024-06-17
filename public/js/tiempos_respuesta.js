
document.addEventListener("DOMContentLoaded", function () {
    setupTable = () => {
        $('#tiempos_respuesta_st').DataTable({
            "oLanguage": {
                "sSearch": "Buscar:",
                "sInfo": "Mostrando de _START_ a _END_ de _TOTAL_ registros",
                "oPaginate": {
                    "sPrevious": "Volver",
                    "sNext": "Siguiente"
                },
                "sEmptyTable": "No se encontró ningun registro en la base de datos",
                "sZeroRecords": "No se encontraron resultados...",
                "sLengthMenu": "Mostrar _MENU_ registros"
            },
            "order": [
                [0, "asc"]
            ],
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": false,
        });
    }


    ul = document.getElementById("list");
    li = ul.getElementsByTagName('li');
    var primerElemento = ul.querySelector('li:first-child');
    primerElemento.classList.add('selected');
    for (let element of li) {
        element.addEventListener('click', () => {
            Array.from(document.querySelectorAll('.selected')).forEach(function (el) {
                el.classList.remove('selected');
            });
            odt = element.innerText
            element.classList.add('selected');
            buscarOrdenST(odt);
        })
    };

    sortList = () => {
        var lista = $('#list');
        var items = lista.children('li');
        var itemsArray = items.toArray();
        itemsArray.sort((a, b) => {
            a = parseInt(a.textContent);
            b = parseInt(b.textContent);
            if (a < b) return a - b // Ordenar de menor a mayor
            return b - a; // Ordenar de mayor a menor
        });
        lista.empty().append(itemsArray);
    }
    var sorting_icon = $('#sorting_icon');
    var isReversed = false;

    sorting_icon.on('click', function () {
        sortList();

        if (!isReversed) {
            sorting_icon.css('transform', 'scaleX(-1)');
            isReversed = true;
        } else {
            sorting_icon.css('transform', 'scaleX(1)');
            isReversed = false;
        }
    });
    $("#searchInput").on("input", function () {
        var searchText = $(this).val().toLowerCase();
        $("#list li").each(function () {
            var listItemText = $(this).text().toLowerCase();
            if (listItemText.indexOf(searchText) === -1) {
                $(this).hide();
            } else {
                $(this).show();
            }
        });
    });

    $('#searchInputGraph').on("input", function () {
        let input = $(this).val();
        setTimeout(() => {
            buscarGraficaODT(input);
        }, 300);
    })
});




loadGraph = () => {
    const steps = document.querySelectorAll('.steps');

    handlePopper = (button, tooltip) => {
        const popperInstance = Popper.createPopper(button, tooltip, {
            placement: 'top',
            modifiers: [{
                name: 'offset',
                options: {
                    offset: [0, 12],
                },
            },],
        });

        function show() {
            tooltip.setAttribute('data-show', '');

            // We need to tell Popper to update the tooltip position
            // after we show the tooltip, otherwise it will be incorrect
            popperInstance.update();
        }

        function hide() {
            tooltip.removeAttribute('data-show');
        }

        const showEvents = ['mouseenter', 'focus'];
        const hideEvents = ['mouseleave', 'blur'];

        showEvents.forEach((event) => {
            button.addEventListener(event, show);
        });

        hideEvents.forEach((event) => {
            button.addEventListener(event, hide);
        });
    }
    createTooltip = () => {
        const tooltipDiv = document.createElement('div');
        tooltipDiv.id = 'tooltip';
        tooltipDiv.setAttribute('role', 'tooltip');
        tooltipDiv.setAttribute('placement', 'top');

        // Crear el elemento div del arrow y agregarlo como hijo del tooltipDiv
        const arrowDiv = document.createElement('div');
        arrowDiv.id = 'arrow';
        arrowDiv.setAttribute('data-popper-arrow', '');
        tooltipDiv.appendChild(arrowDiv);

        // Agregar el tooltipDiv al DOM (por ejemplo, al cuerpo del documento)
        document.body.appendChild(tooltipDiv);
        return tooltipDiv;
    }
    createTooltipMessage = (tooltip, state, plazo, transcurrido, etapa) => {
        // Crear el contenedor principal del mensaje
        const container = document.createElement('div');
        container.classList.add('message-container');

        // Crear el título del mensaje
        const title = document.createElement('h2');
        // Crear el primer párrafo
        const paragraph1 = document.createElement('p');
        // Crear el segundo párrafo
        const paragraph2 = document.createElement('p');

        switch (state) {
            case 'good':
                title.textContent = '¡Excelente!';
                title.style.color = "#62bd30"
                paragraph1.textContent = `${etapa} realizada dentro del plazo establecido.`;
                paragraph2.textContent = `En ${transcurrido} de los ${plazo} días programados.`;
                break;
            case 'caution':
                title.textContent = '¡Precaución!';
                title.style.color = "#e8b009"
                paragraph1.textContent = `El tiempo requerido para esta orden es de 3 días.`;
                paragraph2.textContent = `Actualmente, se encuentra en el límite del plazo establecido, en el día ${transcurrido} de ${plazo}.`;
                break;
            case 'danger':
                title.textContent = '¡Peligro!';
                title.style.color = "#ff3e1d"
                paragraph1.textContent = `La orden ha excedido el tiempo requerido (${plazo} dias).`;
                paragraph2.textContent = `Con un retraso de ${transcurrido - plazo} dias.`;
                break;

            case 'warning':
                title.textContent = '¡Advertencia!';
                title.style.color = "#ed8b36"
                paragraph1.textContent = 'No hay información de esta OST.'
                paragraph2.textContent = 'Ante cualquier duda o inconveniente comunicarse con servicio técnico.'
                break;
            default:
                break;
        }


        // Agregar elementos al contenedor principal
        container.appendChild(title);
        container.appendChild(paragraph1);
        container.appendChild(paragraph2);

        // Agregar el contenedor al DOM (por ejemplo, al cuerpo del documento)
        tooltip.appendChild(container);

    }
    formatODT = (element, id_st) => {
        const odt = [];
        Array.from(element.childNodes).filter(node => node.nodeType === 1)
            .forEach((el, i) => {
                if (el.firstElementChild && el.firstElementChild.id) {
                    let dataHolder = el.firstElementChild.dataset;
                    if (dataHolder.id !== "" && dataHolder.stage !== "" && dataHolder.days !== "" && dataHolder.diff !== "") {
                        odt.push({
                            id_st: id_st,
                            id: parseInt(dataHolder.id),
                            etapa: dataHolder.stage,
                            dias: parseInt(dataHolder.days),
                            diferencia: parseInt(dataHolder.diff),
                        });
                    }
                } else {
                    // console.log("Do nothing.");
                }
            });
        return odt;
    };


    Array.from(steps).forEach(async (step) => {
        try {
            const child = step.previousElementSibling;
            const id_st = child.innerText;
            const odt = formatODT(step, id_st);
            const bar = document.getElementById(`bar_${id_st}`);
            const maxID = (odt.reduce((maxId, etapa) => Math.max(etapa.id, maxId), -Infinity));
            const progress = (maxID - 1) * 100 / (7 - 1);
            bar.setAttribute('value', progress);

            const btns = step.querySelectorAll('.step-item');
            btns.forEach((button, index) => {
                button = button.firstElementChild;
                if (index + 1 <= maxID) {
                    const etapa = odt.find(etapa => etapa.id === index + 1);
                    const tooltip = createTooltip();
                    if (etapa) {
                        const dias = parseInt(etapa.dias);
                        const transcurrido = etapa.diferencia;
                        const state = setState(button, dias, transcurrido);
                        createTooltipMessage(tooltip, state, dias, transcurrido, etapa.etapa);
                    } else {
                        // ALERTA -> La orden de servicio ya debió pasar por esta etapa y no hay registros.
                        warning = document.createElement('img');
                        warning.classList.add('warning_img');
                        warning.setAttribute("src", "./../../icons/alert-triangle.svg");
                        button.innerText = "";
                        button.style.border = "2px solid #a7a7ba";
                        button.classList.add('warn');
                        button.appendChild(warning);
                        createTooltipMessage(tooltip, "warning");
                    }
                    handlePopper(button, tooltip);

                } else {
                    // La orden de servicio aún no ha llegado a esta etapa.
                    setDefaultButtonStyle(button);
                }
            });
        } catch (error) {
            console.error("Error fetching step:", error);
        }
    });
}
function setState(button, dias, trasncurrido) {
    button.style.border = "2px solid #a7a7ba";
    button.style.color = "white";
    if (dias > trasncurrido || (trasncurrido === 1 && dias === 1)) {
        button.classList.add('good');
        return 'good';
    } else if (dias === trasncurrido) {
        button.classList.add('caution');
        return 'caution';
    } else {
        button.classList.add('danger');
        return 'danger';
    }
}

function setDefaultButtonStyle(button) {
    // Establece un estilo predeterminado para los botones que no coinciden con las etapas existentes
    // Por ejemplo, puedes establecer un fondo gris o algún otro estilo
    button.style.color = "#666666";
}





