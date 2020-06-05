@extends('layouts.app')

@section('meta_title', "Accueil")

@section('breadcrumb')


@section('content')
     <div class="page-container">

         <div class="page-header">
             <h2 id="principal">Vous avez un projet de développement durable ?</br>Vous êtes une collectivité, une entreprise, une association, un citoyen,...</br><strong><span style="padding-top: 10px; color: #11884d; font-weight:bold;" class="count-dispositifs">{!! trans_choice('messages.home.count', $countCallsForProjects) !!} disponibles</span></strong></h2>

         </div>

         @include('front.research')

         {{-- Le code suivant est une archive : séparation en deux fichiers de la barre de recherche et les filtres.
         @include('front.home.quick-search')

         <div>
             <a id="dispositifs-filters-button" href="#">
                 <span>Filtrer</span>
                 <i class="fa fa-plus"></i>
                 <i class="fa fa-minus"></i>
             </a>

             <div id="dispositifs-filters-container">
                 @include('front.dispositifs.filters')
             </div>
         </div>
         @include('front.home.advanced-search')--}}

         @include('front.home.news')
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
