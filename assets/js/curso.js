$(document).ready(function () {


    //Remove Disciplina da estrutura do array
    $('.remove').click(function (e) {
        e.preventDefault();

        var key = $(this).attr('data-key');

        $('.disciplina-' + key).remove();

    });

    //Adiciona novos campos para disciplina


    $('.adicionar').click(function (e) {
        e.preventDefault();

        var key = parseInt($("[name*='key_disciplina']").val());

        $("[name*='key_disciplina']").val(key += 1);

        $('.disciplinas').append("" +
            "<div class=\"disciplina-" + key + "\">" +
            "<h3>Informações do disciplina</h3>" +
            "<button data-key=\"" + key + "\" class=\"btn btn-danger remove\">Remove</button>" +
            "<div class=\"form-group\">\n" +
            "            <label>Nome disciplina:</label>\n" +
            "            <input name=\"disciplinas[" + key + "][nome]\" class=\"form-control\"/>\n" +
            "        </div>" +
            "<div class=\"form-group\">\n" +
            "            <label>Código:</label>\n" +
            "            <input name=\"disciplinas[" + key + "][codigo]\" class=\"form-control\"/>\n" +
            "        </div>" +
            "<div class=\"form-group\">\n" +
            "            <label>Objetivos:</label>\n" +
            "            <textarea name=\"disciplinas[" + key + "][objetivos]\"\n" +
            "                      class=\"form-control\"></textarea>\n" +
            "        </div>" +
            "<div class=\"form-group\">\n" +
            "            <label>Programa:</label>\n" +
            "            <textarea name=\"disciplinas[" + key + "][programa]\" class=\"form-control\"></textarea>\n" +
            "        </div>" +
            "</div>");

    })


});