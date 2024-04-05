// new DataTable('#example');
new DataTable('#example', {
    language: {
        info: 'Mostrar página _PAGE_ de _PAGES_',
        infoEmpty: 'No hay registros disponibles',
        infoFiltered: '(filtrado de _MAX_ registros totales)',
        lengthMenu: 'Mostrar _MENU_ registros por página',
        zeroRecords: 'No se encontró nada - Lo siento',
        search: 'Buscar:',
        paginate: {
            next:'Siguiente',
            previous:'Anterior'
        }
    },
    order: [],
    // columns: [
    //     null,
    //     { orderSequence: ['desc', 'asc', ''] },
    //     { orderSequence: ['desc', 'asc', ''] },
    //     { orderSequence: null },
    //     { orderSequence: null }

    // ]
});