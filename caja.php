<?php

	require_once 'phpfunc.php';

	$condb=conector_bbdd();

	if($_GET["ubicacion"]==""){
		$ubicacion="SUELTO";
	} else {
		$ubicacion=$_GET["ubicacion"];
	}
?>
<!DOCTYPE HTML>
<HTML>

<HEAD>
	<TITLE>Control de Stocks - Contenido por Ubicacion</TITLE>
        <LINK rel="stylesheet" href='./styles.css'></STYLE>
</HEAD>

<BODY>
<DIV id=main>
  <a href='index.php'>[p&aacute;gina de inicio]</a>

  <?php
    $consulta="SELECT ID,TIPO,NOMBRE,CANTIDAD,UNIDAD,VENCIMIENTO
               FROM STOCK
               WHERE UBICACION=?
               ORDER BY VENCIMIENTO ASC";

    $select=$condb->prepare($consulta);
    $select->bind_param('s',$ubicacion);

    /* se ejecuta la consulta */
    if (!$select->execute()){
      die("Error buscando el contenido: ".$condb->error);
    }

    /* se reciben los resultados en variables */
    $select->bind_result($id, $tipo, $nombre, $cantidad, $unidad, $vencimiento);
    /* store_result es necesario para poder   */
    /* ver el número correcto de filas con    */
    /* $select->num_rows                      */
    $select->store_result();
  ?>

  <TABLE>                             
    <CAPTION>Contenido de Dep&oacute;sito - <?=$ubicacion?></CAPTION>
    <TR>
      <!-- El primero está para dejar vacía la esquina arriba-izquierda -->
      <TH style='visibility:hidden'></TH>
      <TH COLSPAN=2>ARTICULO</TH>
      <TH COLSPAN=2>CANTIDAD</TH>
      <TH>VENCE</TH>
    </TR>

    <?php
      while($select->fetch()){
    ?>
    <TR>
      <TD><a href='edit.php?id=<?=$id?>'>&raquo;</a></TD>
      <TD><B><?=$tipo?></B></TD>
      <TD><B><?=$nombre?></B></TD>
      <TD><?=$cantidad?></TD>  
      <TD><?=$unidad?></TD>
      <TD><?=$vencimiento?></TD>
    </TR>
    <?php
      }
    ?>
  </TABLE>

</DIV>
</BODY>

</HTML>

