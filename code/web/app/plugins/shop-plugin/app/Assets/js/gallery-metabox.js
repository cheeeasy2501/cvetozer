let $ = jQuery
let media_uploader = null;
$(function () {
    $("#img_box_container").sortable();
});

/**
 * Remove image
 * @param value
 */
function removeImage(value) {
    let parent = $(value).parent().parent();
    parent.remove();
}

/**
 * Add media uploader on
 */
function openUploaderImages() {
    media_uploader = wp.media({
        frame: "post",
        state: "insert",
        multiple: true
    });
    media_uploader.on("insert", () => updateImages());
    media_uploader.open();
}

/**
 * Render added images
 */
function updateImages() {
    const images = media_uploader.state().get("selection").models;
    images.forEach(image => {
        const box = $('#master_box').html();
        $(box).appendTo('#img_box_container');
        const imageUrl = image.changed.url;
        const element = $('#img_box_container .gallery_single_row:last-child').find('.image_container');
        const html = '<img class="gallery_img_img" src="' + imageUrl + '" height="55" width="55" onclick="openUploaderImages(this)"/>';
        element.append(html);
        element.find('.meta_image_url').val(imageUrl);
    });
}