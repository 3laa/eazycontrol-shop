function initMagnificPopup() {
    $('.-magnific-popup').magnificPopup({type:'image'});
}

function initSelect2() {
    $('select').select2();
}

function sections() {
    $('.show .sections .sections-list').sortable({
        revert: true,
        cursor: "move",
        forceHelperSize: true,
        forcePlaceholderSize: true,
        opacity: 0.2,
        placeholder: 'ui-sortable-placeholder',
        tolerance: "pointer",
        handle: ".option-sort",
        stop: function( event, ui ) {
            stopSectionsSort(event, ui);
        }
    });

    $('.show .categories-list .category-item').draggable({
        cursor: "move",
        scroll: true,
        scrollSensitivity: 100,
        connectToSortable: '.show .sections-list',
        helper: "clone",
        revert: "invalid",
        stop: function(event, ui) {

        }
    });
    $( ".show ul, .show li" ).disableSelection();
}

function stopSectionsSort(event, ui) {
    let $sectionsList = ui.item.parent();
    let sectionsListSortFormData = new FormData();
    let counter = 0;
    let addNew = false

    $sectionsList.children('li').each(function (index, item) {
        if($(item)[0].hasAttribute('data-section')) {
            sectionsListSortFormData.set('item['+counter+'][id]',$(item).data('section'));
            sectionsListSortFormData.set('item['+counter+'][sort]',index);
            counter++;
        } else {
            addNew = true;
        }
    });

    axios.post(Routing.generate('backend_website_section_sort'), sectionsListSortFormData)
        .then(function (response) {
            if(addNew) {
                let category = $(ui.item).data('category');
                let page = $(ui.item).data('page');
                let sort = parseInt($(ui.item).index());
                let addNewSectionRoute = Routing.generate('backend_website_section_new', {page: page, category: category, sort: sort});
                window.location.href = addNewSectionRoute;
            }
        });
}

function sweetalert() {
    $(document).on('click', 'a[data-swal]', function (event) {
        event.preventDefault();
        let text = $(this).data('swal');
        let href =  $(this).attr('href');

        swal({
            text: text,
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        }).then((willDelete)=>{
            if (willDelete) {
                window.location.href = href;
            }
        });
    });
}

function axiosLink() {
    $(document).on('click', '[data-axios]', function (event) {
        event.preventDefault();
        let $this = $(this);
        let axiosFunction = $(this).data('axios');
        let href =  $(this).data('href');
        axios.get(href).then(function (response) {
            if (response.data)
            {
                if (axiosFunction != '')
                {
                    window[axiosFunction]($this);
                }
            }
        }).catch(function (error) {});
    });
}

function changeActive($element) {
    $element.toggleClass('fa-eye-slash');
    $element.toggleClass('fa-eye');
}

function newCollection() {
    $(document).on('click', '.collections-card .collections-actions .action.action-new', function () {
        let type = $(this).data('type');
        let prototype = $(this).parents('.collections-card').find('.collection-prototype').data('prototype');
        let file = ''

        if(type == '-MultiFiles') {
            CKFinder.popup({
                chooseFiles: true,
                width: 800,
                height: 600,
                onInit: function( finder ) {
                    finder.on( 'files:choose', function( evt ) {
                        let files = evt.data.files;
                        files.forEach(function (file, index) {
                            appendCollection(prototype, file.getUrl())
                        });

                        $('.ck_finder-wrapper .form-control').each(function () {
                            let id = $(this).attr('id');
                            let $holder = $(this).parents('.ck_finder-wrapper').find('#holder-'+id);
                            $holder.find('.-magnific-popup').html('<img src="'+$(this).val()+'"/>');
                            $holder.find('.-magnific-popup').attr('href', $(this).val());
                        });
                        initMagnificPopup();
                    });
                }
            });
        } else {
            appendCollection(prototype, file);
            initMagnificPopup();
        }
    });
}

function appendCollection(prototype, file) {
    let $collectionsList = $('.collections-card .collections-items');
    let index = $collectionsList.find('.collection').length
    prototype = prototype.replace(/__name__/g, index);
    prototype = prototype.replace(/_isActive_default"/g, '_isActive_default" checked ');
    if(file) {
        prototype = prototype.replace(/media_image" name=/g, 'media_image" value="'+file+'" name=');
    }
    $collectionsList.append(emptyCollection(prototype, index));
}

function emptyCollection(prototype, index) {
    let title = index + 1;
    return '' +
        '<li class="collection card">' +
        '<div class="card-header dark">' +
        '<h4 class="header-title " data-bs-toggle="collapse" data-bs-target="#collection-'+index+'" >New '+title+'</h4>' +

        '<div class="card-options">' +
        '<div class="option -collection-delete"><i class="option-icon far fa-trash-alt"></i></div>' +
        '<div class="option option-toggle " data-bs-toggle="collapse" data-bs-target="#collection-'+index+'"><i class="option-icon fas fa-times" ></i></div>' +
        '</div>' +
        '</div>' +

        '<div  class="card-body collapse show" id="collection-'+index+'">' + prototype +'</div>' +
        '</li>';
}

function deleteCollection() {
    $(document).on('click', '.collection.card .-collection-delete', function () {
        swal({
            text: 'Are you sure?',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        }).then((willDelete)=>{
            if (willDelete) {
                $(this).parents('.collection.card').remove();
            }
        });
    });
}

function ckFinderChoseMedia() {
    $(document).on('click', '.ck_finder .ck_finder-btn', function () {
        let id = $(this).data('btn');
        let $outputElement = $('#'+id);
        let $holder = $('#holder-'+id);
        CKFinder.popup({
            chooseFiles: true,
            width: 800,
            height: 600,
            onInit: function( finder ) {
                finder.on('files:choose', function (event) {
                    let file = event.data.files.first();
                    $outputElement.val(file.getUrl());
                    $holder.find('.-magnific-popup').html('<img src="'+file.getUrl()+'"/>');
                    $holder.find('.-magnific-popup').attr('href', file.getUrl());
                });
            }
        });
    });

    $(document).on('input', '.ck_finder .form-control', function () {
        let id = $(this).attr('id');
        let $holder = $(this).parents('.ck_finder').find('#holder-'+id);
        $holder.find('.-magnific-popup').html('<img src="'+$(this).val()+'"/>');
        $holder.find('.-magnific-popup').attr('href', $(this).val());
    });
}

function clearCache()
{
    $(document).on('click', '#clear_cache', function () {
        axios.get(Routing.generate('backend_command_index')).then(function (response) {
            if (response.data)
            {
                $.toast({
                    heading: 'Success',
                    text: 'Clear Cache',
                    icon: 'success',
                    position: 'top-right',
                    hideAfter: 7500
                })
            }
        });
    });
}

$(document).ready(function () {
    initMagnificPopup();
    initSelect2();
    sections();
    sweetalert();
    axiosLink();
    newCollection();
    ckFinderChoseMedia();
    deleteCollection();
    clearCache()
});
