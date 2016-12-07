<div class="col-md-12">
	<div class="col-md-offset-1 col-md-10 col-offset-1">
		<h2 class="text-center text-uppercase">Liste des concours</h2>

		<table id="listCompetitions" class="table stripe order-column">
			<thead>
				<th>Numéro</th>
				<th>Nom</th>
				<th>Description</th>
				<th>Date de départ</th>
				<th>Date de fin</th>
				<th>Lot à gagner</th>
				<th>Url du lot</th>
				<th>Nombre de participants</th>
				<th>Nom du gagnant</th>
				<th>Statut</th>
				<th>Action</th>
			</thead>
			<tbody>
				<?php foreach ($listCompetitions as $key => $competition) { ?>
					<tr data-toggle='modal' data-target='#Modal' class="cursor">
						<td name='id_competition'> <?php echo $competition->getId_competition() ?> </td>
						<td name='name'> <?php echo $competition->getName() ?></td>
						<td name='description'> <?php echo $competition->getDescription() ?></td>
						<td name='start_date' > <?php echo date('d/m/Y',strtotime($competition->getStart_date())) ?></td>
						<td name='end_date' ><?php echo date('d/m/Y',strtotime($competition->getEnd_date())) ?></td>
						<td name='prize' > <?php echo $competition->getPrize() ?></td>
						<td name='url_prize' > <?php echo $competition->getUrl_prize() ?></td>
						<td name='totalParticipants' > <?php echo $competition->getTotalParticipants() ?></td>
						<td name='id_winner' ><?php echo $competition->getId_winner() ?></td>
						<td name='active'>
							<?php echo ($competition->getActive()==1) ? "Actif" : ""; ?>
						</td>
						<td name='action'> <?php echo ($competition->getActive()==1) ? "<button class='btn btn-danger'>Cloturer</button>" : ""; ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="col-md-offset-3 col-md-6 col-offset-3 btn-new-competition">
		<button type="button" data-toggle="modal" data-target="#CreateCompetition" class="col-md-12 btn btn-success">Créer un concours !</button>
	</div>
	<div class="col-md-offset-1 col-md-10 col-offset-1">
		<h2 class="text-center text-uppercase">Liste des photos signalées</h2>

		<table id="listReportedPhoto" class="table stripe order-column">
			<thead>
				<th>Nom de l'uploader</th>
				<th>Url de la photo</th>
				<th>Action</th>
			</thead>
			<tbody>
				<?php foreach ($listReportedPhoto as $key => $photo) { ?>
					<tr>
						<td name='nom_updlader'><?php echo $photo->getId_user() ?></td>
						<td name='url_photo'><a href="#" target="blank"><?php echo $photo->getUrl_photo() ?></a></td>
						<td name='action'> 
							<?php echo ($photo->getIs_locked()==0) ? "<button class='btn btn-success'>Vérouiller</button>" : "<button class='btn btn-danger'>Dévérouiller</button>" ?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>

		<!--      Modal      -->
		<!-- Modification -->
		<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">Modifier un concours</h4>
		      </div>
		      <div class="modal-body">
		        <form id="data_competition">
		        	<div class="form-group row">
		        		<label for="name" class="col-xs-3 col-form-label text-right">Intitulé</label>
		        		<div class="col-xs-9">
		        			<input type="text" name="name" class="form-control">
	        			</div>
		        	</div>
		        	<div class="form-group row">
		        		<label for="description" class="col-xs-3 col-form-label text-right">Description</label>
		        		<div class="col-xs-9">
		        			<textarea class="form-control" name="description" rows="3"></textarea>
	        			</div>
		        	</div>
		        	<div class="form-group row">
		        		<label for="start_date" class="col-xs-3 col-form-label text-right">Date de début</label>
		        		<div class="col-xs-9">
		        			<input type="text" name="start_date" class="form-control">
		        		</div>
		        	</div>
		        	<div class="form-group row">
		        		<label for="end_date" class="col-xs-3 col-form-label text-right">Date de fin</label>
		        		<div class="col-xs-9">
		        			<input type="text" name="end_date" class="form-control">
	        			</div>	
		        	</div>
		        	<div class="form-group row">
		        		<label for="prize" class="col-xs-3 col-form-label text-right">Lot à gagner</label>
		        		<div class="col-xs-9">
		        			<input type="text" name="prize" class="form-control">
		        		</div>
		        	</div>
		        	<div class="form-group row">
		        		<label for="prize" class="col-xs-3 col-form-label text-right">Url du lot</label>
		        		<div class="col-xs-9">
		        			<input type="text" name="url_prize" class="form-control">
		        		</div>
		        	</div>
		        	<div class="form-group row">
		        		<label for="totalParticipants" class="col-xs-3 col-form-label text-right">Nombre de participants</label>
		        		<div class="col-xs-9">
		        			<input type="text" name="totalParticipants" class="form-control" disabled>
	        			</div>
		        	</div>
		        	<div class="form-check row">
					    <label class="col-xs-3 form-check-label text-right">Actif</label>
						    <div class="col-xs-9">
						      	<input type="checkbox" name="active" class="form-check-input">
					      	</div>
					    </label>
					 </div>
		        </form>
		      </div>
		      <div class="modal-footer">
		        <button type="button" id="submit" class="btn btn-primary">Modifier le concours</button>
		      </div>
		    </div>
		  </div>
		</div>


		<!--  Création -->
		<div class="modal fade" id="CreateCompetition" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">Création un concours</h4>
		      </div>
		      <div class="modal-body">
		        <form id="create_data_competition">
		        	<div class="form-group row">
		        		<label for="name" class="col-xs-3 col-form-label text-right">Intitulé</label>
		        		<div class="col-xs-9">
		        			<input type="text" name="name" class="form-control">
	        			</div>
		        	</div>
		        	<div class="form-group row">
		        		<label for="description" class="col-xs-3 col-form-label text-right">Description</label>
		        		<div class="col-xs-9">
		        			<textarea class="form-control" name="description" rows="3"></textarea>
	        			</div>
		        	</div>
		        	<div class="form-group row">
		        		<label for="start_date" class="col-xs-3 col-form-label text-right">Date de début</label>
		        		<div class="col-xs-9">
		        			<input type="text" name="start_date" class="form-control">
		        		</div>
		        	</div>
		        	<div class="form-group row">
		        		<label for="end_date" class="col-xs-3 col-form-label text-right">Date de fin</label>
		        		<div class="col-xs-9">
		        			<input type="text" name="end_date" class="form-control">
	        			</div>	
		        	</div>
		        	<div class="form-group row">
		        		<label for="prize" class="col-xs-3 col-form-label text-right">Lot à gagner</label>
		        		<div class="col-xs-9">
		        			<input type="text" name="prize" class="form-control">
		        		</div>
		        	</div>
		        	<div class="form-group row">
		        		<label for="prize" class="col-xs-3 col-form-label text-right">url du lot</label>
		        		<div class="col-xs-9">
		        			<input type="text" name="url_prize" class="form-control">
		        		</div>
		        	</div>
		        </form>
		      </div>
		      <div class="modal-footer">
		        <button type="button" id="submit" class="btn btn-success col-offset-3">Créer le concours</button>
		      </div>
		    </div>
		  </div>
		</div>

	</div>
</div>

