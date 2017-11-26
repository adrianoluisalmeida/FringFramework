//Remove Disciplina da estrutura do array
function remover(key){
    $('.disciplina-' + key).remove();
};


$(document).ready(function () {


    //Adiciona novos campos para disciplina
    $('.adicionar').click(function (e) {
        e.preventDefault();

        var key = parseInt($("[name*='key_disciplina']").val());

        $("[name*='key_disciplina']").val(key += 1);

        $('.disciplinas').append("" +
            "<div class=\"disciplina-" + key + "\"><div class=\"x_panel\">" +
            "" +
            "<h3>Informações do disciplina</h3>" +
            "<a onclick=\"remover("+key+")\" data-key=\"" + key + "\" class=\"btn btn-danger remover\">Remove</a>" +
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
            "</div></div>");

    })


});