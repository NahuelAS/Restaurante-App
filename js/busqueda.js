    const inputFiltro = document.getElementById('filtro');
        const tablaBody = document.getElementById('tabla-body');

        inputFiltro.addEventListener('input', filtrarElementos);

        function filtrarElementos() {
            const filtro = inputFiltro.value.toLowerCase();
            const filas = tablaBody.getElementsByTagName('tr');

            for (let i = 0; i < filas.length; i++) {
                const fila = filas[i];
                const celdas = fila.getElementsByTagName('td');

                let coincide = false;

                for (let j = 0; j < celdas.length; j++) {
                    const texto = celdas[j].textContent.toLowerCase();
                    if (texto.includes(filtro)) {
                        coincide = true;
                        break;
                    }
                }

                if (coincide) {
                    fila.style.display = 'table-row';
                } else {
                    fila.style.display = 'none';
                }
            }
        }