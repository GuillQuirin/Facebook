<?php if(isset($competition) && $competition!==NULL) : ?>
	<?php if(isset($listParticipation) && !empty($listParticipation)): ?>
		<div class="col-sm-12 selectitem">
			<div class="col-sm-2">
			<!-- Nombre d'élèments à afficher --> 
			<select class="form-control" name="quantity">
				<option value="2">2</option>
				<option value="5">5</option>
				<option value="10" selected>10</option>
				<option value="20">20</option>
			</select>
			</div>
			<div class="col-sm-3">
			<!-- Tri des élèments -->
			<select class="form-control" name="sort">
				<option value="0" selected>Aléatoire</option>
				<option value="1">Le plus ancien</option>
				<option value="2">Le plus récent</option>
				<option value="3">Tri par like</option>
			</select>
			</div>
		</div>
		<input type="hidden" id="url" value="<?php echo __URI__; ?>">

		<!-- Mosaique -->
		<div class="row">
			<div class="col-sm-12" id="gallery">
			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id='popUpGallery' tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<form action="<?php echo WEBPATH.'/index/submit'; ?>" method="post">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4>Photo proposée le <span class="modal-date"></span></h4> 
						</div>
						<div class="modal-body">
						</div>
						<div class="modal-footer text-center">
							Par <span class="modal-name"></span>
						</div>
					</div>
				</form>
			</div>
		</div>

		<!-- Pagination -->
		<div class="row">
			<nav class="text-center col-sm-12" aria-label="Page navigation">
				<ul class="pagination">
				</ul>
			</nav>
		</div>
	<?php else: ?>
		<div id="none">
			<h3>Soyez le premier participant au concours !</h3>
			<h5>Pour vous inscrire, accèder <a href="<?php echo WEBPATH.'/index'; ?>">ici</a></h5>
		</div>
	<?php endif; ?>
<?php else : ?>
	<h3>Aucun concours n'est actuellement disponible</h3>
<?php endif; ?>