<?php 
	if(!empty($listParticipation)): 
		?>
		<select name="quantity">
			<option value="2">2</option>
			<option value="5">5</option>
			<option value="10" selected>10</option>
			<option value="20">20</option>
		</select>
		<select name="sort">
			<option value="0" selected>Aléatoire</option>
			<option value="1">Le plus ancien</option>
			<option value="2">Le plus récent</option>
			<option value="3">Tri par like</option>
		</select>
		<input type="hidden" id="url" value="<?php echo __URI__; ?>">
		<div class="row">
			<div class="col-md-12" id="gallery">
			</div>
		</div>
		<!-- Pagination -->
		<div class="row">
			<nav class="col-xs-8 col-xs-offset-2 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2" aria-label="Page navigation">
			  <ul class="pagination">
			  </ul>
			</nav>
		</div>
<?php else: ?>
	<h3>Soyez le premier participant au concours !</h3>
	<h5>Pour vous inscrire, accèder <a href="<?php echo WEBPATH.'/index'; ?>">ici</a></h5>
<?php endif; ?>