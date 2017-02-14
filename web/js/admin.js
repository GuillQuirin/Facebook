$(document).ready(function() {
    /*******************************COMPETITIONS******************************/

    //Liste des competitions
    var listAdmin = $('#listCompetitions').DataTable( {
        "paging":   true,
        "ordering": true,
        "order": [[ 1, "desc" ]],
        "info":     true,
        responsive: true,
        "lengthMenu": [[5, 10, 20, -1], [5, 10, 20, "Tous"]],
        "language": {
            "lengthMenu": "Affichage de _MENU_ résultats par page",
            "zeroRecords": "Aucun concours trouvé",
            "info": "Affichage de la page numéro _PAGE_ sur un total de _PAGES_ page(s)",
            "infoEmpty": "Pas de concours trouvé",
            "infoFiltered": "(trier sur un enregistrement total de _MAX_ résultats)",
            "search": "Rechercher"
        }
    });

    //Affichage des infos dans une modal
    $('#ModalEdit').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var modal = $(this);

        $('.errorEdit').text('');

        $('#submitEdit').show();
        modal.find('input[name="active"]').parent().parent().show();
        $('#data_competition input, #data_competition textarea').each(function(){
            $(this).attr('disabled',false);
        });

        modal.find('input[name="id_competition"]').val(button.data('id'));
        modal.find('input[name="name"]').val(button.data('name'));
        modal.find('textarea[name="description"]').val(button.data('description'));
        modal.find('input[name="start_date"]').val(button.data('begin'));
        modal.find('input[name="end_date"]').val(button.data('end'));
        modal.find('input[name="prize"]').val(button.data('prize'));
        modal.find('input[name="url_prize"]').val(button.data('url'));
        
        if(button.data('active')=="1")
            modal.find('input[name="active"]').prop('checked','checked');
        else if(button.data('active')=="2"){
            $('#submitEdit').hide();
            modal.find('input[name="active"]').parent().parent().hide();
            $('#data_competition input, #data_competition textarea').each(function(){
                $(this).attr('disabled','disabled');
            });
        }
        else
            modal.find('input[name="active"]').prop('checked',false);
    });


    //Modifications du concours en ajax
    $('#data_competition').submit(function(){
        $('#submitEdit').html("Enregistrement.....");
        $('.errorEdit').html("");

        if(!checkDate('#data_competition')){
            $('.errorEdit').html("Les dates du concours ne correspondent pas !");
            return false;
        }
        
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
    $('#create_data_competition').submit(function(){
        $('#submitCreate').html("Enregistrement.....");
        $('.errorCreate').html("");

        if(!checkDate('#create_data_competition')){
            $('.errorCreate').html("Les dates du concours ne correspondent pas !");
            return false;
        }

        $.ajax({
          method: "POST",
          url: $('[name="webpath"]').val()+"/admin/addCompetition",
          data: $('#create_data_competition').serialize() //récuperation des input présents dans le <form>
        })
          .done(function( msg ){
            if(msg!="ok"){
                $('.errorCreate').html(msg);
                $('#submitEdit').html("Créer le concours !");
            }
            else
                location.reload();
            //console.log(msg);
          });
        return false;
    });

    //Réinitialisation du message d'erreur
    $('#CreateCompetition').on('show.bs.modal', function (event) {
        $('.errorCreate').html('');
    });


    /*****************************PARTICIPANTS******************************/

    //Liste des participants
    var listUsers = $('#listUsers').DataTable( {
        "paging":   true,
        "ordering": true,
        "info":     true,
        responsive: true,
        "lengthMenu": [[5, 10, 20, -1], [5, 10, 20, "Tous"]],
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: -1 }
        ],
        "lengthMenu": [[5, 10, 20, -1], [5, 10, 20, "Tous"]],
        "language": {
            "lengthMenu": "Affichage de _MENU_ résultats par page",
            "zeroRecords": "Pas de participant pour ce concours",
            "info": "Affichage de la page numéro _PAGE_ sur un total de _PAGES_ page(s)",
            "infoEmpty": "Pas de participant pour ce concours",
            "infoFiltered": "(trier sur un enregistrement total de _MAX_ résultats)",
            "search": "Rechercher"
        }
    });

    $('.winner').on("click",function(){
        if(confirm("Attention: une fois le vainqueur selectionné, le tournoi ne sera plus modifiable et sera automatiquement cloturé.")){
            $.ajax({
              method: "POST",
              url: $('[name="webpath"]').val()+"/admin/selectWinner",
              data: {
                    id_user: $(this).attr('data-id')
                }
            })
            .done(function(result) {
                //console.log(result);
                location.reload();
            });
        }
    });

    //Liste des photo signalees
    var listReportedPhoto = $('#listReportedPhoto').DataTable( {
        "paging":   true,
        "ordering": true,
        "info":     true,
        responsive: true,
        "lengthMenu": [[5, 10, 20, -1], [5, 10, 20, "Tous"]],
        "language": {
            "lengthMenu": "Affichage de _MENU_ résultats par page",
            "zeroRecords": "Pas de photo signalées par les utilisateurs",
            "info": "Affichage de la page numéro _PAGE_ sur un total de _PAGES_ page(s)",
            "infoEmpty": "Pas de photo signalées par les utilisateurs",
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
} );


function checkDate(form){
    var debut = new Date($(form+' input[name="start_date"]').val());
    var fin = new Date($(form+' input[name="end_date"]').val());
    if(debut>fin)
        return false;
    else
        return true;
}




