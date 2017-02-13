<div class="container" id="design">
	<div class="col-sm-5">
		<h2 class="text-uppercase"> Selection d'un design existant </h2>
		<form>
			<div class="input-group">
				<select class="form-control" name="designExist" id="designExist">
					<?php foreach ($listDesign as $key => $design) { ?>
					<option value="<?php echo $design->getId_design();?>"><?php echo $design->getName(); ?></option>
					<?php } ?>                            
				</select>
				<span class="input-group-btn">
					<button type="submit" id="applyTemplate" class="btn btn-success">Appliquer le design</button>
				</span>
			</div><br>
		</form>
	</div>
	<div class="col-sm-6 col-sd-offset-1">
		<h2 class="text-uppercase">Aperçu</h2>
		<div class="col-md-12 apercu" id="apercu"><br>
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
			</div><br>
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
					var listDesign = JSON.parse(data);
					$("#name").val(listDesign[0].name);
					$("#url").val(listDesign[0].background_url);
					$("#color").val(listDesign[0].background_color);
					$("#fontColor").val(listDesign[0].text_color);
					$("#fontColorForm").val(listDesign[0].form_color);
					$("#fontSize").val(listDesign[0].font_size);
					$("#fontStyle").val(listDesign[0].font_name);
					$("#apercu").css("backgroundColor", listDesign[0].background_color);
					$("#apercu").css("color", listDesign[0].text_color);
					$("#apercu").css("fontSize", listDesign[0].font_size);
					$("#apercu").css("fontFamily", listDesign[0].font_name);
					$("#apercu").css("background-image", 'url(' + listDesign[0].background_url + ')');
					$("#apercu").find("input").css("backgroundColor", listDesign[0].form_color);
					$("#apercu").find("select").css("backgroundColor", listDesign[0].form_color);
				}
			});
		});

		$('#saveTemplate').click(function(){
  			var f = document.getElementsByTagName('form')[0];
			 if(f.checkValidity()) {   
				$.ajax({
					method: "POST",
					url: $('[name="webpath"]').val()+"/design/addDesign",
					data: {
						name: $("#name").val(),
						background_url: $("#url").val(),
						background_color: $("#color").val(),
						text_color: $("#fontColor").val(),
						form_color: $("#fontColorForm").val(),
						font_size: $("#fontSize").val(),
						font_name : $("#fontStyle").val()
						}
				})
				.done(function( msg ) {
					location.reload();
				});
			}
		});

		$('#applyTemplate').click(function(){
				$.ajax({
					method: "POST",
					url: $('[name="webpath"]').val()+"/design/applyDesign",
					data: {id_design: $("#designExist").val()
						}
				})
				.done(function( msg ) {
					location.reload();
				});
		});
	});
</script>
