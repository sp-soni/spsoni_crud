
function load_tables_modules(project_id, table_container, modules_container) {
    get_tables(project_id, table_container);
    get_modules(project_id, modules_container);
}

function get_modules(project_id, response_container) {
    $.ajax({
        url: API_BASE_URL + '?action=get_modules',
        type: 'POST',
        data: { project_id: project_id },
        success: function (response) {
            var html = '<option value="">-Select-</option>';
            for (var item in response) {
                row = response[item];
                console.log(response[item]);
                html += '<option value="' + row.id + '">' + row.module + '</option>';
            }
            $('#' + response_container).html(html);
        },
        error: function (error) {
            console.log(error)
        }
    });
}

function get_tables(project_id, response_container) {
    $.ajax({
        url: API_BASE_URL + '?action=get_tables',
        type: 'POST',
        data: { project_id: project_id },
        success: function (response) {
            var html = '<option value="">-Select-</option>';
            for (var item in response) {
                console.log(response[item]);
                html += '<option value="' + response[item] + '">' + response[item] + '</option>';
            }
            $('#' + response_container).html(html);
        },
        error: function (error) {
            console.log(error)
        }
    });
}


function copyDivToClipboard(div_id) {
    var range = document.createRange();
    range.selectNode(document.getElementById(div_id));
    window.getSelection().removeAllRanges(); // clear current selection
    window.getSelection().addRange(range); // to select text
    document.execCommand("copy");
    window.getSelection().removeAllRanges();// to deselect
    alert('Content copied to clipboard');
}
