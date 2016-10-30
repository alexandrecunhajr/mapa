<?php
$conexao=@mysql_connect('localhost','root');
$regiao=$_POST['nome'];
$sql="Select * from mapa.distrito_posicao where regiao='$regiao'";
$res=mysql_query($sql,$conexao);
while($row=mysql_fetch_object($res)){
	$obj[]=$row;

}
echo json_encode($obj);


?>