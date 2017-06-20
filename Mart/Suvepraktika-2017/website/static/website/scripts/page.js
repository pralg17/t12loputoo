    jQuery(document).ready(function ($) {
        $(".clickable-row3").each(function () {
            $(this).click(function () {

                $(this).css('background-color', 'pink');
            });
        });

    });


    window.onload = function () {
        var fileInput = document.getElementById('fileInput');
        var fileDisplayArea = document.getElementById('id_text');

        fileInput.addEventListener('change', function (e) {
            var file = fileInput.files[0];
            var textType = /text.*/;

            if (file.type.match(textType)) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    fileDisplayArea.innerText = reader.result;
                };

                reader.readAsText(file, "windows-1257")
            } else {
                fileDisplayArea.innerText = "Faili tüüp ei ole toetatud!";
            }
        });
    };


    function clicked(e) {
        var value = $(e).attr('id');
        console.log(value);
        lemmaTabel.search(value).draw();
        $(e).css('background-color', 'pink');
    }

    function clicked2(e) {
        var value = $(e).attr('id');
        console.log(value);
        itallTable.search(value).draw();
        $(e).css('background-color', 'pink');
    }

    function clicked3(e) {
        $(e).css('background-color', 'pink');
    }

    $(document).ready(function () {
        $('.btn-success').tooltip({
            title: "Kui valisite N grami kõrgema kui 2 siis maatriksi kuvamisel võib browser kokku joosta. Vaikimisi ei kuvata maatriksi",
            animation: true
        });

        $('.clickable-row').tooltip({title: "Otsi lemmat", animation: true});
        $('.clickable-row2').tooltip({title: "Otsi vormi", animation: true});

    });
