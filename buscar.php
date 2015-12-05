<?php

        require_once 'phpfunc.php';
        $condb=conector_bbdd();

?>
<!DOCTYPE HTML>
<HTML>

<HEAD>
	<TITLE>Control de Stocks - Busqueda de Articulos</TITLE>
	<LINK rel='stylesheet' href='./styles.css' />
</HEAD>

<BODY>
<DIV id=main>
  <?php
    if($_GET['q']==''){
      echo "No se realiz&oacute; ninguna b&uacute;squeda";
    } else {
      $valor_buscado=$_GET['q'];
  ?>
  <a href='index.php'>[p&aacute;gina de inicio]</a>
  <h1>Busqueda de Articulos:</h1>
  <?php
    $consulta="SELECT ID,TIPO,NOMBRE,CANTIDAD,RESTO_CONSUMO,UNIDAD,UBICACION,FEC_INSERT,VENCIMIENTO
               FROM STOCK WHERE
               TIPO LIKE CONCAT('%',UPPER(?),'%')
               OR NOMBRE LIKE CONCAT('%',UPPER(?),'%')
               ORDER BY VENCIMIENTO ASC";

    $select=$condb->prepare($consulta);
    $select->bind_param('ss',$valor_buscado,$valor_buscado);

    if(!$select->execute()){
      die("Error buscando: ".$condb->error);
    }

    /* se reciben los resultados en variables */
    $select->bind_result($id,            $tipo,      $nombre,     $cantidad,
                         $resto_consumo, $unidad,    $ubicacion,  $fec_insert, $vencimiento);
    /* store_result es necesario para poder   */
    /* ver el número correcto de filas con    */
    /* $select->num_rows                      */
    $select->store_result();

    if($select->num_rows > 0) {
    ?>
    <p>Se listan items conteniendo '<?=$valor_buscado?>' ordenados por vencimiento 
     <i>(m&aacute;s pr&oacute;ximos a vencer primero)</i>
    </p>

    <TABLE>
      <TR>
        <!-- El primero está para dejar vacía la esquina arriba-izquierda -->
        <TH style='visibility:hidden'></TH>
        <TH>ARTICULO</TH>
        <TH>STOCK INICIAL</TH>
        <TH>STOCK ACTUAL</TH>
        <TH>UBICACION</TH>
        <TH>INGRESO</TH>
        <TH>VENCE</TH>
      </TR>
    <?php
      while($select->fetch()){
    ?>
      <TR>
        <TD><a href='edit.php?id=<?=$id?>'>&raquo;</a></TD>
        <TD><B><?=$tipo?> <?=$nombre?></B></TD>
        <TD><?=$cantidad?> <?=$unidad?></TD>
        <TD><?=$resto_consumo?> <?=$unidad?></TD>
        <TD><?=$ubicacion?></TD>
        <TD><?=$fec_insert?></TD>
        <TD><?=$vencimiento?></TD>
      </TR>
    <?php
      }
    ?>
    </TABLE>
    <?php
    } else {
    ?>
    <p>No se encuentran resultados para '<?=$valor_buscado?>'</p>
    <?php
    }

  ?>

  <?php
    }//solo se busca si hay parametro
  ?>

</DIV>
</BODY>

</HTML>

