<table id="listCompetitions">
<thead>
	<th>Numéro</th>
	<th>Nom</th>
	<th>Description</th>
	<th>Date de départ</th>
	<th>Date de fin</th>
	<th>Prix</th>
	<th>Nombre de participants</th>
	<th>Nom du gagnant</th>
	<th>Statut</th>
</thead>
<tbody>
	<?php 
	foreach ($listCompetitions as $key => $competition) {
		echo "<tr data-toggle='modal' data-target='#Modal'>";
			echo "<td name='id_competition' >".$competition->getId_competition()."</td>";
			echo "<td name='name' >".$competition->getName()."</td>";
			echo "<td name='description' >".$competition->getDescription()."</td>";
			echo "<td name='start_date' >".date('d/m/Y',strtotime($competition->getStart_date()))."</td>";
			echo "<td name='end_date' >".date('d/m/Y',strtotime($competition->getEnd_date()))."</td>";
			echo "<td name='prize' >".$competition->getPrize()."</td>";
			echo "<td name='totalParticipants' >".$competition->getTotalParticipants()."</td>";
			echo "<td name='id_winner' >".$competition->getId_winner()."</td>";
			echo "<td name='active'>";
				echo ($competition->getActive()==1) ? "Actif" : "";
			echo "</td>";
		echo "</tr>";
	}
	?>
</tbody>
</table>

<!-- Modal -->
<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modifier un concours</h4>
      </div>
      <div class="modal-body">
        <form id="data_competition">
        	<input type="hidden" name="id_competition">
	        <input type="text" name="name">
	        <input type="text" name="description">
	        <input type="date" name="start_date">
	        <input type="date" name="end_date">
	        <input type="text" name="prize">
	        <input type="number" name="totalParticipants">
	        <input type="number" name="id_winner">
	        <input type="checkbox" name="active">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="submit" class="btn btn-primary">Modifier le concours</button>
      </div>
    </div>
  </div>
</div>


<button type="button"  data-toggle="modal" data-target='#CreateCompetition'>Créer un concours</button>
<!-- Modal -->
<div class="modal fade" id="CreateCompetition" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Création un concours</h4>
      </div>
      <div class="modal-body">
        <form id="create_data_competition">
	        <input type="text" name="name" placeholder="Nom">
	        <input type="text" name="description" placeholder="Description">
	        <input type="date" name="start_date" placeholder="Début">
	        <input type="date" name="end_date" placeholder="Fin">
	        <input type="text" name="prize" placeholder="Prix">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="submit" class="btn btn-primary">Enregistrer le concours</button>
      </div>
    </div>
  </div>
</div>

