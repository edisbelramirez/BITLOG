<?php 

if(isset($_GET["opt"]) && $_GET["opt"]=="all"):?>
<section class="container">
<div class="row">
  <div class="col-lg-12">
		<h1>Usuarios con más de un mes sin loguearse</h1>
	<a href="index.php?view=dias&opt=new" class="btn btn-primary"><i class='fa fa-asterisk'></i> Nuevo</a>
<br><br>
		<?php
		$users = DiaData::getAll();
		if(count($users)>0){
			?>
			<div class="card"> 
      <table class="table table-bordered datatable table-hover" >
			<thead>
      <th></th>
			<th>Usuario</th>
			<th>Unidad Organizativa</th>
      <th>Duración</th>
      <th>Creación</th>
			<th></th>
			</thead>
			<?php
			foreach($users as $user){
				?>
				<tr>
          
        <td><a href="index.php?view=dias&opt=view&id=<?php echo $user->id; ?>" class="btn btn-primary btn-xs"><i class='fa fa-sitemap'></i> Ver historial</a></td>
				<td><?php echo $user->name; ?></td>
				<td><?php echo $user->description; ?></td>
        <td><?php echo $user->duration; ?></td>
        <td><?php echo $user->created_at; ?></td>
				<td><a href="index.php?view=dias&opt=edit&id=<?php echo $user->id;?>" class="btn btn-warning btn-xs">Editar</a><br><br><a href="index.php?action=dias&opt=del&id=<?php echo $user->id;?>" class="btn btn-danger btn-xs">Eliminar</a></td>
				
				</td>
				</tr>
				<?php

			}
 echo "</table></div>";

		}else{
			?>
			<p class="alert alert-warning">No hay Diagramas.</p>
			<?php
		}

		?>

	</div>
</div>
</section>
<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="new"):?>
<section class="container">
<div class="row">
	<div class="col-md-12">
	<h1>Agregar usuario</h1>
	<br>
<form class="form-horizontal" method="post" id="addproduct" action="index.php?action=dias&opt=add" role="form">
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Usuario*</label>
    <div class="col-md-6">
      <input type="text" name="name" class="form-control" id="name" placeholder="nombre.apellido">
    </div>
  </div>
 
  <div class="mb-3">
    <label for="description" class="form-label">Total de dias</label>
    <div class="col-md-6">
    <select class="form-select" id="description" name="description" aria-label="Default select example">
  <option value="STAFF">STAFF</option>
  <option value="Comercial">Comercial</option>
  <option value="Economia">Economia</option>
  <option value="Tecnologia de la informacion">Tecnologia de la informacion</option>
</select>
</div>
</div>

  <div class="mb-3">
    <label for="duration" class="form-label">Total de dias</label>
    <div class="col-md-6">
    <select class="form-select" id="duration" name="duration" aria-label="Default select example">
  <option value="30">30 dias</option>
</select>
</div>
</div>

  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
      <button type="submit" class="btn btn-primary">Agregar</button>
    </div>
  </div>
</form>
	</div>
</div>
</section>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="edit"):?>
<div class="container">
<?php $user = DiaData::getById($_GET["id"]);?>
<div class="row">
	<div class="col-md-12">
	<h1>Editar Diagrama</h1>
	<br>
		<form class="form-horizontal" method="post" id="addproduct" action="index.php?action=dias&opt=upd" role="form">


  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>
    <div class="col-md-6">
      <input type="text" name="name" value="<?php echo $user->name;?>" class="form-control" id="name" placeholder="Nombre">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Descripcion*</label>
    <div class="col-md-6">
      <textarea name="description" value="<?php echo $user->description;?>" required class="form-control" id="description" placeholder="Descripcion"><?php echo $user->description; ?></textarea>
    </div>
  </div>

  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Duracion*</label>
    <div class="col-md-6">
      <input type="text" name="duration" value="<?php echo $user->duration;?>" class="form-control" id="duration" placeholder="Duracion">
    </div>
  </div>



  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
    <input type="hidden" name="user_id" value="<?php echo $user->id;?>">
      <button type="submit" class="btn btn-primary">Actualizar Diagrama</button>
    </div>
  </div>
</form>
	</div>
</div>
</div>
<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="view"):
$dia = DiaData::getById($_GET["id"]);
  ?>

<section class="container">
<div class="row">
  <div class="col-lg-12">
    <h1><?php echo $dia->name; ?><small> Ver historial</small> </h1>
  <a href="index.php?view=items&opt=new&dia_id=<?php echo $dia->id; ?>" class="btn btn-primary"><i class='fa fa-asterisk'></i> Nuevo reporte</a>
<br><br>
    <?php
    $users = ItemData::getAllByDia($dia->id);
    if(count($users)>0){
      ?>
      <div class="card">
        <div class="card-body">
        <div style="overflow-x: scroll; ">
      <table class="table table-bordered datatable table-hover" style="width: auto; " >
      <thead>
      <th>Mes </th>
      <?php for($i=1; $i<=$dia->duration; $i++):?>
      <th><?php echo $i;?></th>
    <?php endfor; ?>
      </thead>
      <?php
      foreach($users as $user){
        ?>
        <tr>
          
  <a href="index.php?view=items&opt=edit&id=<?php echo $user->id; ?>" class="btn btn-warning btn-xs"><i class='bi bi-pencil'></i>Editar</a>
  <a href="index.php?action=items&opt=del&id=<?php echo $user->id; ?>" class="btn btn-danger btn-xs"><i class='bi bi-trash'></i>Eliminar</a>

          </td>
        <td style=""><?php echo substr($user->title, 0, 8);; ?></td>

      <?php for($i=1; $i<=$dia->duration; $i++):?>
        <td style="width:5px; <?php if($user->start<=$i && $user->finish >=$i){ echo "background: $user->color; "; }?>">
        </td>
    <?php endfor; ?>
        </tr>
        <?php

      }
 echo "</table></div></div>";

    }else{
      ?>
      <p class="alert alert-warning">No hay historial.</p>
      <?php
    }

    ?>

  </div>
</div>
</section>
<?php endif; ?>