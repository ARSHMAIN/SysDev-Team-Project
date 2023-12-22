$(document).ready(function () {
    $("#copy").click(function () {
        var space = $("#table");
        var item = $("#item"); // TODO: add specific data id later so it actually duplicates the right one
        item.clone().appendTo(space);
    });

    $("#delete").click(function () {
        var space = $("#table");
        var item = $("#item");
        space.remove(item);
    });
});
