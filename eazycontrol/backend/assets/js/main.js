function initSelect2() {
    $('select').select2();
}

function initMagnificPopup() {
    $('.-magnific-popup').magnificPopup({type:'image'});
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
        let href =  $(this).attr('href');
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

function changePageActive($element)
{
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

                        $('.row.ck_finder .ck_finder-col.ck_finder-input .form-control').each(function () {
                            let id = $(this).attr('id');
                            let $holder = $(this).parents('.row.ck_finder').find('#holder-'+id);
                            $holder.find('.-magnific-popup').html('<img src="'+$(this).val()+'"/>');
                            $holder.find('.-magnific-popup').attr('href', $(this).val());
                        });
                        initMagnificPopup();
                    });
                }
            });
        }
    });
}

function appendCollection(prototype, file) {
    let $collectionsList = $('.collections-card .collections-items');
    let index = $collectionsList.find('.collection').length
    prototype = prototype.replace(/__name__/g, index);
    prototype = prototype.replace(/_isActive_default"/g, '_isActive_default" checked ');
    if(file) {
        prototype = prototype.replace(/media_image/g, 'media_image" value="'+file);
    }
    $collectionsList.append(emptyCollection(prototype, index));
}

function emptyCollection(prototype, index) {
    return '' +
        '<li class="collection card">' +
        '<div class="card-header">' +
        '<h4 class="header-title" data-bs-toggle="collapse" data-bs-target="#collection-'+index+'" >New '+index+'</h4>' +

        '<div class="card-options">' +
        '<div class="option -collection-delete"><i class="fas fa-trash-alt"></i></div>' +
        '<div class="option"><i class="fas fa-sort"></i></div>' +
        '<div class="option option-toggle collapsed" data-bs-toggle="collapse" data-bs-target="#collection-'+index+'"><i class="option-icon fas fa-times" ></i></div>' +
        '</div>' +
        '</div>' +

        '<div  class="card-body" id="collection-'+index+'">' + prototype +'</div>' +
        '</li>';
}

$(document).ready(function () {
    initSelect2();
    sections();
    sweetalert();
    axiosLink();
    newCollection();
});