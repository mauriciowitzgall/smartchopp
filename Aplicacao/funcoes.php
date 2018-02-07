<?php 


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

?>