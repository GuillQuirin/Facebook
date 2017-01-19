$(document).ready(function() {
    /*COMPETITIONS*/

    //Liste des competitions
    var listAdmin = $('#listCompetitions').DataTable( {
        "paging":   true,
        "ordering": true,
        "info":     true,
        "responsive": true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "language": {
            "lengthMenu": "Affichage de _MENU_ résultats par page",
            "zeroRecords": "Aucun résultat trouvé",
            //"info": "",
            "info": "Affichage de la page numéro _PAGE_ sur un total de _PAGES_ page(s)",
            "infoEmpty": "Pas de résultat trouvé",
            "infoFiltered": "(trier sur un enregistrement total de _MAX_ résultats)",
            "search": "Rechercher"
        }
    } );


    //Affichage des infos dans une modal
    $('#ModalEdit').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var modal = $(this);

        $('.errorEdit').text('');

        modal.find('input[name="id_competition"]').val(button.data('id'));
        modal.find('input[name="name"]').val(button.data('name'));
        modal.find('textarea[name="description"]').val(button.data('description'));
        modal.find('input[name="start_date"]').val(button.data('begin'));
        modal.find('input[name="end_date"]').val(button.data('end'));
        modal.find('input[name="prize"]').val(button.data('prize'));
        modal.find('input[name="url_prize"]').val(button.data('url'));
        
        if(button.data('active')=="1")
            modal.find('input[name="active"]').prop('checked','checked');
        else
            modal.find('input[name="active"]').prop('checked',false);
    });

    //Modifications du concours en ajax
    $('#ModalEdit #submitEdit').click(function(){
        $('#submitEdit').html("Enregistrement.....");
        
        $.ajax({
          method: "POST",
          url: $('[name="webpath"]').val()+"/admin/editCompetition",
          data: $('#data_competition').serialize() //récuperation des input présents dans le <form>
        })
          .done(function( msg ){
            if(msg!="ok"){
                $('.errorEdit').html(msg);
                $('#submitEdit').html("Modifier le concours");
            }
            else
                location.reload();
          });
        return false;
    });

    //Création du nouveau concours en ajax
    $('#CreateCompetition #submitCreate').click(function(){
        $('#submitEdit').html("Enregistrement.....");
        
        $.ajax({
          method: "POST",
          url: $('[name="webpath"]').val()+"/admin/addCompetition",
          data: $('#create_data_competition').serialize() //récuperation des input présents dans le <form>
        })
          .done(function( msg ){
            /*if(msg!="ok"){
                $('.errorCreate').html(msg);
                $('#submitEdit').html("Créer le concours !");
            }
            else
                location.reload();*/
            console.log(msg);
          });
        return false;
    });

    //Réinitialisation du message d'erreur
    $('#CreateCompetition').on('show.bs.modal', function (event) {
        $('.errorCreate').html('');
    });


    /*PARTICIPANTS*/

    //Liste des photo signalees
    var listReportedPhoto = $('#listReportedPhoto').DataTable( {
        "paging":   true,
        "ordering": true,
        "info":     true,
        "responsive": true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "language": {
            "lengthMenu": "Affichage de _MENU_ résultats par page",
            "zeroRecords": "Aucun résultat trouvé",
            "info": "Affichage de la page numéro _PAGE_ sur un total de _PAGES_ page(s)",
            "infoEmpty": "Pas de résultat trouvé",
            "infoFiltered": "(trier sur un enregistrement total de _MAX_ résultats)",
            "search": "Rechercher"
        }
    });

    //Verrouiller une participation
    $('.lock_photo, .unlock_photo').click(function(){
        var button = $(this);
        var locked = (button.hasClass("lock_photo")) ? 1 : 0;

        $.ajax({
          method: "POST",
          url: $('[name="webpath"]').val()+"/admin/adminPhoto",
          data: {
            "id" : button.prop('id').replace("photo-",""),
            "url_photo" : button.parent().parent().find('a[name="url_photo"]').text(),
            "is_locked" : locked
            }
        })
          .done(function() {
            if(locked==1)
                button.removeClass("btn-success lock_photo").addClass("btn-danger unlock_photo").html("Verrouillée");
            else
                button.removeClass("btn-danger unlock_photo").addClass("btn-success lock_photo").html("Déverrouillée");
        });
    });


    /*SUMMERNOTE*/
    /*
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
    });*/


} );
