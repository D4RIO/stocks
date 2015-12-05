<!DOCTYPE HTML>
<HTML>

	<HEAD>
		<TITLE>Control de Stocks</TITLE>
		<LINK rel='stylesheet' href='./styles.css' />
	</HEAD>

	<BODY>
	<DIV id=main>

<?php

	require_once 'phpfunc.php';
	$condb=conector_bbdd();

	/* primero vamos a verificar que no haya articulos
	 * vencidos o por vencer en menos de una semana, si
	 * los hubiera, necesitamos advertirlo
	 */
    $consulta="SELECT ID,TIPO,NOMBRE,RESTO_CONSUMO,UNIDAD,UBICACION,VENCIMIENTO, DATE_ADD(CURDATE(),INTERVAL 1 WEEK)
               FROM STOCK
			   WHERE VENCIMIENTO < DATE_ADD(CURDATE(),INTERVAL 1 WEEK)
			   AND RESTO_CONSUMO > 0
			   ORDER BY VENCIMIENTO ASC";

    $select_vencimientos=$condb->prepare($consulta);

    if(!$select_vencimientos->execute()){
      die("Error buscando: ".$condb->error);
    }

    /* se reciben los resultados en variables */
    $select_vencimientos->bind_result($id,     $tipo,      $nombre,     $cantidad,
                                      $unidad, $ubicacion, $vencimiento,$fec_limite);
    /* store_result es necesario para poder   */
    /* ver el número correcto de filas con    */
    /* $select->num_rows                      */
    $select_vencimientos->store_result();

    if($select_vencimientos->num_rows > 0){
?>
		<DIV class=warning>
			<p><b>Existen articulos vencidos o por vencer en 1 semana:</b></p>
			<table border=0 STYLE='margin-left:10px'>
<?php
			while($select_vencimientos->fetch()){
				?>
				<tr>
					<td><?=$tipo?></td>
					<td><?=$nombre?></td>
					<td><?=$cantidad?></td>
					<td><?=$unidad?></td>
					<td><?=$ubicacion?></td>
					<td><b><?=$vencimiento?></b></td>
				</tr>
				<?php
			}
?>
			</table>
		</DIV>
<?php
	}
?>
		<h1>BUSCAR EN DEPOSITO: </h1>
		<FORM method=get action="./buscar.php">
			<input type=text name=q>
			<input type=submit value='BUSCAR'>
		</FORM>
		<h1>DEPOSITO:</h1>
		<p>Click en cada ubicacion para ver el contenido</p>
		<UL>
<?php
    /* no es necesario usar parametros enlazados ni nada elaborado    */
    /* porque la consulta no incluye datos a los que el usuario pueda */
    /* acceder y solo hay una columna devuelta                        */
    $sqlquery="SELECT DISTINCT UBICACION FROM STOCK ORDER BY UBICACION ASC";

    if(!$result=$condb->query($sqlquery)){
      die("Error seleccionando las cajas: ".$condb->error);
    }

    while($row=$result->fetch_assoc()){
?>
		<LI>
		<a href='caja.php?ubicacion=<?=$row['UBICACION']?>'><?=$row['UBICACION']?></a>
		</LI>
<?php
    }
?>
		</UL>
	</DIV>
	</BODY>

</HTML>

