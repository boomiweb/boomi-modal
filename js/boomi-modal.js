/* global boomiModalObject */

(function() {
    var
        method = {},
        $overlay,
        $modal,
        $content,
        $close,
        $spinner;

    // Center the modal in the viewport
    method.center = function() {
        var top, left;

        top = Math.max(jQuery(window).height() - $modal.outerHeight(), 0) / 2;
        left = Math.max(jQuery(window).width() - $modal.outerWidth(), 0) / 2;

        $modal.css({
            top: top + jQuery(window).scrollTop(),
            left: left + jQuery(window).scrollLeft()
        });
    };

    // Open the modal.
    method.open = function(options) {
        var settings = jQuery.extend({
            content: '',
            width: '100%',
            height: 'auto',
            classes: '',
            type: '',
            url: ''
        }, options);

        $overlay.show();
        $spinner.show();

        method.getContent(settings, function(content) {
            $content.empty().append(content);

            $modal.css({
                width: settings.width,
                height: settings.height
            });

            method.center();

            jQuery(window).bind('resize.modal', method.center);

            $modal.addClass(settings.classes);

            $spinner.hide();

            $modal.show();
        });
    };

    method.getContent = function(options, callback) {
        var content = options.content;

        // setup for video.
        if (options.type === 'video') {
            if (options.url === '') {
                return;
            }

            content = method.videoContent(options.url);

            callback(content);
        }

        if (options.url !== '' && content === '') {
            var data = {
                'action': 'boomi_modal_url_request',
                'security': boomiModalObject.nonce,
                'url': options.url
            };

            jQuery.post(boomiModalObject.ajaxURL, data, function(response) {
                if (response.success === false) {
                    callback(response.data);
                } else {
                    callback(response.data);
                }
            });
        } else {
            callback(content);
        }
    };

    // Close the modal.
    method.close = function() {
        $modal.hide();
        $overlay.hide();
        $content.empty();
        jQuery(window).unbind('resize.modal');
    };

    // setup video content.
    method.videoContent = function(url) {
        var html = '';

        html += '<div class="boomi-modal-video-overlay" id="boomi-modal-video-overlay">';
        html += '<div class="video-player">';
        html += '<video width="100%" height="auto" id="boomi-modal-video-player" class="modal-video" controls autoplay loop muted>';
        html += '<source type="video/mp4" src="' + url + '" />';
        html += '</video>';
        html += '</div>';
        html += '</div>';

        return html;
    };

    // Generate the HTML and add it to the document.
    $overlay = jQuery('<div id="boomi-modal-overlay"></div>');
    $modal = jQuery('<div id="boomi-modal"></div>');
    $content = jQuery('<div id="boomi-modal-content" class="boomi-modal-content"></div>');
    $close = jQuery('<a id="boomi-modal-close" href="#"><span class="dashicons dashicons-dismiss"></span></a>');
    $spinner = jQuery('<div id="boomi-modal-spinner"><img src="' + boomiModalObject.url + 'images/spinner.svg" /></div>');

    $modal.hide();
    $overlay.hide();
    $spinner.hide();

    $modal.append($content, $close);

    jQuery(document).ready(function() {
        jQuery('body').append($overlay, $modal, $spinner);
    });

    $close.click(function(e) {
        e.preventDefault();
        method.close();
    });

    $overlay.click(function(e) {
        e.preventDefault();
        method.close();
    });

    return method;
}());