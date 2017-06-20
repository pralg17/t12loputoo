var language = {
    "sProcessing": "Palun oodake, koostan kuvamiseks nimekirja!",
    "sLengthMenu": "N&auml;ita kirjeid _MENU_ kaupa",
    "sZeroRecords": "Otsitavat vastet ei leitud.",
    "sInfo": "Kuvatud: _TOTAL_ kirjet (_START_-_END_)",
    "sInfoEmpty": "Otsinguvasteid ei leitud",
    "sInfoFiltered": " - filteeritud _MAX_ kirje seast.",
    "sInfoPostFix": "K&otilde;ik kuvatud kirjed p&otilde;hinevad reaalsetel tulemustel.",
    "sSearch": "Otsi k&otilde;ikide tulemuste seast:",
    "oPaginate": {
        "sFirst": "Algus",
        "sPrevious": "Eelmine",
        "sNext": "J&auml;rgmine",
        "sLast": "Viimane"
    }
};


var dataTableOptions = {
    dom: 'lBfrtip',
    buttons: ['print', 'csv', 'excel', 'pdf'],
    language: language,
    aLengthMenu: [25, 50, 100, 200, "All"]
};


var lemmaTabel = $('#myTable').DataTable(dataTableOptions);


var itallTable = $('#myTable4').DataTable(dataTableOptions);


var sequenceTable = $('#myTable2').DataTable(dataTableOptions);


var matrixTable = $('#myTable3').DataTable(dataTableOptions);