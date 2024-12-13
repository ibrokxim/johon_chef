let uploadUrl = document.querySelector('meta[name="upload-url"]').getAttribute('content');

function summernote() {
        tinyMCE.init({
            selector: "textarea.summernote",
            height: 300,
            branding: false,
            plugins: [
                "media advlist autolink lists image link paste",
                "visualchars noneditable visualblocks",
                "code fullscreen charmap nonbreaking template emoticons charmap",
            ],
            menubar: false,
            formats: {
                strikethrough: { inline: 's' }  // Настройка для использования тега <s> вместо стилей
            },
            inline_styles: false,
            // Вставляемый только текст
            paste_as_text: false,
            // Удаляем все инлайн стили
            paste_remove_styles_if_webkit: true,
            paste_remove_styles: true,
            toolbar_items_size: 'small',
            toolbar: "formatselect | bold italic underline strikethrough | link unlink | fullscreen code removeformat | image | charmap | emoticons",  //emoticons visualblocks visualchars
            // charmap: [
            //     [0x00AB, 'left-pointing double angle quotation mark «'],
            //     [0x00BB, 'right-pointing double angle quotation mark »']
            // ],
            block_formats: 'Paragraph=p;',
            statusbar: false,
            // Если для этого параметра установлено значение true, все URL-адреса, возвращаемые MCFileManager, будут относительными от указанного document_base_url. Если установлено значение false, все URL-адреса будут преобразованы в абсолютные URL-адреса.
            relative_urls: false,
            // Valid all elements, attributes
            // valid_elements: '*[*]',
            // Valid elements for list
            // valid_elements: 'h1,h2,h3,p,b,strong,i,em,iframe[],span[style],a[href|target],ul,ol,li',
            // valid_elements: 'div[class=blockquote__top|blockquote__image|blockquote__info|blockquote__cite|blockquote__text|blockquote__content],*[*]', // разрешаем только div с указанными классами, остальные элементы с любыми атрибутами
            // invalid_elements: 'div',
            language: "ru",
            /* Замена тега P на BR при разбивке на абзацы */
            force_br_newlines: true,
            force_p_newlines: false,
            forced_root_block: '',
            // уберает ширину и высоту у картинок
            image_dimensions: false,
            media_dimensions: true,
            media_poster: false,
            mobile: {
                theme: 'silver',
                menubar: false,
                height: 500,
                width: 344,
                statusbar: false,
            },
            setup: function (editor) {
                // Проверяем, что formatter доступен
                editor.on('init', function () {
                    // Регистрируем кастомный формат
                    editor.formatter.register('imageTextFormat', {
                        inline: 'span',
                        classes: 'image-text'
                    });
                });
            },
            content_style: "img { width: 100% !important; height: auto !important; } .image-text {display: block; margin-top: -.5em; font-size: calc(max(.75em, 12px)); text-align: right; color: gray;}",
            images_upload_handler: function (blobInfo, success, failure) {
                let formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());

                // Check if the checkbox is checked and add the extra parameter to the form data
                let in_watermark = document.getElementById('watermark');
                if (in_watermark.checked) {
                    formData.append("watermark", document.querySelector('#watermark').checked ? 1 : 0);
                }

                $.ajax({
                    url: uploadUrl,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf"]').getAttribute('content')
                    },
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        success(response.location);
                    },
                    error: function (xhr, status, error) {
                        failure('HTTP Error: ' + xhr.status);
                    }
                });
            },
            // file_picker_callback : function(callback, value, meta) {
            //     var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
            //     var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;
            //
            //     var cmsURL = '/admin/' + 'filemanager?editor=' + meta.fieldname;
            //     if (meta.filetype == 'image') {
            //         cmsURL = cmsURL + "&type=Images";
            //     } else {
            //         cmsURL = cmsURL + "&type=Files";
            //     }
            //
            //     tinyMCE.activeEditor.windowManager.openUrl({
            //         url : cmsURL,
            //         title : 'Filemanager',
            //         width : x * 0.8,
            //         height : y * 0.8,
            //         resizable : "yes",
            //         close_previous : "no",
            //         onMessage: (api, message) => {
            //             callback(message.content);
            //         }
            //     });
            // },
            templates: [
                {
                    title: 'Новостной блок',
                    description: '',
                    content: `
                    <div class="anons">
                      <div class="anons-top">
                        <span class="anons-top__subtitle">Статья по теме</span>
                        <strong class="anons-top__title">В столице состоялось открытие Ташкентского международного кинофестиваля</strong>
                      </div>
                      <blockquote class="anons-blockquote blockquote">
                        <div class="blockquote__top">
                          <div class="blockquote__image">
                              <img src="/assets/img/news/inner/image-03.jpg" width="200" alt="">
                          </div>
                          <div class="blockquote__info">
                            <cite class="blockquote__cite">Егор Лапатин</cite>
                            <span class="blockquote__text">Журналист Uznews</span>
                          </div>
                        </div>
                        <div class="blockquote__content">
                          <p>Вместе с тем, мы постоянно внедряем новейшие технологии и инновации, чтобы гарантировать вашу безопасность на самом высоком уровне.</p>
                          <p>Мы инвестируем в системы контроля, автоматизации и мониторинга, чтобы убедиться, что каждый поезд нашего отделения работает с безупречной точностью и безопасностью</p>
                        </div>
                      </blockquote>
                    </div>
                    <p>Дополнительный текст</p>
                    `
                },
            ],
        });
}

function cleanContent(content) {
    var div = document.createElement('div');
    div.innerHTML = content;

    // Remove all style attributes
    var elements = div.querySelectorAll('*');
    elements.forEach(function (element) {
        element.removeAttribute('style');
    });

    // Remove unwanted tags
    var unwantedTags = ['span'];
    unwantedTags.forEach(function (tag) {
        var tags = div.getElementsByTagName(tag);
        while (tags[0]) {
            tags[0].parentNode.removeChild(tags[0]);
        }
    });

    return div.innerHTML;
}


let toTranslit = function(text) {
    return text.replace(/([а-яё])|([\s_-])|([^a-z\d])/gi,
        function(all, ch, space, words, i) {
            if (space || words) {
                return space ? '-' : '';
            }
            let code = ch.charCodeAt(0),
                index = code == 1025 || code == 1105 ? 0 :
                    code > 1071 ? code - 1071 : code - 1039,
                t = ['yo', 'a', 'b', 'v', 'g', 'd', 'e', 'zh',
                    'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p',
                    'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh',
                    'shch', '', 'y', '', 'e', 'yu', 'ya'
                ];
            return t[index];
        }).toLowerCase();
};

$(document).ready(function() {
    $("#name").on("keyup input", function(e) {
        $("#slug").val(toTranslit($("#name").val()));
        $("#meta_title_ru").val($("#name").val());
    });
});

$(document).ready(function() {
    $("#question_name").on("keyup", function(e) {
        $("#question_slug").val(toTranslit($("#question_name").val()));
    });
});

//Sort element
function sortElem(elem, url) {
    const csrf = document.querySelector('[name="csrf"]').content;
    $(elem).sortable({
        items: "> tr",
        opacity: 0.5,
        revert: true,
        scroll: true,
        tolerance: "pointer",
        handle: ".move_zone",
        scrollSensitivity: 50,
        scrollSpeed: 50,
        cursor: "move",
        connectWith: '.sections_list',
        placeholder: "ui-sortable-handle",
        update: function(event, ui) {
            let sections = [];

            $(`${elem} tr`).each(function() {
                sections.push($(this).attr("data-id"));
            });
            $.ajax({
                url: url,
                method:"POST",
                data:{ sectionIds: sections, _token: csrf, action: 'sort'},
                success:function(data) {
                    $("#section").load(`#sections ${elem} > tr`);
                }
            });
        }
    }).disableSelection();
}

// sortElem('#block_list','/admin/sections/update/sort');


// append elements block
function appElement(locale, content) {
    let parent = document.getElementById(content);
    let countElements = parent.querySelectorAll('.elements');
    let lastElement;

    if(countElements.length > 0) {
        lastElement = countElements[countElements.length - 1].dataset.key * 1 + 1;
    } else {
        lastElement = 0;
    }


    $(`#`+content).append(`
        <div class="elements" style="position: relative;border-top: 2px solid rgb(40, 167, 69);padding: 5px;border-radius: 5px;" data-key="${lastElement}">
        <div class="btn btn-danger" style="position: absolute; right: 0; z-index: 99;" onmouseover="$(this).parent().css('z-index',2);$(this).parents().eq(0).find('.deleteOverlay').show();" onmouseout="$(this).parent().css('z-index','');$(this).parents().eq(0).find('.deleteOverlay').hide();" onclick="removeElement(this)">Удалить</div>
            <div class="form-group">
                <label for="title">Заголовок</label>
                <input type="text" class="form-control" name="markup[${locale}][elements][${lastElement}][title]" placeholder="Заголовок" value="">
            </div>
            <div class="form-group">
                <label for="description">Описание</label>
                <textarea id="description" class="form-control summernote" name="markup[${locale}][elements][${lastElement}][description]"></textarea>
            </div>
            <div class="deleteOverlay" style="display: none;"></div>
        </div>
        `);



    tinyMCE.remove();

    summernote();
}



// append questions block
function appQuestion() {
    $('#questions').append(`
        <div class="elements" style="position: relative;">
        <div class="btn btn-danger" style="position: absolute; right: 0; z-index: 99;" onmouseover="$(this).parent().css('z-index',2);$(this).parents().eq(0).find('.deleteOverlay').show();" onmouseout="$(this).parent().css('z-index','');$(this).parents().eq(0).find('.deleteOverlay').hide();" onclick="removeElement(this)">Удалить</div>
            <div class="form-group">
                <label for="title">Вопрос</label>
                <input type="text" class="form-control" name="title" placeholder="Заголовок" value="">
            </div>
            <div class="form-group">
                <label for="description">Описание</label>
                <textarea id="description" class="form-control summernote" name="description"></textarea>
            </div>
            <div class="deleteOverlay" style="display: none;"></div>
        </div>
        `);

    tinyMCE.remove();
    summernote();
}

function removeElement(elem) {
    elem.parentElement.remove();
}

// accordion block generate json
// function save() {
//     let cats = [];
//
//     document.querySelectorAll('.elements').forEach((el) => {
//         let questions = {};
//         questions['title'] = el.querySelector('[name="title"]').value;
//         questions['description'] = el.querySelector('[name="description"]').value;
//         cats.push(questions);
//     });
//
//     let connect = document.querySelector('[name="connect"]');
//     connect.value = JSON.stringify(cats);
// }


//remove images
// $('.card-body').on('click', '.del-img', function () {
//     $(this).closest('.product-img-upload').empty();
//     $('#thumbnail').val('');
//     return false;
// });

// function removeGallery(elem, slider = false) {
//     const csrf = document.querySelector('[name="csrf"]').content;
//     // let images = document.getElementById('gallery-img-output');
//     // let thumbnail = document.getElementById('thumbnail');
//     let thumbnail = document.getElementById('filepath');
//     let url = elem.parentNode.dataset.delete ?? null;
//
//     // let data_id = elem.closest('.product-img-upload').dataset.id;
//     // let data_orig = elem.closest('.product-img-upload').dataset.orig;
//
//     // Эта реализация для доп элементов после основного (например модалки)
//     if(slider && elem.parentNode.nextElementSibling) {
//         elem.parentNode.nextElementSibling.remove();
//     }
//
//     elem.closest('.product-img-upload').remove();
//
//     if(thumbnail) {
//         thumbnail.value = '';
//         let images = document.querySelectorAll('.product-img-upload');
//         thumbnail.value = Array.from(images).map(function (item) {
//             return item.dataset.orig;
//         }).join(',');
//     }
//
//     if (url) {
//         $.ajax({
//             url: `${url}`,
//             method:"POST",
//             data:{_token: csrf},
//             success:function(result) {
//                 console.log(result);
//             }
//         });
//     }
//
// }

// change status
// function changeStatus(id, url) {
//     const csrf = document.querySelector('[name="csrf"]').content;
//     let choiceVal = $('.status_selection#'+id).attr('value');
//     console.log(choiceVal)
//
//     $.post(url, { id: id, _token: csrf, choice: choiceVal, action: 'status' }, function(data){
//         if (data.choice === 1){
//             $('.status_selection#'+id).attr('value', data.choice);
//             $('.status_selection#'+id+' span').attr('class', 'fa fa-eye');
//         } else {
//             $('.status_selection#'+id).attr('value', data.choice);
//             $('.status_selection#'+id+' span').attr('class', 'fa fa-eye-slash');
//         }
//     }, 'json');
// }

function changeStatus(id, url) {
    const csrf = document.querySelector('[name="csrf"]').content;
    let choiceVal = $('.status_selection[data-id="'+id+'"]').data('value');
    console.log(choiceVal);

    $.post(url, { id: id, _token: csrf, choice: choiceVal, action: 'status' }, function(data){
        if (data.choice === 1){
            $('.status_selection[data-id="'+id+'"]').data('value', data.choice);
            $('.status_selection[data-id="'+id+'"] span').attr('class', 'fa fa-eye');
        } else {
            $('.status_selection[data-id="'+id+'"]').data('value', data.choice);
            $('.status_selection[data-id="'+id+'"] span').attr('class', 'fa fa-eye-slash');
        }
    }, 'json');
}

// change status
function changeFavorite(id, url) {
    const csrf = document.querySelector('[name="csrf"]').content;
    let choiceVal = $('.favorite_selection#'+id).attr('value');

    $.post(url, { id: id, _token: csrf, choice: choiceVal, action: 'favorite' }, function(data){
        if (data.choice === 1){
            $('.favorite_selection#'+id).attr('value', data.choice);
            $('.favorite_selection#'+id+' span').css('color', '#d7d756');
        } else {
            $('.favorite_selection#'+id).attr('value', data.choice);
            $('.favorite_selection#'+id+' span').css('color', '');
        }
    }, 'json');
}

//blocks general image add
// function popupBaseImage(elem = null) {
//     CKFinder.modal( {
//         chooseFiles: true,
//         onInit: function( finder ) {
//             finder.on( 'files:choose', function( evt ) {
//                 let file = evt.data.files.first();
//
//                 let baseImgOutput = document.getElementById( 'base-img-output' );
//
//                 // if (elem) {
//                 //     baseImgOutput = elem.previousElementSibling;
//                 // }
//
//                 baseImgOutput.innerHTML = '<div class="product-img-upload"><img src="' + baseUrl + file.getUrl() + '"><input type="hidden" name="images" value="' + file.getUrl() + '"><button class="del-img btn btn-app bg-danger"><i class="far fa-trash-alt"></i></button></div>';
//             } );
//             finder.on( 'file:choose:resizedImage', function( evt ) {
//                 const baseImgOutput = document.getElementById( 'base-img-output' );
//                 baseImgOutput.innerHTML = '<div class="product-img-upload"><img src="' + baseUrl + evt.data.resizedUrl + '"><input type="hidden" name="images" value="' + evt.data.resizedUrl + '"><button class="del-img btn btn-app bg-danger"><i class="far fa-trash-alt"></i></button></div>';
//             } );
//         }
//     } );
// }


//blocks gallerys add
// function popupGalleryImage() {
//     CKFinder.modal( {
//         chooseFiles: true,
//         onInit: function( finder ) {
//             finder.on( 'files:choose', function( evt ) {
//                 let files = evt.data.files;
//                 const galleryImgOutput = document.getElementById( 'gallery-img-output' );
//
//                 let num = 0;
//                 if (document.querySelector('.product-img-upload')) {
//                     if (galleryImgOutput.lastElementChild) {
//                         num = galleryImgOutput.lastElementChild.dataset.id * 1 + 1;
//                     }
//                 }
//                 // вывод языковых элементов инпут - textarea
//                 files.forEach( ( node, index ) => {
//                     if (galleryImgOutput.innerHTML) {
//                         galleryImgOutput.innerHTML += '<div class="product-img-upload" data-id="'+(num + index)+'"><img src="' + baseUrl + node.getUrl() + '"><input type="hidden"  name="gallery['+(num + index)+'][fileName]" value="' + node.getUrl() + '"><button class="del-img btn btn-app bg-danger" type="button" onclick="removeGallery(this)"><i class="far fa-trash-alt"></i></button></div>';
//                     } else {
//                         galleryImgOutput.innerHTML = '<div class="product-img-upload" data-id="'+(num + index)+'"><img src="' + baseUrl + node.getUrl() + '"><input type="hidden" name="gallery['+(num + index)+'][fileName]" value="' + node.getUrl() + '"><button class="del-img btn btn-app bg-danger" type="button" onclick="removeGallery(this)"><i class="far fa-trash-alt"></i></button></div>';
//                     }
//                 });
//
//             } );
//             finder.on( 'file:choose:resizedImage', function( evt ) {
//                 const baseImgOutput = document.getElementById( 'base-img-output' );
//
//                 files.forEach( ( node, index ) => {
//                     if (baseImgOutput.innerHTML) {
//                         baseImgOutput.innerHTML += '<div class="product-img-upload" data-id="'+(num + index)+'"><img src="' + baseUrl + node.getUrl() + '"><input type="hidden" name="gallery['+(num + index)+'][fileName]" value="' + node.getUrl() + '"><input type="text" class="form-control" name="'+(num + index)+'" placeholder="Заголовок"><textarea style="height: 150px" class="form-control" name="gallery['+(num + index)+'][description]" placeholder="Описание"></textarea><button class="del-img btn btn-app bg-danger"><i class="far fa-trash-alt"></i></button></div>';
//                     } else {
//                         baseImgOutput.innerHTML = '<div class="product-img-upload" data-id="'+(num + index)+'"><img src="' + baseUrl + node.getUrl() + '"><input type="hidden" name="gallery['+(num + index)+'][fileName]" value="' + node.getUrl() + '"><input type="text" class="form-control" name="gallery['+(num + index)+'][name]" placeholder="Заголовок"><textarea style="height: 150px" class="form-control" name="gallery['+(num + index)+'][description]" placeholder="Описание"></textarea><button class="del-img btn btn-app bg-danger"><i class="far fa-trash-alt"></i></button></div>';
//                     }
//                 });
//
//
//             } );
//         }
//     } );
// }

// initialization summernote
summernote();


// function tabsGalleryImage(elem) {
//     CKFinder.modal( {
//         chooseFiles: true,
//         onInit: function( finder ) {
//             finder.on( 'files:choose', function( evt ) {
//                 let files = evt.data.files;
//                 const galleryImgOutput = elem.nextElementSibling;
//
//                 let num = 0;
//                 if (document.querySelector('.product-img-upload')) {
//                     if (galleryImgOutput.lastElementChild) {
//                         num = galleryImgOutput.lastElementChild.dataset.id * 1 + 1;
//                     }
//                 }
//                 // вывод языковых элементов инпут - textarea
//                 files.forEach( ( node, index ) => {
//                     if (galleryImgOutput.innerHTML) {
//                         galleryImgOutput.innerHTML += '<div class="product-img-upload" data-id="'+(num + index)+'"><img src="' + baseUrl + node.getUrl() + '"><input type="hidden"  name="gallery['+(num + index)+'][fileName]" value="' + node.getUrl() + '" id="image"><input type="text" class="form-control mt-2" name="gallery['+(num + index)+'][name]" placeholder="Заголовок" id="image_title"><button class="del-img btn btn-app bg-danger" type="button" onclick="removeGallery(this)"><i class="far fa-trash-alt"></i></button></div>';
//                     } else {
//                         galleryImgOutput.innerHTML = '<div class="product-img-upload" data-id="'+(num + index)+'"><img src="' + baseUrl + node.getUrl() + '"><input type="hidden" name="gallery['+(num + index)+'][fileName]" value="' + node.getUrl() + '" id="image"><input type="text" class="form-control mt-2" name="gallery['+(num + index)+'][name]" placeholder="Заголовок" id="image_title"><button class="del-img btn btn-app bg-danger" type="button" onclick="removeGallery(this)"><i class="far fa-trash-alt"></i></button></div>';
//                     }
//                 });
//
//             } );
//             finder.on( 'file:choose:resizedImage', function( evt ) {
//                 const baseImgOutput = document.getElementById( 'base-img-output' );
//
//                 files.forEach( ( node, index ) => {
//                     if (baseImgOutput.innerHTML) {
//                         baseImgOutput.innerHTML += '<div class="product-img-upload" data-id="'+(num + index)+'"><img src="' + baseUrl + node.getUrl() + '"><input type="hidden" name="gallery['+(num + index)+'][fileName]" value="' + node.getUrl() + '" id="image"><input type="text" class="form-control mt-2" name="'+(num + index)+'" placeholder="Заголовок" id="image_title"><button class="del-img btn btn-app bg-danger"><i class="far fa-trash-alt"></i></button></div>';
//                     } else {
//                         baseImgOutput.innerHTML = '<div class="product-img-upload" data-id="'+(num + index)+'"><img src="' + baseUrl + node.getUrl() + '"><input type="hidden" name="gallery['+(num + index)+'][fileName]" value="' + node.getUrl() + '" id="image"><input type="text" class="form-control mt-2" name="gallery['+(num + index)+'][name]" placeholder="Заголовок" id="image_title"><button class="del-img btn btn-app bg-danger"><i class="far fa-trash-alt"></i></button></div>';
//                     }
//                 });
//
//             } );
//         }
//     } );
// }



// append tabs
// onclick="addContent(this)"
function appTabs() {

    let elements = document.querySelectorAll('.elements_tabs');

    $('#tabs').append(`
        <div class="elements_tabs mb-4 col-md-4">
            <div class="btn btn-danger" onmouseover="$(this).parent().css('z-index',2);$(this).parents().eq(0).find('.deleteOverlay').show();" onmouseout="$(this).parent().css('z-index','');$(this).parents().eq(0).find('.deleteOverlay').hide();" onclick="removeElement(this)" id="deleteTabs">Удалить</div>
            <div class="form-group mb-2">
                <label for="title">Заголовок блока ru</label>
                <input type="text" class="form-control" name="title_ru" >

                <label for="title">Заголовок блока uz</label>
                <input type="text" class="form-control" name="title_uz" >

                <label for="title">Заголовок блока en</label>
                <input type="text" class="form-control" name="title_en" >

                <div class="btn btn-success mt-2" data-toggle="modal" onclick="changeItem(this)" data-target="#exampleModalCenter" data-block="${elements.length + 1}">
                <span>Добавить вопрос</span>
                <i class="fa fa-plus"></i>
                </div>

                <div id="contentTabs">
                <div class="card-body table-responsive p-0 pt-4 pb-4">
                    <table class="table table-hover text-nowrap">
                        <tbody class="selectable-demo-list sections_list" data-step="${elements.length + 1}" id="question_list">
                        </tbody>
                    </table>
                </div>
                <div class="deleteOverlay"></div>

            </div>
        </div>

    `);

}





// append content
// function addContent(elem) {
//     let contentTabs = elem.nextElementSibling;
//
//     $(contentTabs).append(`
//         <div class="form-group ml-3 mt-3 class-el" style="position: relative">
//
//             <label for="title">Класс</label>
//             <input type="text" class="form-control" name="class_title" placeholder="Экономический класс.." >
//             <div class="btn btn-danger" onmouseover="$(this).parent().css('z-index',2);$(this).parents().eq(0).find('.deleteOverlay').show();" onmouseout="$(this).parent().css('z-index','');$(this).parents().eq(0).find('.deleteOverlay').hide();" onclick="removeElement(this)" id="deleteTabs">Удалить</div>
//
//             <div class="form-group mt-3">
//                 <div class="col-md-12">
//                     <div class="card card-outline card-success">
//                         <div class="card-header">
//                             <h3 class="card-title">Изображения</h3>
//                         </div>
//                         <div class="card-body">
//                             <button class="btn btn-success" type="button" id="add-gallery-img" onclick="tabsGalleryImage(this); return false;">Загрузить</button>
//                             <div id="gallery-img-output" class="upload-images gallery-image"></div>
//                         </div>
//                     </div>
//                 </div>
//             </div>
//             <div class="deleteOverlay"></div>
//
//         </div>
//     `);
// }



// tabs block generate json
// function saveTabs() {
//     let cats = [];
//     if (document.querySelector('.elements_tabs')) {
//         document.querySelectorAll('.elements_tabs').forEach((el) => {
//             let content = [];
//             if (el.querySelector('[name="flight_title"]').value !== '') {
//                 let tabs = {};
//                 tabs['title'] = el.querySelector('[name="flight_title"]').value;
//             if (el.querySelector('.class-el')) {
//                 el.querySelectorAll('.class-el').forEach((conTabs) => {
//
//                     let contentEl = {};
//                     let images = [];
//
//                     if (conTabs.querySelector('[name="class_title"]').value !== '') {
//                         contentEl['title'] = conTabs.querySelector('[name="class_title"]').value;
//
//                         if (conTabs.querySelector('.product-img-upload')) {
//
//                             conTabs.querySelectorAll('.product-img-upload').forEach((productImg) => {
//
//                                 let image = {}
//                                 if (productImg.querySelector('#image_title').value !== '') {
//                                     image['title'] = productImg.querySelector('#image_title').value;
//                                     image['image'] = productImg.querySelector('#image').value;
//                                     images.push(image);
//                                 }
//                             });
//                             contentEl['images'] = images;
//                         }
//                         content.push(contentEl);
//                         tabs['content'] = content;
//                     }
//                 });
//             }
//             cats.push(tabs);
//             }
//         });
//     }
//
//     let connect = document.querySelector('[name="connect"]');
//     connect.value = JSON.stringify(cats);
// }



// // footer dynamic
// $(init);
// function init() {
//     $( ".droppable-category, .droppable-area-1, .droppable-area-2" ).sortable({
//         connectWith: ".connected-sortable",
//         stack: '.connected-sortable ul'
//     }).disableSelection();
// }

// Footer dynamic menu
// function saveFooterMenu() {
//     let cats = [];
//     let menuLeft = [];
//     let menuRight = [];
//
//     let menuItems1 = document.querySelector('.droppable-area-1');
//     let menuItems2 = document.querySelector('.droppable-area-2');
//
//
//     if (menuItems1.childNodes.length) {
//         menuItems1.childNodes.forEach((elem, index) => {
//             let items = {}
//
//             items['sectionId'] = elem.dataset.id;
//
//             menuLeft.push(items);
//         });
//
//         cats.push(menuLeft)
//     }
//
//     if (menuItems2.childNodes.length) {
//         menuItems2.childNodes.forEach((elem, index) => {
//             let items = {}
//
//             items['sectionId'] = elem.dataset.id;
//
//             menuRight.push(items);
//         });
//
//         cats.push(menuRight);
//     }
//
//     document.querySelector('[name="connect"]').value = JSON.stringify(cats);
// }


// Phone mask
let phone = document.getElementById("phone");
let phone_dop = document.getElementById("phone_dop");

if (phone || phone_dop) {
    Inputmask({"mask": "+999(99) 999-99-99"}).mask(phone);
    // Inputmask({"mask": "+999(99) 999-99-99"}).mask(phone_dop);
}

// Js custom select
$(document).ready(function() {
    $('.js-select').select2({
        minimumResultsForSearch: -1,
        placeholder: 'Выберете..',
        allowClear: true,
        // closeOnSelect: false,
        language: {
            noResults: function() {
                return 'Ничего не найдено';
            }
        }
    });
});



// alert success
function success(action = 'success') {
    let _container;

    function success(message, title, options) {
        return alert(action, message, title, action === 'success' ? "fa fa-check-circle" : "fa fa-exclamation-circle", options);
    }

    function alert(type, message, title, icon, options) {
        let alertElem, messageElem, titleElem, iconElem, innerElem;
        if (typeof options === "undefined") {
            options = {};
        }
        options = $.extend({}, success.defaults, options);
        if (!_container) {
            _container = $("#alerts");
            if (_container.length === 0) {
                _container = $("<ul>").attr("id", "alerts").appendTo($("body"));
            }
        }
        if (options.width) {
            _container.css({
                width: options.width
            });
        }
        alertElem = $("<li>")
            .addClass("alert")
            .addClass("alert-" + type);
        setTimeout(function () {
            alertElem.addClass("open");
        }, 1);
        if (icon) {
            iconElem = $("<i>").addClass(icon);
            alertElem.append(iconElem);
        }
        innerElem = $("<div>").addClass("alert-block");
        alertElem.append(innerElem);
        if (title) {
            titleElem = $("<div>").addClass("alert-title").append(title);
            innerElem.append(titleElem);
        }
        if (message) {
            messageElem = $("<div>").addClass("alert-message").append(message);
            innerElem.append(messageElem);
        }
        if (options.displayDuration > 0) {
            setTimeout(function () {
                leave();
            }, options.displayDuration);
        } else {
            innerElem.append("<em>Click to Dismiss</em>");
        }
        alertElem.on("click", function () {
            leave();
        });

        function leave() {
            alertElem.removeClass("open");
            alertElem.one(
                "webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend",
                function () {
                    return alertElem.remove();
                }
            );
        }
        return _container.prepend(alertElem);
    }

    return {
        success: success,
        defaults: {
            width: "",
            icon: "",
            displayDuration: 3000,
            pos: ""
        }
    };
}

let _event = document.querySelector('#events');
if (_event) {
    success(_event.dataset?.action).success(_event.dataset.message, _event.dataset.action === 'success' ? 'Успешно' : 'Ошибка', { displayDuration: 3000, pos: 'top' });
}