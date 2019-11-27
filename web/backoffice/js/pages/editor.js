//[editor Javascript]

//Project:	mínimo admin - Responsive Admin Template
//Primary use:   Used only for the wysihtml5 Editor 


//Add text editor
    $(function () {
	//bootstrap WYSIHTML5 - text editor
    $('#appbundle_presentation_contenu').wysihtml5();
    $('#appbundle_service_contenu').wysihtml5();
    $('#appbundle_actualite_contenu').summernote();
    //$('#appbundle_event_contenu').wysihtml5();
    $('#appbundle_artiste_biographie').wysihtml5();
    $('#appbundle_candidat_biographie').wysihtml5();
    $('#appbundle_buzz_contenu').wysihtml5();
    $('.contenu').wysihtml5();
    $('.select2').select2()
	
  });

