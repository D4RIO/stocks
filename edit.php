<?php
	require_once 'phpfunc.php';
	$con=conector_bbdd();

	/*MODO DE EDICION EFECTIVA*/
	if ($_GET["do_edit"]=="yes") {
		$edicion_txt="UPDATE STOCK SET
                      TIPO=?, NOMBRE=?, CANTIDAD=?,
                      UNIDAD=?, VENCIMIENTO=DATE(?), UBICACION=?
                      WHERE ID=?";

		$edicion=$con->prepare($edicion_txt);

		$edicion->bind_param('ssdsssi',$_GET['tipo'],   $_GET['nombre'],      $_GET['cantidad'],
		                               $_GET['unidad'], $_GET['vencimiento'], $_GET['ubicacion'],
		                               $_GET['id']);

		$edicion->execute();
		if($edicion->errno){
			die("No se pudo actualizar :(<br/>\n".$edicion->error);
		}
		else {
?>
<html>
<head>
        <title></title>
        <link rel='stylesheet' href='./styles.css' />
</head>
<body>
<div id=main>
  <a href='index.php'>[p&aacute;gina de inicio]</a>
  <h1>Edicion realizada con &eacute;xito</h1>
</div>
</body>
</html>
<?php
		}
		exit();
	}//if
?>
<!DOCTYPE HTML>
<html>
<head>
	<title></title>
	<link rel='stylesheet' href='./styles.css' />
</head>
<body>
<div id=main>
  <a href='index.php'>[p&aacute;gina de inicio]</a>
  <?php
  	if ($_GET["id"]=='') {
  		echo "<h1>Nada que editar</h1>";
  	}//if
	else {
		$id_get=$_GET["id"];
		$consulta="SELECT ID,TIPO,NOMBRE,CANTIDAD,UNIDAD,VENCIMIENTO,UBICACION
		           FROM STOCK
		           WHERE ID=?";
		$select=$con->prepare($consulta);
		$select->bind_param('i',$id_get);

		/* se ejecuta la consulta */
		if (!$select->execute()){
			die("Error obteniendo los datos originales: ".$con->error);
		}//if

		/* se reciben los resultados en variables */
		$select->bind_result($id,       $tipo,   $nombre,
                                     $cantidad, $unidad, $vencimiento,
                                     $ubicacion);
		/* store_result es necesario para poder   */
		/* ver el número correcto de filas con    */
		/* $select->num_rows                      */
		$select->store_result();

		if ($select->num_rows==0) {
			echo "<h1>Nada que editar</h1>";
		}//if
		else {
			$select->fetch();
  ?>
  <!-- Este formulario vuelve a este mismo script php solicitando la -->
  <!-- edicion con los datos que se incluyan en él.                  -->
  <!-- La variable GET do_edit solicita el modo de acceso a la BBDD  -->
  <form action=edit.php method=get >
    <input type=hidden value='<?=$id?>' name=id />
    <input type=hidden value='yes' name=do_edit />
    <table style='border:1px solid #555'>
      <caption>Editando Producto</caption>
      <tr>
        <td style='border:none'><span>tipo</span></td>
        <td style='border:none'>
          <input type=text id=tipo name=tipo value='<?=$tipo?>' size=50 /></td>
      </tr>
      <tr>
        <td style='border:none'><span>nombre</span></td>
        <td style='border:none'><input type=text id=nombre name=nombre value='<?=$nombre?>' size=50 /></td>
      </tr>
      <tr>
        <td style='border:none'><span>vencimiento</span></td>
        <td style='border:none'><input type=text id=vencimiento name=vencimiento value='<?=$vencimiento?>' size=10 /></td>
      </tr>
      <tr>
        <td style='border:none'><span>ubicacion</span></td>
        <td style='border:none'><input type=text   id=ubicacion name=ubicacion value='<?=$ubicacion?>' size=30 /></td>
      </tr>
      <tr>
        <td style='border:none'><span>cantidad</span></td>
        <td style='border:none'><input type=number id=cantidad name=cantidad value='<?=$cantidad?>' size=6 /></td>
      </tr>
      <tr>
        <td style='border:none'><span>unidad</span></td>
        <td style='border:none'><input type=text id=unidad name=unidad value='<?=$unidad?>' size=20 /></td>
      </tr>
      <tr>
        <td style='border:none' colspan=2><input type=submit /></td>
      </tr>
    </table>
  </form>
  <?php
		}//else
	}//else
  ?>
</div>
</body>
</html>
