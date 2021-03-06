<?php 



function converte_datahorabanco_para_datahoratela($data) {
    if ($data != "") {
        $texto = explode(" ", $data);
        $data1=$texto[0];
        $hora1=$texto[1];
        $textodata = explode ("-",$data1);
        return $textodata[2] . "/" . $textodata[1] . "/" . $textodata[0] . " " . "$hora1";
    }
    return $data;
}


function converte_datahorabanco_para_datahoratela2($data) {
    if ($data != "") {
        $texto = explode(" ", $data);
        $data1=$texto[0];
        $hora1=$texto[1];
        $hora = explode(":", $hora1);
        $hora = $hora[0].":".$hora[1];                  
        $textodata = explode ("-",$data1);
        return $textodata[2] . "/" . $textodata[1] . "/" . $textodata[0] . " " . "$hora";
    }
    return $data;
}


function converte_datahorabanco_para_datahoratela3($data) {
    $meses = array(
        1 => 'Janeiro',
        'Fevereiro',
        'Março',
        'Abril',
        'Maio',
        'Junho',
        'Julho',
        'Agosto',
        'Setembro',
        'Outubro',
        'Novembro',
        'Dezembro'
    );
    $meses2 = array(
        1 => 'Jan',
        'Fev',
        'Mar',
        'Abr',
        'Mai',
        'Jun',
        'Jul',
        'Ago',
        'Set',
        'Out',
        'Nov',
        'Dez'
    );    
    $dias_da_semana = array(
        'Domingo',
        'Segunda-Feira',
        'Terça-Feira',
        'Quarta-Feira',
        'Quinta-Feira',
        'Sexta-Feira',
        'Sábado'
    );    
    if ($data != "") {
        $texto = explode(" ", $data);
        $data1=$texto[0];
        $hora1=$texto[1];
        $hora = explode(":", $hora1);
        $hora = $hora[0].":".$hora[1];                  
        $textodata = explode ("-",$data1);
        return $textodata[2] . " " . $meses2[intval($textodata[1])] . " " . "$hora";
    }
    return $data;
}

//Converte datahora do formato Y-m-d H:m:s para d/m/Y H:m:s
function converte_datahora($data) {
    if ($data != "") {
        $texto = explode(" ", $data);
        $data1=$texto[0];
        $hora1=$texto[1];
        $textodata = explode ("-",$data1);
        return $textodata[2] . "/" . $textodata[1] . "/" . $textodata[0] . " " . "$hora1";
    }
    return $data;
}

//Converte datahora do formato Y-m-d H:m:s para d/m/Y
function converte_datahora2($data) {
    if ($data != "") {
        $texto = explode(" ", $data);
        $data1=$texto[0];
        $hora1=$texto[1];
        $textodata = explode ("-",$data1);
        return $textodata[2] . "/" . $textodata[1] . "/" . $textodata[0];
    }
    return $data;
}

//Converte datahora do formato Y-m-d H:m:s para H:m:s
function converte_datahora3($data) {
    if ($data != "") {
        $texto = explode(" ", $data);
        $data1=$texto[0];
        $hora1=$texto[1];
		//$hora = explode(":", $hora1);
		//$hora = $hora[0].":".$hora[1];                
        return "$hora1";
    }
    return $data;
}


function converte_datahora4($data) {
    if ($data != "") {
        $texto = explode(" ", $data);
        $data1=$texto[0];
        $hora1=$texto[1];
        $hora = explode(":", $hora1);
        $hora = $hora[0].":".$hora[1];          
        $textodata = explode ("-",$data1);
        return $textodata[2] . "/" . $textodata[1] . "/" . $textodata[0] . " " . "$hora";
    }
    return $data;
}


?>