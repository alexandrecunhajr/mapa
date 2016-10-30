<?php
$conexao=@mysql_connect('localhost','root');
$sql="Select desc_regiao,regiao,latitude,longitude from mapa.regiao_posicao";
$res=mysql_query($sql,$conexao);
while($row=mysql_fetch_object($res)){
	$obj[]=$row;

}
echo json_encode($obj);


?>