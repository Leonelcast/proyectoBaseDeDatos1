<table>
<thead>
</thead>
<tr>
<th>Id </th>
<th>Descripcion</th>
<th>Fotografia</th>
<th>Precio</th>
</tr>

<?php
include("../Config/config.php");
if(isset($_POST['buscar'])){
    $Ingrediente = $_POST['Ingrediente'];
    $query = "SELECT Ingrediente, Descripcion, precio  from platillos inner join platillosingredientes 
    on platillos.IdPlatillos = platillosingredientes.IdPlatillo INNER JOIN ingredientes on platillosingredientes.IdIngrediente = ingredientes.IdIngrediente;
    WHERE Ingrediente = '$Ingrediente'";
    $resultado = mysqli_query($link, $query );
    if(!$resultado){
        die("QUERY FAILED ");
    }
    while ($row = mysqli_fetch_array($resultado)){
        ?>
<tbody>
<tr>
<td><?php echo $row['Ingrediente']?></td>
<td><?php echo $row['Descripcion']?></td>
<td><?php echo $row['precio']?></td>




</tr>
</tbody>
</table>
<?php
    }?>
<?php
    }?>