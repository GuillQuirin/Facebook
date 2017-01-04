<div class="container">
	<div class="col-md-5">
		<h2 class="text-uppercase"> Sélection d'un design existant </h2>
		<div class="input-group">
			<select class="form-control" name="designExist" id="designExist">
				<?php foreach ($listDesign as $key => $design) { ?>
				<option value="<?php echo $design->getId_design();?>"><?php echo $design->getName(); ?></option>
				<?php } ?>                            
			</select>
			<span class="input-group-btn">
				<button type="submit" class="btn btn-success">Appliquer le design</button>
			</span>
		</div><br>
		<hr>
		<h2 class="text-uppercase"> Création d'un design </h2>
		<div class="form-group">
				<label for="name">Nom du design :</label>
				<input type="text" class="form-control" name="name" id="name" placeholder="" required>
		</div>
		<div class="form-group">
			<label for="url">URL de l'image de fond :</label>
			<input type="text" class="form-control" name="url" id="url" placeholder="">
		</div>
		<div class="col-md-12 no-padding text-center">
			<h3 class="no-margin">OU</h3>
		</div>
		<div class="form-group">
			<label for="color">Couleur du fond :</label>
			<input type="text" class="form-control" name="color" id="color">
		</div>
		<div class="form-group">
			<label for="fontColor">Couleur de la police :</label>
			<input type="text" class="form-control" name="fontColor" id="fontColor" required>
		</div>
		<div class="form-group">
			<label for="fontColorForm">Couleur des champs du formulaire :</label>
			<input type="text" class="form-control" name="fontColorForm" id="fontColorForm" required>
		</div>
		<div class="form-group">
			<label for="fontSize">Taille de la police :</label>
			<input type="number" class="form-control" name="fontSize" id="fontSize" step="1" min="12" max="16" required>
		</div> 
		<div id="hsvflat"></div>
		<div class="form-group">
			<label for="fontStyle">Style de la police du texte :</label>
			<select class="form-control" name="designExist" id="designExist" required>
				<option value="">Arial</option>
				<option value="">Arial, sans serif</option> 
				<option value="">Comic Sans MS</option> 
				<option value="">Courier New</option> 
				<option value="">Helvetica</option>
				<option value="">Helvetica, sans serif</option> 
				<option value="">Impact</option>                               
			</select>
		</div>
		<button type="submit" class="btn btn-success">Appliquer le design</button>
		<button type="button" data-toggle="modal" data-target="#newTemplate"  class="btn btn-success">Enregistrer sous un nouveau template</button>
	</div>
	<div class="col-md-6 col-md-offset-1">
		<h2 class="text-uppercase">Aperçu</h2>
		<div class="col-md-12 apercu" id="apercu">
			<h2 class="text-uppercase"> Sélection d'un design existant </h2>
			<div class="input-group">
				<select class="form-control" name="designExistExemple" id="designExistExemple">                       
				</select>
				<span class="input-group-btn">
					<button type="submit" class="btn btn-success">Appliquer le design</button>
				</span>
			</div><br>
			<h2 class="text-uppercase"> Création d'un design </h2>
			<div class="form-group">
				<label for="name">Nom du design :</label>
				<input type="text" class="form-control" name="url" id="url" placeholder="" required>
			</div>
			<div class="form-group">
				<label for="url">URL de l'image de fond :</label>
				<input type="text" class="form-control" name="url" id="url" placeholder="" required>
			</div>
			<div class="form-group">
				<label for="fontSize">Taille de la police :</label>
				<input type="number" class="form-control" name="fontSize" id="fontSize" step="1" min="12" max="16" required>
			</div> 
			<div class="form-group">
				<label for="fontStyle">Police du texte :</label>
				<select class="form-control" name="fontStyle" id="fontStyle" required>
					<option value="">Arial</option>                               
				</select>
			</div>
			<button type="submit" class="btn btn-success">Appliquer le design</button>
			<button type="submit" class="btn btn-success">Enregistrer sous un nouveau template</button><br><br>
		</div>
	</div>
</div>
<script>
	$(document).ready(function () {
		$('select[name="designExist"]').change(function () {
			$.ajax({
				url: 'design/getDesign',
				method: 'POST',
				data: {id_design: $(this).val()},
				success: function (data) {
					console.log(data);
					var listDesign = JSON.parse(data);
					document.getElementById("name").value = listDesign[0].name;
					document.getElementById("url").value = listDesign[0].background_url;
					document.getElementById("color").value = listDesign[0].background_color;
					document.getElementById("fontColor").value = listDesign[0].text_color;
					document.getElementById("fontColorForm").value = listDesign[0].form_color;
					document.getElementById("fontSize").value = listDesign[0].font_size;
					document.getElementById("fontStyle").value = listDesign[0].font_name;
					document.getElementById("apercu").style.backgroundColor = listDesign[0].background_color;
					document.getElementById("apercu").style.color = listDesign[0].text_color;
					document.getElementById("apercu").style.fontSize = listDesign[0].font_size;
					document.getElementById("apercu").style.fontFamily = listDesign[0].font_name;
					document.getElementById("apercu").style.backgroundImage = "url('" + listDesign[0].background_url + "')";
				}
			});
		});
	});
</script>
