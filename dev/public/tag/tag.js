$(document).ready(function () {
    var form = $('#tag-form');
    var deleteBtn = $('#delete');
    var tagsList = $('#tags-list');

    form.on('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        var tagId = $('#tagId').val();
        var url = tagId ? 'update.php' : 'create.php';

        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                loadTags();
                form[0].reset();
                $('#tagId').val('');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                handleError(jqXHR, textStatus, errorThrown, "Error while saving the tag.");
            }
        });
    });

    deleteBtn.on('click', function () {
        var tagId = $('#tagId').val();
        if (tagId) {
            $.ajax({
                url: 'delete.php',
                method: 'POST',
                data: { tagId: tagId },
                success: function(response) {
                    loadTags();
                    form[0].reset();
                    $('#tagId').val('');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    handleError(jqXHR, textStatus, errorThrown, "Error while deleting the tag.");
                }
            });
        }
    });

    function loadTags() {
        $.ajax({
            url: '../tags/read.php',
            method: 'GET',
            success: function(tags) {
                var html = '';
                tags.forEach(function (tag) {
                    html += '<div onclick="loadTag(' + tag.tagId + ')">' + tag.tagName + '</div>';
                });
                tagsList.html(html);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                handleError(jqXHR, textStatus, errorThrown, "Error while loading tags.");
            }
        });
    }

    loadTags();

    window.loadTag = function (tagId) {
        $.ajax({
            url: 'read.php',
            method: 'GET',
            data: { tagId: tagId },
            success: function(tag) {
                $('#tagId').val(tag.tagId);
                $('#userId').val(tag.userId);
                $('#tagName').val(tag.tagName);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                handleError(jqXHR, textStatus, errorThrown, "Error while loading the tag.");
            }
        });
    }
});

