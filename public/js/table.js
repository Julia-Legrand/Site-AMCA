// Function to print validated users' table
function printTable() {
    let printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Liste des adhérents</title></head><body>');

    // Version specific for printing with a class for the "Modify" column
    let printableTable = document.getElementById('dataTable').cloneNode(true);
    let rows = printableTable.getElementsByTagName('tr');

    for (let i = 0; i < rows.length; i++) {
        let cells = rows[i].getElementsByTagName('td');
        if (cells.length > 0) { // Add a class to the last cell (Modify column)
            cells[cells.length - 1].classList.add('no-print');
        }
    }

    printWindow.document.write('<style>body { font-family: Arial, sans-serif; } .no-print { display: none; }');
    printWindow.document.write('table { font-size: small; border-collapse: collapse; width: 80%; }');
    printWindow.document.write('th { background-color: lightgrey; padding: 10px; }');
    printWindow.document.write('td { border-bottom: 1px solid grey; padding: 10px; text-align: center; }</style>');

    printWindow.document.write(printableTable.outerHTML);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}

// Function to display Datatables
$(document).ready(function () {
    $('#dataTable').DataTable({
        responsive: true,
        language: {
            "sSearch": "Chercher un adhérent :",
            "sLengthMenu": "Afficher _MENU_ adhérents",
            "sInfo": "Affichage des adhérents _START_ à _END_ sur _TOTAL_ adhérents",
            "sInfoEmpty": "Aucun adhérent à afficher",
            "sInfoFiltered": "(filtré de _MAX_ adhérents au total)",
            "sZeroRecords": "Aucun adhérent trouvé",
            "oPaginate": {
                "sPrevious": "Précédent",
                "sNext": "Suivant"
            },
        },
        pagingType: "simple",
        lengthMenu: [
            10,
            20,
            40,
            60,
            80,
            100
        ],
        pageLength: 10,
        "dom": '<"table-info"lf>tip',
        "ordering": false
    });
});