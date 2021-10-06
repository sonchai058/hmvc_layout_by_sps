<!-- <div class="main-container main-containerSBS">
        <div class="footer-wrap pd-20 card-box card-boxSBS">
            สำนักหอสมุดมหาวิทยาลัยเชียงใหม่
        </div>
    </div>
</div> -->
<script>
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.go-to-top').fadeIn();
            $('.bgBarHeader').css({
                'background-color': '#F17740'
            });
        } else {
            $('.go-to-top').fadeOut();
            $('.bgBarHeader').css({
                'background-color': '#F17740'
            });
        }
    })

    $(document).ready(function () {
        $("#validateForm").validationEngine();

        $(window).dblclick(function () {
            jQuery('#validateForm').validationEngine('hideAll');
        });

        $('.go-to-top').click(
            function (e) {
                $('html, body').animate({scrollTop: '0px'}, 500);
            }
        );
        
        if($('.tinymceEdit').length > 0) {
            tinymce.init({
                selector: ".tinymceEdit",
                width: '100%',
                height: 350,
                relative_urls: false,
                plugins: 'print preview paste importcss searchreplace autolink autosave save visualblocks visualchars fullscreen image link media table hr pagebreak nonbreaking toc advlist lists imagetools textpattern noneditable quickbars filemanager responsivefilemanager code',
                toolbar: 'undo redo |  bold italic underline strikethrough |  alignleft aligncenter alignright alignjustify numlist bullist |  forecolor backcolor outdent indent |  removeformat link responsivefilemanager image imagetools media preview print code fullscreen ',
                // fontsize_formats: "1pt 2pt 3pt 4pt 5pt 6pt 7pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 17pt 18pt 19pt 20pt 22pt 24pt 28pt 32pt 36pt 40pt 44pt 48pt 52pt 56pt 60pt 64pt 68pt 72pt 96pt",
                // font_formats: 'Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats',
                image_advtab: true,
                importcss_append: true,
                image_caption: true,
                filemanager_title: "อัพโหลดไฟล์",
                // color_map: [
                //     "ffffff", "WHITE",
                //     "ced4d9", "GRAY",
                //     "7e8c8d", "LightDarkGray",
                //     "4e586d", "DarkGray",
                //     "e3e3e3", "CreamColor",
                //     "f6f6f6", "LightGray",
                //     "cdd79d", "OliveGreen",
                //     "212629", "BackLight",
                //     "000000", "BackLight",
                // ],
                custom_colors: false,
                external_filemanager_path: "<?= STATIC_PATH . 'scripts/tinymce/filemanager/'?>",
                external_plugins: {
                  "responsivefilemanager": "<?= STATIC_PATH . 'scripts/tinymce/plugins/responsivefilemanager/plugin.min.js'?>",
                  "filemanager": "<?= STATIC_PATH . 'scripts/tinymce/filemanager/plugin.min.js'?>"
                },
                audio_template_callback: function (data) {
                  return '<audio controls>' + '\n<source src="' + data.source + '"' + (data.sourcemime ? ' type="' + data.sourcemime + '"' : '') + ' />\n' + '</audio>';
                },
                video_template_callback: function (data) {
                  return '<video width="' + data.width + '" height="' + data.height + '"' + (data.poster ? ' poster="' + data.poster + '"' : '') + ' controls="controls">\n' + '<source src="' + data.source + '"' + (data.sourcemime ? ' type="' + data.sourcemime + '"' : '') + ' />\n' + (data.source2 ? '<source src="' + data.source2 + '"' + (data.source2mime ? ' type="' + data.sourcemime + '"' : '') + ' />\n' : '') + '</video>';
                },
                quickbars_insert_toolbar: 'responsivefilemanager image quicktable',
                quickbars_selection_toolbar: 'fontsizeselect | bold italic underline strikethrough | responsivefilemanager image quicktable',
                noneditable_noneditable_class: "mceNonEditable",
                toolbar_mode: 'sliding',
                contextmenu: "link responsivefilemanager image table",
                forced_root_block: false,
                // object_resizing : ":not(table)",
                allow_script_urls:true,
                remove_script_host: false,
                valid_elements : '*[*]',
                inline_styles : true,
                table_sizing_mode: 'fixed',
                table_default_styles: {
                  width: '100%'
                },
                width: '970px',
                paste_remove_styles_if_webkit : false,
                paste_preprocess : function(pl, o)
                {
                  o.content = o.content.replace("text-decoration-style: initial; text-decoration-color: initial; width: 868px;", "text-decoration-style: initial; text-decoration-color: initial; width: 100%;");;
                  o.wordContent = true;
                },
                plugin_preview_width: 200,
                content_css: "<?= LAYOUT_PATH . 'styles/mainStyle.css'?>",
            });

            setTimeout(function(){
                $('.tinymceEdit').css('opacity',1);
            }, 1000);
        }
    });
</script>


</body>
</html>
