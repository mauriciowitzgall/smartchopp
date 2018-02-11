function valida_cpf(cpf) {
    cpf = cpf.replace("-", "");
    cpf = cpf.replace(".", ""); //NAO excluir
    cpf = cpf.replace(".", ""); //tem que ser duas vezes
    cpf = cpf.replace("_", "");
    //alert(cpf);
    if (cpf != "99999999999") {

        var numeros, digitos, soma, i, resultado, digitos_iguais;
        digitos_iguais = 1;
        if (cpf.length < 11) {
            $("input[name=cpf]").val("");
            return false;
        }
        //alert(cpf.length);
        for (i = 0; i < cpf.length - 1; i++)
            if (cpf.charAt(i) != cpf.charAt(i + 1))
            {
                digitos_iguais = 0;
                break;
            }
        if (!digitos_iguais)
        {
            numeros = cpf.substring(0, 9);
            digitos = cpf.substring(9);
            soma = 0;
            for (i = 10; i > 1; i--)
                soma += numeros.charAt(10 - i) * i;
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(0)) {
                alert('O CPF digitado não é válido! Digite novamente');
                $("select[name=metodo]").html("<option>Selecione</option>");
                $("input[name=cpf]").val("");
                $("input[name=cpf]").focus();
                $("tr[id=tr_email]").hide();
                $("input[name=email]").attr("required", false);
                $("input[name=resposta]").attr("required", false);
                $("tr[id=tr_pergunta]").hide();
                $("tr[id=tr_resposta]").hide();
                return false;
            }
            numeros = cpf.substring(0, 10);
            soma = 0;
            for (i = 11; i > 1; i--)
                soma += numeros.charAt(11 - i) * i;
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(1)) {
                alert('O CPF digitado não é válido! Digite novamente');
                $("select[name=metodo]").html("<option>Selecione</option>");
                $("input[name=cpf]").val("");
                $("input[name=cpf]").focus();
                $("tr[id=tr_email]").hide();
                $("input[name=email]").attr("required", false);
                $("input[name=resposta]").attr("required", false);
                $("tr[id=tr_pergunta]").hide();
                $("tr[id=tr_resposta]").hide();
                return false;
            }
            //alert('CPF Verdadeiro');
            return true;
        }
        else {
            var s = "O CPF digitado não é válido! Digite novamente";
            alert(s);
            $("select[name=metodo]").html("<option>Selecione</option>");
            $("input[name=email]").attr("required", false);
            $("input[name=resposta]").attr("required", false);
            $("tr[id=tr_email]").hide();
            $("tr[id=tr_pergunta]").hide();
            $("input[name=cpf]").val("");
            $("input[name=cpf]").focus();
            return false;
        }
    }
}
function valida_cnpj(cnpj) {
    cnpj = cnpj.replace(/[^\d]+/g, '');

    if (cnpj == '')
        return false;

    if (cnpj.length != 14)
        return false;

    // Elimina CNPJs invalidos conhecidos
    if (cnpj == "00000000000000" ||
        cnpj == "11111111111111" ||
        cnpj == "22222222222222" ||
        cnpj == "33333333333333" ||
        cnpj == "44444444444444" ||
        cnpj == "55555555555555" ||
        cnpj == "66666666666666" ||
        cnpj == "77777777777777" ||
        cnpj == "88888888888888" ||
        cnpj == "99999999999999") {

        alert("CNPJ Inválido");
        $("input[name=cnpj]").val("");
        $("input[name=cnpj]").focus();
        return false;
    }

    // Valida DVs
    tamanho = cnpj.length - 2
    numeros = cnpj.substring(0, tamanho);
    digitos = cnpj.substring(tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(0)) {
        alert("CNPJ Inválido");
        $("input[name=cnpj]").val("");
        $("input[name=cnpj]").focus();
        return false;
    }

    tamanho = tamanho + 1;
    numeros = cnpj.substring(0, tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(1)) {
        alert("CNPJ Inválido");
        $("input[name=cnpj]").val("");
        $("input[name=cnpj]").focus();
        return false;

    }
    return true;

//alert("CNPJ Valido!");

}


Number.prototype.number_format = function(c, d, t){
var n = this, 
    c = isNaN(c = Math.abs(c)) ? 2 : c, 
    d = d == undefined ? "." : d, 
    t = t == undefined ? "," : t, 
    s = n < 0 ? "-" : "", 
    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))), 
    j = (j = i.length) > 3 ? j % 3 : 0;
   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
 };

