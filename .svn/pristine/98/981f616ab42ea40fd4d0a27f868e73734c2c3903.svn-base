tinymce.PluginManager.add('sbssode', function (editor, url) {


    function audio(a_url) {

        var str = '<audio controls>';
        str += '<source src="' + a_url + '" type="audio/mpeg">'
        str += '</audio>';

        return str;
    }

    function video(v_url) {

        var str = '<video width="320" height="240" controls>';
        str += '<source src="' + v_url + '" type="video/mp4">'
        str += '</video>';

        return str;
    }


    editor.addMenuItem('sbssode', {
        text: 'Insert Media',
        icon: 'media',
        context: 'insert',
        onclick: function () {
            editor.windowManager.open({
                title: 'Insert Media URL',
                body: [
                    {type: 'textbox', name: 'url', label: 'URL', size: 40},
                    {type: 'textbox', name: 'embed', label: 'Embed', flex: 1, multiline: !0}
                ],
                onsubmit: function (e) {

                    if (e.data.url != '') {

                        var arr = e.data.url.split('.');
                        var ext = arr[arr.length - 1];

                        var media = ''
                        if (ext == 'mp3') {
                            media = audio(e.data.url);
                        } else if (ext == 'mp4') {
                            media = video(e.data.url);
                        }


                        if (media != '') {
                            editor.insertContent('<p>' + media + '</p>');
                        } else {
                            alert('File type not support');
                        }
                    }

                    if(e.data.embed != ''){
                        editor.insertContent('<p>' + e.data.embed + '</p>');
                    }


                }
            });
        }
    });
});