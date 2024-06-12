$(document).ready(function () {
    var form = $('#folder-form');
    var deleteBtn = $('#delete');
    var foldersList = $('#folders-list');

    form.on('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        var folderId = $('#folderId').val();
        var url = folderId ? 'update.php' : 'create.php';

        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                loadFolders();
                form[0].reset();
                $('#folderId').val('');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                handleError(jqXHR, textStatus, errorThrown, 'Error while saving the folder.');
            },
        });
    });

    deleteBtn.on('click', function () {
        var folderId = $('#folderId').val();
        if (folderId) {
            $.ajax({
                url: 'delete.php',
                method: 'POST',
                data: { folderId: folderId },
                success: function (response) {
                    loadFolders();
                    form[0].reset();
                    $('#folderId').val('');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    handleError(jqXHR, textStatus, errorThrown, 'Error while deleting the folder.');
                },
            });
        }
    });

    function loadFolders() {
        $.ajax({
            url: '../folders/read.php',
            method: 'GET',
            success: function (folders) {
                var html = '';
                folders.forEach(function (folder) {
                    html +=
                        '<div onclick="loadFolder(' +
                        folder.folderId +
                        ')">' +
                        folder.folderName +
                        '</div>';
                });
                foldersList.html(html);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                handleError(jqXHR, textStatus, errorThrown, 'Error while loading folders.');
            },
        });
    }

    loadFolders();

    window.loadFolder = function (folderId) {
        $.ajax({
            url: 'read.php',
            method: 'GET',
            data: { folderId: folderId },
            success: function (folder) {
                $('#folderId').val(folder.folderId);
                $('#userId').val(folder.userId);
                $('#folderName').val(folder.folderName);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                handleError(jqXHR, textStatus, errorThrown, 'Error while loading the folder.');
            },
        });
    };
});
