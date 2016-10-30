<?php
$conexao=@mysql_connect('localhost','root');
$regiao=$_POST['nome'];
$sql="Select loja,longitude,latitude from mapa.loja_posicao where cod_distrito='$regiao'";
$res=mysql_query($sql,$conexao);
while($row=mysql_fetch_object($res)){
	$obj[]=$row;

}
echo json_encode($obj);


?>