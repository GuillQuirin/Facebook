<?php if(isset($listParticipation)) : ?>
	<?php 
		if(!empty($listParticipation)): 
			?>
			<!-- Nombre d'élèments à afficher --> 
			<select name="quantity">
				<option value="2">2</option>
				<option value="5">5</option>
				<option value="10" selected>10</option>
				<option value="20">20</option>
			</select>

			<!-- Tri des élèments -->
			<select name="sort">
				<option value="0" selected>Aléatoire</option>
				<option value="1">Le plus ancien</option>
				<option value="2">Le plus récent</option>
				<option value="3">Tri par like</option>
			</select>
			<input type="hidden" id="url" value="<?php echo __URI__; ?>">
			
			<!-- Mosaique -->
			<div class="row">
				<div class="col-md-12" id="gallery">
				</div>
			</div>

			<!-- Modal -->
			<div class="modal fade" id='popUpGallery' tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
			    <form action="<?php echo WEBPATH.'/index/submit'; ?>" method="post">
			    <div class="modal-content">
			      <div class="modal-header">
				    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4>Photo proposée par <span class="modal-name"></span></h4> 
			      </div>
			      <div class="modal-body">
			      </div>
			      <div class="modal-footer">
			      	<div class="col-xs-6 col-sm-6 col-md-6 modal-report report text-left">
			      		<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6e/VisualEditor_-_Icon_-_Alert.svg/2000px-VisualEditor_-_Icon_-_Alert.svg.png" alt="Signaler"> Signaler la photographie
			        </div>
			        <div class="col-md-6 modal-like text-right">
					</div>
			      </div>
			    </div>
			    </form>
			  </div>
			</div>

			<!-- Pagination -->
			<div class="row">
				<nav class="text-center col-xs-8 col-xs-offset-2 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2" aria-label="Page navigation">
				  <ul class="pagination">
				  </ul>
				</nav>
			</div>
	<?php else: ?>
		<h3>Soyez le premier participant au concours !</h3>
		<h5>Pour vous inscrire, accèder <a href="<?php echo WEBPATH.'/index'; ?>">ici</a></h5>
	<?php endif; ?>
<?php else : ?>
	<h3>Aucun concours n'est actuellement disponible</h3>
<?php endif; ?>