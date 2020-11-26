@extends('layouts.app')

@section('meta_title', "Accueil")

@section('breadcrumb')


@section('content')
     <div class="page-container">

         <div class="page-header">
             <h2 id="principal">Le site ADDNA  favorise la réalisation sur le territoire néo-aquitain de projets contribuant au développement durable.

                     <p>Vous avez accès :</p>
                     <ul>
                         <li>aux différentes aides (aides classiques, appels à projets, AMI, fonds, aides, prix, concours, etc) en cours ou à venir et à différentes échelles, locales, régionales, nationales, européennes.</li>
                         <li>à une  mise en relation des mécènes et des porteurs de projets dans le cadre convention cadre du 5 juillet 2018 relative au pôle régional mécénat Nouvelle-Aquitaine.
                         </li>
                     </ul>

             </h2>
         </div>
<div class="container">
         <div class="row">
             <div class="col-md-6">
                 <a href="{{ route('front.aides.consulter') }}" class="nostyle">
                     <div class="block-home-container" title="Consulter les aides">
                         Les aides en Nouvelle-Aquitaine <span class="fa fa-external-link"></span>
                     </div>
                 </a>
             </div>
             <div class="col-md-6">
                 <a href="#" title="Cette rubrique sera bientôt disponible" class="nostyle">
                     <div class="block-home-container mecenat" title="Vous allez être redirigé sur la plateforme aide territoire">
                         Les mécénat en Nouvelle-Aquitaine <span class="fa fa-external-link"></span><br>
                         <span class="small"><em>(Bientôt disponible)</em></span>
                     </div>
                 </a>
             </div>
         </div>
</div>

     </div>

 @endsection

 @push('inline-script')
     <script>
         (function ($) {
             "use strict";

             function manageThematics() {
                 $('input.thematics_hidden').remove();
                 var _form = $('.form-home');

                 $('.step-thematic .filters-items a.active').each(function () {
                     _form.prepend($('<input type="hidden" name="{{ \App\Thematic::URI_NAME_THEMATIC }}[]">').addClass('thematics_hidden').val($(this).data('id')))
                 });
             }

             $('.selectThematic').on('click', function (e) {
                 e.preventDefault();

                 $(this).toggleClass('active').promise().done(function () {
                     manageThematics();
                 });
             });

             $('.step-thematic .select-all').on('click', function () {
                 $('.selectThematic').each(function () {
                     $(this).trigger('click');
                 });
             });

             $('.step-perimeter .select-all').on('click', function () {
                 $('.selectPerimeter option').not(':disabled').prop('selected', true);
                 $('.selectPerimeter').data('selectric').refresh();
             });

             $('.step-perimeter .select-none').on('click', function () {
                 $('.selectPerimeter option').not(':disabled').prop('selected', false);
                 $('.selectPerimeter').data('selectric').refresh();
             });

             $('#form-newsletter').submit(function (e) {
                 e.preventDefault();

                 let form = $(this);

                 form.find('.alert').remove();

                 $.ajax({
                     url: $(this).attr('action'),
                     method: 'post',
                     data: form.serialize(),
                     success: function (data) {
                         form.prepend($('<div class="alert alert-success">').append($('<p>').html(data)));
                     },
                     error: function (data, json) {
                         let alert = $('<div class="alert alert-danger">');

                         $.each(data.responseJSON.errors, function (k, item) {
                             $.each(item, function (k2, item2) {
                                 alert.append($('<p>').html(item2));
                             });
                         });

                         form.prepend(alert);
                     }
                 });
             });

            // Autocomplete for perimeters
            let search = ''

             $('#perimeter').keyup( event => {
                const value = event.target.value

                if (value === '') {
                    $('.autocomplete').empty()
                }
                // if search has changed
                if (value !== search) {
                    search = value
                } else {
                    return
                }
                $.getJSON(`/api/autocomplete/perimeters?query=${value}`, perimeters => {
                    $('#autocomplete_perimeters').empty()
                    const options = perimeters.slice(0, 5).map( suggestion => {
                        const option = genererOption(suggestion)
                        return option
                    })
                    options.forEach( opt => document.getElementById('autocomplete_perimeters').appendChild(opt))
                })
             })

             const buildOptionsFromList = () => {
                $('#perimeter-select').empty()
                perimetersSelected.forEach( perimeter => {
                    $('#perimeter-select').append(`<option selected value="${perimeter.id}">${perimeter.nom}</option>`)
                })
             }

             const genererOption = suggestion => {
                 let option = document.createElement('li')
                 let text = document.createTextNode(`${suggestion.name} - ${suggestion.type}`)
                 option.dataset['id'] = suggestion.id
                 option.dataset['nom'] = suggestion.name
                 option.appendChild(text)
                 option.classList.add('selectable')
                 return option
             }

             const perimetersSelected = []

             const resetAutocomplete = () => {
                 $('.autocomplete').empty()
                 $('#perimeter').val('')
                 $('#perimeter').focus()
             }

             const addPerimeter = perimeter => {
                if (!perimetersSelected.map(p => p.id).includes(perimeter.id)) {
                    perimetersSelected.push(perimeter);
                    // Generate span element
                    const spanPerimeter = document.createElement('span')
                    spanPerimeter.classList.add('perimeter-tag')
                    spanPerimeter.appendChild(document.createTextNode(perimeter.nom))
                    const closeButton = document.createElement('a')
                    closeButton.classList.add('closable')
                    closeButton.innerText = '❌'
                    closeButton.dataset.id = perimeter.id
                    spanPerimeter.appendChild(closeButton)

                    $("#perimeters").append(spanPerimeter)
                    $('#perimeter-select').empty()

                    buildOptionsFromList()
                }
             }

             const onSelectableClick = event => {
                 const perimeter = {
                     id: event.target.dataset.id,
                     nom: event.target.dataset.nom
                 }
                resetAutocomplete()
                addPerimeter(perimeter)
             }

             $(document).on('click', '.selectable', onSelectableClick)

             const onCloseButtonClick = event => {
                const perimeterID = $(event.target).data('id')
                $(event.target).parent().remove()
                perimetersSelected.splice(perimetersSelected.indexOf(perimeterID), 1)
                buildOptionsFromList()
             }

             $(document).on('click', '.closable', onCloseButtonClick)

         })(jQuery);
     </script>
 @endpush
