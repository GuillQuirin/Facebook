<div class="col-md-12">
	<div>
		<h2 class="text-center text-uppercase">Liste des concours</h2>

		<table id="listCompetitions" class="table stripe responsive order-column text-center">
			<thead>
				<th>Nom</th>
				<th>Début</th>
				<th>Fin</th>
				<th>Lot à gagner</th>
				<th>Photo du lot</th>
				<th>Nombre de participants</th>
				<th>Nom du gagnant</th>
				<th>Statut</th>
				<th>Edition</th>
			</thead>
			<tbody>
				<?php foreach ($listCompetitions as $key => $competition) { ?>
					<tr>
						<td name='name'> <?php echo $competition->getName(); ?></td>
						<td name='start_date' > <?php echo $competition->getStart_date(); ?></td>
						<td name='end_date' ><?php echo $competition->getEnd_date(); ?></td>
						<td name='prize' > <?php echo $competition->getPrize(); ?></td>
						<td name='url_prize'><?php echo (trim($competition->getUrl_prize())!="") ? 
												"<a target='_blank' href='".$competition->getUrl_prize()."'>Lien du prix</a>" : 
												""; 
											?>
						</td>
						<td name='totalParticipants' > <?php echo $competition->getTotalParticipants(); ?></td>
						<td name='id_winner' ><?php echo $competition->getId_winner(); ?></td>
						<td name='active'>
							<?php echo ($competition->getActive()==1) ? "Actif" : ""; ?>
						</td>
						<td>
							<button 
								class="btn btn-warning"
								data-toggle="modal" 
								data-target="#ModalEdit" 
								data-id="<?php echo $competition->getId_competition(); ?>"
								data-name="<?php echo $competition->getName(); ?>"
								data-description="<?php echo $competition->getDescription(); ?>"
								data-begin="<?php echo $competition->getStart_date(); ?>"
								data-end="<?php echo $competition->getEnd_date(); ?>"
								data-prize="<?php echo $competition->getPrize(); ?>"
								data-url="<?php echo $competition->getUrl_prize(); ?>"
								data-active="<?php echo $competition->getActive(); ?>">
								Modifier
							</button>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="col-md-offset-3 col-md-6 col-offset-3 btn-new-competition">
		<button type="button" data-toggle="modal" data-target="#CreateCompetition" class="col-md-12 btn btn-success">Créer un concours !</button>
	</div>
	<div class="col-md-12">
		<h2 class="text-center text-uppercase">Liste des photos signalées</h2>

		<table id="listReportedPhoto" class="table stripe order-column">
			<thead>
				<th>Nom du participant</th>
				<th>Lien de l'image signalée</th>
				<th>Action</th>
			</thead>
			<tbody>
				<?php if(isset($listReportedPhoto)) : ?>
					<?php foreach ($listReportedPhoto as $key => $photo) : ?>
						<tr>
							<td>
								<?php echo strtoupper($photo->getLast_name())." ".ucfirst($photo->getFirst_name()); ?>	
							</td>
							<td><a href="<?php echo $photo->getUrl_photo(); ?>" target="_blank" name="url_photo">Lien de la photo</a></td>
							<td> 
								<?php echo ($photo->getIs_locked()==0) ? "<button id='photo-".$photo->getId()."' class='btn btn-success lock_photo'>Déverrouillé</button>" : "<button id='photo-".$photo->getId()."' class='btn btn-danger unlock_photo'>Verrouillé</button>" ?>
							</td>
						</tr>
					<?php endforeach; ?>  
				<?php else : ?>
					<tr><td></td><td>Pas de photo signalées par les utilisateurs</td><td></td></tr>
				<?php endif ?>
			</tbody>
		</table>

		<!--      Modal      -->
		<!-- Modification -->
		<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Modifier un concours</h4>
					</div>
					<div class="modal-body">
						<form id="data_competition">
							<input type="hidden" name="id_competition">
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
					<p class="errorEdit"></p>
					<button type="button" id="submitEdit" class="btn btn-primary">Modifier le concours</button>
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
					<h4 class="modal-title" id="myModalLabel">Création d'un concours</h4>
				</div>
				<div class="modal-body">
					<form id="create_data_competition">
						<div class="form-group">
							<label for="name">Intitulé du concours : </label>
							<input type="name" name="name" class="form-control" id="name" required>
						</div>
						<div class="form-group">
							<label for="description">Description du concours :</label>
							<textarea name="description" id="summernote" placeholder="Saisissez la description de votre concours..."></textarea>
						</div>
						<div class="form-group">
							<label for="start_date">Date de début du concours : </label>
							<div class="date" id="datePicker">
								<div class="input-group">
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
									<input type="text" class="form-control" name="start_date" id="start_date" placeholder="jj/mm/aaaa" required>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="end_date">Date de fin du concours : </label>
							<div class="date" id="datePicker2">
								<div class="input-group">
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
									<input type="text" class="form-control" name="end_date" id="end_date" placeholder="jj/mm/aaaa" required/>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="prize">Lot à gagner : </label>
							<input type="text" class="form-control" name="prize" id="prize">
						</div>
						<div class="text-center">
							<p class="errorCreate"></p>
							<button type="submit" id="submitCreate" class="btn btn-lg btn-success">Créer le concours !</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		$.fn.datepicker.defaults.language = 'fr';

		$('#datePicker').datepicker({
			endDate: "+",
			startDate: "-2m",
			autoclose: true,
			format: "dd/mm/yyyy"
		});

		$('#datePicker2').datepicker({
			endDate: "+12m",
			startDate: "+1d",
			autoclose: true,
			format: "dd/mm/yyyy"
		})

		$('#summernote').summernote({
      height: 200,                 // set editor height
      minHeight: null,             // set minimum height of editor
      maxHeight: null,             // set maximum height of editor
      focus: true 
  }); 
	});
</script>

