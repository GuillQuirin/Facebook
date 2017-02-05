
<h2 class="text-center text-uppercase col-md-12">Liste des concours</h2>

<table id="listCompetitions" class="table stripe responsive order-column text-center col-md-12">
	<thead>
		<th>Nom</th>
		<th>Début</th>
		<th>Fin</th>
		<th>Nombre de participants</th>
		<th>Statut</th>
		<th>Edition</th>
	</thead>
	<tbody>
		<?php if(isset($listCompetitions)): ?>
			<?php foreach ($listCompetitions as $key => $competition) { ?>
				<tr>
					<td name='name'> <?php echo $competition->getName(); ?></td>
					<td name='start_date' > <?php echo date('d/m/Y',strtotime($competition->getStart_date())); ?></td>
					<td name='end_date' ><?php echo date('d/m/Y',strtotime($competition->getEnd_date())); ?></td>
					<td name='totalParticipants' > <?php echo $competition->getTotalParticipants(); ?></td>
					<td name='active'>
						<?php 
							if($competition->getActive()==1) 
								echo "Actif"; 
							if($competition->getActive()==2)
								echo "Terminé";
						?>
					</td>
					<td>
						<button 
							class="btn <?php echo ($competition->getActive()==2) ? "btn-success" : "btn-warning"; ?>"
							data-toggle="modal" 
							data-target="#ModalEdit" 
							data-id="<?php echo $competition->getId_competition(); ?>"
							data-name="<?php echo $competition->getName(); ?>"
							data-description="<?php echo $competition->getDescription(); ?>"
							data-begin="<?php echo str_replace("/","-",$competition->getStart_date()); ?>"
							data-end="<?php echo str_replace("/","-",$competition->getEnd_date()); ?>"
							data-prize="<?php echo $competition->getPrize(); ?>"
							data-url="<?php echo $competition->getUrl_prize(); ?>"
							data-active="<?php echo $competition->getActive(); ?>">
							<?php echo ($competition->getActive()==2) ? "Consulter" : "Modifier"; ?>
						</button>
					</td>
				</tr>
			<?php } ?>
		<?php endif; ?>
	</tbody>
</table>


<div class="col-md-12 btn-new-competition">
	<button type="button" 
			data-toggle="modal" 
			data-target="#CreateCompetition" 
			class="col-xs-6 col-xs-offset-3 col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 btn btn-success">
			Créer un concours !
	</button>
</div>

<h2 class="text-center text-uppercase col-md-12">Liste des participants du concours actuel</h2>
<div class="col-md-12">
<table id="listUsers" class="table stripe order-column text-center col-md-12">
	<thead>
		<th>Nom</th>
		<th>Prenom</th>
		<th>Email</th>
		<th>Age</th>
		<th>Emplacement</th>
		<th>Nombre de votes</th>
		<th>Action</th>
	</thead>
	<tbody>
		<?php if(isset($listUsers)) : ?>
			<?php foreach ($listUsers as $key => $participant) : ?>
				<tr>
					<td>
						<?php echo strtoupper($participant['last_name']); ?>	
					</td>
					<td>
						<?php echo ucfirst($participant['first_name']); ?>
					</td>
					<td>
						<?php echo $participant['email']; ?>
					</td>
					<td>
						<?php echo $participant['age_range']; ?>
					</td>
					<td>
						<?php echo $participant['location']; ?>
					</td>
					<td>
						<?php echo $participant['nb_votes']; ?>
					</td>
					<td> 
						<button class="btn btn-success winner" data-id="<?php echo $participant['id_user']; ?>">Désigner vainqueur</button>
					</td>
				</tr>
			<?php endforeach; ?>  
		<?php endif ?>
	</tbody>
</table>
</div>

<h2 class="text-center text-uppercase col-md-12">Liste des photos signalées</h2>
<div class="col-md-12">
<table id="listReportedPhoto" class="table stripe order-column text-center col-md-12">
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
						<?php echo ($photo->getIs_locked()==0) ? "<button id='photo-".$photo->getId_participate()."' class='btn btn-success lock_photo'>Déverrouillée</button>" : "<button id='photo-".$photo->getId_participate()."' class='btn btn-danger unlock_photo'>Verrouillée</button>"?>
					</td>
				</tr>
			<?php endforeach; ?>  
		<?php endif ?>
	</tbody>
</table>
</div>

<!--      Modal      -->
<!-- Modification -->
<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<form id="data_competition">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Modifier un concours</h4>
				</div>
				<div class="modal-body">
					<input type="hidden" name="id_competition">
					<div class="form-group row">
						<label for="name" class="col-xs-3 col-form-label text-left">Intitulé</label>
						<div class="col-xs-9">
							<input type="text" name="name" class="form-control" required>
						</div>
					</div>
					<div class="form-group row">
						<label for="description" class="col-xs-3 col-form-label text-left">Description</label>
						<div class="col-xs-9">
							<textarea class="form-control" name="description" rows="3" required></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label for="start_date" class="col-xs-3 col-form-label text-left">Date de début</label>
						<div class="col-xs-9">
							<input type="date" name="start_date" class="form-control" required>
						</div>
					</div>
					<div class="form-group row">
						<label for="end_date" class="col-xs-3 col-form-label text-left">Date de fin</label>
						<div class="col-xs-9">
							<input type="date" name="end_date" class="form-control" required>
						</div>	
					</div>
					<div class="form-group row">
						<label for="prize" class="col-xs-3 col-form-label text-left">Lot à gagner</label>
						<div class="col-xs-9">
							<input type="text" name="prize" class="form-control" required>
						</div>
					</div>
					<div class="form-group row">
						<label for="prize" class="col-xs-3 col-form-label text-left">Url du lot</label>
						<div class="col-xs-9">
							<input type="text" name="url_prize" class="form-control" required>
						</div>
					</div>
					<div class="form-check row">
						<label class="col-xs-3 form-check-label text-left">Actif</label>
						<div class="col-xs-9">
							<input type="checkbox" name="active" class="form-check-input">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<p class="errorEdit"></p>
					<p>Pour terminer un concours, vous devez désigner un vainqueur ou atteindre la date de fin indiquée.</p>
					<input type="submit" id="submitEdit" class="btn btn-success" value="Sauvegarder">
				</div>
			</div>
		</form>
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
						<textarea name="description" id="summernote" placeholder="Saisissez la description de votre concours..." required></textarea>
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
						<input type="text" class="form-control" name="prize" id="prize" required>
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